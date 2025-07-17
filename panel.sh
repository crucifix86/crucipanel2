#!/bin/bash

# ANSI color codes for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
RESET='\033[0m'

# Error checking helper function
error_exit() {
    echo -e "${RED}Error: $1${RESET}" >&2
    exit 1
}

# Function to check if a command exists
command_exists() {
  command -v "$1" >/dev/null 2>&1
}

# Set admin user details
ADMIN_USERNAME="admin"
ADMIN_EMAIL="randomperson@gmail.com"
ADMIN_FULLNAME="randomdev"
PANEL_LOGIN_FILE="/root/panellogin.txt"

# --- OS Detection and Script Execution ---
if [[ $(command -v apt) ]]; then
    echo -e "${GREEN}Detected Debian/Ubuntu-based system (using apt).${RESET}"
    
    # Set variables
    SOURCE_URL="https://github.com/crucifix86/crucipanel2/archive/refs/heads/master.zip"
    DEST_DIR="/var/www/html"
    TEMP_ZIP="panel.zip"
    EXTRACTED_DIR="crucipanel2-master"
    FINAL_DIR="panel"
    ENV_EXAMPLE_FILE="$DEST_DIR/$FINAL_DIR/.env.example"
    ENV_FILE="$DEST_DIR/$FINAL_DIR/.env"
    PANEL_DIR="$DEST_DIR/$FINAL_DIR"
    APACHE_DEFAULT_SITE="/etc/apache2/sites-available/000-default.conf"
    APACHE_CONF="/etc/apache2/apache2.conf"
    SQL_FILE_URL="http://havenpwi.net/install2/Installer/panel/dbo.sql"
    SQL_FILE_LOCAL="dbo.sql"
    COMPOSER_INSTALLER_URL="https://getcomposer.org/installer"
    COMPOSER_INSTALLER="composer-installer.php"
    COMPOSER_PATH="/usr/local/bin/composer"
    APACHE_CONF_URL="http://havenpwi.net/install2/Installer/panel/apache2.conf"
    APACHE_CONF_LOCAL="apache2.conf"
    MYSQL_PATH="/usr/bin/mysql"
    PHP_PATH="/usr/bin/php"
    WGET_PATH="/usr/bin/wget"
    UNZIP_PATH="/usr/bin/unzip"
    SED_PATH="/usr/bin/sed"
    CHMOD_PATH="/usr/bin/chmod"
    MV_PATH="/usr/bin/mv"
    SYSTEMCTL_PATH="/usr/bin/systemctl"
    USER_AGENT="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
    WEB_SERVER_USER=""

    # Function to download a file
    download_file() {
        local url="$1"
        local destination="$2"

        echo "Downloading $url to $destination"
        if ! wget -N -U "$USER_AGENT" "$url" -O "$destination"; then
            echo -e "${RED}Failed to download $url${RESET}"
            return 1
        fi
        return 0
    }

    # Function to get database credentials from user
    get_database_credentials() {
        echo -e "${YELLOW}Please enter your MariaDB/MySQL database credentials:${RESET}"
        
        read -p "Database Username: " DB_USERNAME
        while [[ -z "$DB_USERNAME" ]]; do
            echo -e "${RED}Username cannot be empty. Please try again.${RESET}"
            read -p "Database Username: " DB_USERNAME
        done
        
        read -s -p "Database Password: " DB_PASSWORD
        echo  # Add newline after password input
        while [[ -z "$DB_PASSWORD" ]]; do
            echo -e "${RED}Password cannot be empty. Please try again.${RESET}"
            read -s -p "Database Password: " DB_PASSWORD
            echo
        done
        
        read -p "Database Name (default: pw): " DB_DATABASE
        if [[ -z "$DB_DATABASE" ]]; then
            DB_DATABASE="pw"
        fi
        
        read -p "Database Host (default: localhost): " DB_HOST
        if [[ -z "$DB_HOST" ]]; then
            DB_HOST="localhost"
        fi
        
        read -p "Database Port (default: 3306): " DB_PORT
        if [[ -z "$DB_PORT" ]]; then
            DB_PORT="3306"
        fi
        
        echo -e "${GREEN}Database credentials configured:${RESET}"
        echo -e "${GREEN}  Host: $DB_HOST${RESET}"
        echo -e "${GREEN}  Port: $DB_PORT${RESET}"
        echo -e "${GREEN}  Database: $DB_DATABASE${RESET}"
        echo -e "${GREEN}  Username: $DB_USERNAME${RESET}"
        echo -e "${GREEN}  Password: [HIDDEN]${RESET}"
        
        read -p "Are these settings correct? (y/n): " confirm
        if [[ $confirm != [yY] && $confirm != [yY][eE][sS] ]]; then
            echo "Please run the script again with correct credentials."
            exit 1
        fi
    }

    # Get database credentials from user
    get_database_credentials

    # 1. Check and install unzip if missing
    echo "Checking if unzip is installed..."
    if ! command_exists unzip; then
        echo "unzip is not installed. Installing now..."
        if ! sudo apt install -y unzip; then
            error_exit "Failed to install unzip. Please install it manually."
        fi
    else
        echo "unzip is already installed."
    fi

    # 2. Download the ZIP file
    echo "Downloading the ZIP file..."
    if ! download_file "$SOURCE_URL" "$TEMP_ZIP"; then
        error_exit "Failed to download the ZIP file."
    fi
    
    # 3. Check if destination directory exists, if not, create it
    if [ ! -d "$DEST_DIR" ]; then
        echo "Creating directory: $DEST_DIR"
        sudo mkdir -p "$DEST_DIR"
        if [ ! -d "$DEST_DIR" ]; then
            error_exit "Failed to create the destination directory: $DEST_DIR"
        fi
    fi
    
    # 4. Extract the ZIP file
    echo "Extracting the ZIP file to $DEST_DIR..."
    if ! "$UNZIP_PATH" -q "$TEMP_ZIP" -d "$DEST_DIR"; then
        error_exit "Failed to extract the ZIP file."
    fi

    # 5. Rename the extracted directory
    echo "Renaming directory to '$FINAL_DIR'..."
    if ! "$MV_PATH" "$DEST_DIR/$EXTRACTED_DIR" "$DEST_DIR/$FINAL_DIR"; then
        error_exit "Failed to rename the extracted directory."
    fi

    # 6. Modify .env.example and rename to .env
    echo "Updating database settings in $ENV_EXAMPLE_FILE..."
    if [ ! -f "$ENV_EXAMPLE_FILE" ]; then
        error_exit "File not found: $ENV_EXAMPLE_FILE"
    fi

    "$SED_PATH" -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" "$ENV_EXAMPLE_FILE"
    "$SED_PATH" -i "s/DB_PORT=.*/DB_PORT=$DB_PORT/" "$ENV_EXAMPLE_FILE"
    "$SED_PATH" -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" "$ENV_EXAMPLE_FILE"
    "$SED_PATH" -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" "$ENV_EXAMPLE_FILE"
    "$SED_PATH" -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" "$ENV_EXAMPLE_FILE"

    echo "Renaming $ENV_EXAMPLE_FILE to $ENV_FILE"
    if ! "$MV_PATH" "$ENV_EXAMPLE_FILE" "$ENV_FILE"; then
        error_exit "Failed to rename $ENV_EXAMPLE_FILE to $ENV_FILE"
    fi

    # 7. Install Composer 2
    echo "Installing Composer 2..."
    if command_exists composer; then
        echo "Composer found, Checking version"
        COMPOSER_VERSION=$(composer --version | awk '{print $3}')
        if [[ "$COMPOSER_VERSION" =~ ^1\. ]] ; then
            echo "Composer 1 found, uninstalling"
            if ! sudo apt remove composer -y; then
                error_exit "Failed to remove composer 1, please do so manually"
            fi
        else
            echo "Composer 2 or greater found, not uninstalling"
        fi
    fi
    
    echo "Downloading Composer installer..."
    if ! download_file "$COMPOSER_INSTALLER_URL" "$COMPOSER_INSTALLER"; then
        error_exit "Failed to download Composer installer."
    fi

    echo "Running Composer installer..."
    if ! "$PHP_PATH" "$COMPOSER_INSTALLER" --install-dir=/usr/local/bin --filename=composer; then
        error_exit "Failed to run Composer installer."
    fi
    rm "$COMPOSER_INSTALLER"
    
    # 8. Set permissions for Laravel directories
    echo "Setting permissions for Laravel directories..."
    cd "$PANEL_DIR" || error_exit "Failed to change directory to: $PANEL_DIR"

    if ! "$CHMOD_PATH" -R 777 storage bootstrap app config; then
        error_exit "Failed to set permissions for Laravel directories."
    fi

    # 9. Download the SQL file
    echo "Downloading the SQL file..."
    if ! download_file "$SQL_FILE_URL" "$SQL_FILE_LOCAL"; then
        error_exit "Failed to download the SQL file."
    fi

    # 10. Import the SQL file
    echo "Importing the SQL file..."
    if ! "$MYSQL_PATH" -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < "$SQL_FILE_LOCAL"; then
        error_exit "Failed to import the SQL file."
    fi
    
    # 11. Run Laravel setup commands in Panel Directory
    echo "Running Laravel setup commands..."
    if ! "$COMPOSER_PATH" install --optimize-autoloader --no-dev; then
        error_exit "composer install failed."
    fi

    if ! "$PHP_PATH" artisan config:cache; then
        error_exit "php artisan config:cache failed"
    fi

    if ! "$COMPOSER_PATH" install; then
        error_exit "composer install failed"
    fi

    # Force migration in production without confirmation
    if ! "$PHP_PATH" artisan migrate --force; then
        error_exit "php artisan migrate failed."
    fi

    # Force seeding in production without confirmation  
    if ! "$PHP_PATH" artisan db:seed --class=ServiceSeeder --force; then
        error_exit "php artisan db:seed failed"
    fi

    if ! "$PHP_PATH" artisan key:generate --force; then
        error_exit "php artisan key:generate failed."
    fi
    
    # 12. Create admin user and capture password
    echo "Creating admin user..."
    # Capture the output of the command, including the generated password
    ADMIN_OUTPUT=$(echo -e "admin\nrandomperson@gmail.com\nrandomdev\n" | "$PHP_PATH" artisan pw:createAdmin)

    # Extract the password using grep (adjust the pattern if needed)
    ADMIN_PASSWORD=$(echo "$ADMIN_OUTPUT" | grep -oP '(?<=Password: ).*')

    if [ -z "$ADMIN_PASSWORD" ]; then
        error_exit "Failed to extract the password from the output."
    fi
    
    echo -e "${GREEN}Admin user created:${RESET}"
    echo -e "${GREEN}  Username: ${ADMIN_USERNAME}${RESET}"
    echo -e "${GREEN}  Email: ${ADMIN_EMAIL}${RESET}"
    echo -e "${GREEN}  Full Name: ${ADMIN_FULLNAME}${RESET}"
    echo -e "${GREEN}  Password: ${ADMIN_PASSWORD}${RESET}"

    echo -e "Saving admin credentials to: ${PANEL_LOGIN_FILE}"
    echo "Username: $ADMIN_USERNAME" > "$PANEL_LOGIN_FILE"
    echo "Email: $ADMIN_EMAIL" >> "$PANEL_LOGIN_FILE"
    echo "Full Name: $ADMIN_FULLNAME" >> "$PANEL_LOGIN_FILE"
    echo "Password: $ADMIN_PASSWORD" >> "$PANEL_LOGIN_FILE"
    if ! cat "$PANEL_LOGIN_FILE"; then
        error_exit "Failed to save admin credentials to: ${PANEL_LOGIN_FILE}"
    fi

    # 13. Modify Apache config
    echo "Modifying Apache configuration..."
    # Download new apache config
    echo "Downloading new apache2.conf..."
    if ! download_file "$APACHE_CONF_URL" "$APACHE_CONF_LOCAL"; then
        error_exit "Failed to download new apache2.conf."
    fi
    # Replace old apache config with new
    echo "Replacing old apache2.conf with new one..."
    if ! sudo mv "$APACHE_CONF_LOCAL" "$APACHE_CONF"; then
        error_exit "Failed to replace old apache2.conf with new one."
    fi
    if [ -f "$APACHE_DEFAULT_SITE" ]; then
        sed -i "s|DocumentRoot /var/www/html|DocumentRoot /var/www/html/panel/public|" "$APACHE_DEFAULT_SITE"
    fi
    
    # 14. Enable mod_rewrite
    echo "Enabling mod_rewrite..."
    if ! sudo a2enmod rewrite; then
        error_exit "Failed to enable mod_rewrite"
    fi
    
    # 15. Restart apache2 service
    echo "Restarting apache2 service..."
    if ! sudo systemctl restart apache2; then
        error_exit "Failed to restart apache2 service."
    fi
    
    # 16. Remove temporary files
    echo "Removing temporary SQL file '$SQL_FILE_LOCAL'..."
    rm "$SQL_FILE_LOCAL"
    echo "Removing temporary ZIP file '$TEMP_ZIP'..."
    rm "$TEMP_ZIP"
    
    # Determine web server user
    WEB_SERVER_USER=$(ps -eo user,group,comm | grep -E '(apache2|www-data|nginx)' | awk '{print $1}' | uniq)
    if [ -z "$WEB_SERVER_USER" ]; then
        echo -e "${RED}Could not automatically determine web server user. Please set WEB_SERVER_USER manually.${RESET}"
        exit 1
    fi

    chown -R "$WEB_SERVER_USER":"$WEB_SERVER_USER" /var/www/html/panel
    chmod 755 /var/www/html/panel

    echo -e "${GREEN}============================================${RESET}"
    echo -e "${GREEN}Installation completed successfully!${RESET}"
    echo -e "${GREEN}Panel is now located at: $DEST_DIR/$FINAL_DIR${RESET}"
    echo -e "${GREEN}Admin credentials saved to: $PANEL_LOGIN_FILE${RESET}"
    echo -e "${GREEN}============================================${RESET}"
else
    echo -e "${RED}Unsupported OS. Please use a Debian/Ubuntu based distribution.${RESET}"
    exit 1
fi
