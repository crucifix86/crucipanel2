@section('title', ' - ' . __('Email Configuration'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('Email Configuration') }}</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-4xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="post" action="{{ route('admin.email.settings.post') }}">
                @csrf
                
                <div class="bg-white dark:bg-primary-darker rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Mail Driver Configuration</h2>
                    
                    <div class="mb-6">
                        <label for="mail_driver" class="block text-sm font-medium mb-2">Mail Driver</label>
                        <select id="mail_driver" name="mail_driver" class="form-select w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600" onchange="toggleMailFields(this.value)">
                            <option value="smtp" {{ $mailConfig['driver'] == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="mail" {{ $mailConfig['driver'] == 'mail' ? 'selected' : '' }}>PHP Mail (Free)</option>
                            <option value="sendmail" {{ $mailConfig['driver'] == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="log" {{ $mailConfig['driver'] == 'log' ? 'selected' : '' }}>Log (Testing only)</option>
                            <option value="mailgun" {{ $mailConfig['driver'] == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ $mailConfig['driver'] == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        </select>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Choose how emails should be sent</p>
                    </div>

                    <div id="driver-info" class="mb-4 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg {{ $mailConfig['driver'] == 'smtp' ? 'hidden' : '' }}">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            @if($mailConfig['driver'] == 'mail')
                                <strong>PHP Mail Selected:</strong> No additional configuration needed. Just set your From Email and Name below.
                            @elseif($mailConfig['driver'] == 'sendmail')
                                <strong>Sendmail Selected:</strong> Uses your server's sendmail binary. No SMTP configuration needed.
                            @elseif($mailConfig['driver'] == 'log')
                                <strong>Log Driver Selected:</strong> Emails will be saved to storage/logs/laravel.log for testing.
                            @else
                                <strong>Selected Driver:</strong> Configuration may be required based on the service.
                            @endif
                        </p>
                    </div>

                    <div id="smtp-fields" class="{{ $mailConfig['driver'] != 'smtp' ? 'hidden' : '' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="mail_host" class="block text-sm font-medium mb-2">SMTP Host</label>
                                <input type="text" id="mail_host" name="mail_host" value="{{ $mailConfig['host'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="smtp.gmail.com">
                            </div>
                            <div>
                                <label for="mail_port" class="block text-sm font-medium mb-2">SMTP Port</label>
                                <input type="number" id="mail_port" name="mail_port" value="{{ $mailConfig['port'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="587">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="mail_username" class="block text-sm font-medium mb-2">SMTP Username</label>
                                <input type="text" id="mail_username" name="mail_username" value="{{ $mailConfig['username'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="your-email@gmail.com">
                            </div>
                            <div>
                                <label for="mail_password" class="block text-sm font-medium mb-2">SMTP Password</label>
                                <input type="password" id="mail_password" name="mail_password" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="Leave blank to keep current">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">For Gmail, use an App Password</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="mail_encryption" class="block text-sm font-medium mb-2">Encryption</label>
                            <select id="mail_encryption" name="mail_encryption" class="form-select w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600">
                                <option value="tls" {{ $mailConfig['encryption'] == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ $mailConfig['encryption'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="" {{ !$mailConfig['encryption'] || $mailConfig['encryption'] == 'null' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <div class="border-t pt-4 mt-6">
                        <h3 class="text-lg font-semibold mb-4">Sender Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium mb-2">From Email Address</label>
                                <input type="email" id="mail_from_address" name="mail_from_address" value="{{ $mailConfig['from_address'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="noreply@yourdomain.com" required>
                            </div>
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium mb-2">From Name</label>
                                <input type="text" id="mail_from_name" name="mail_from_name" value="{{ $mailConfig['from_name'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="{{ config('pw-config.server_name') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-primary-darker rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Free Email Service Options</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">PHP Mail (100% Free)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Unlimited emails - No external service</p>
                            <div class="flex gap-2">
                                <button type="button" onclick="setPhpMailConfig()" class="btn btn-sm btn-secondary">Use PHP Mail</button>
                                <button type="button" onclick="showInstructions('phpmail')" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-question-circle"></i> Help
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>✓ No configuration needed</p>
                                <p>✓ Works on most servers</p>
                                <p>⚠️ May go to spam folder</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Gmail (Free)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Up to 500 emails/day</p>
                            <div class="flex gap-2">
                                <button type="button" onclick="setGmailConfig()" class="btn btn-sm btn-secondary">Use Gmail Settings</button>
                                <button type="button" onclick="showInstructions('gmail')" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-question-circle"></i> Help
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>1. Enable 2FA on your Google account</p>
                                <p>2. Generate app password at myaccount.google.com/apppasswords</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">SendGrid (Free tier)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">100 emails/day free</p>
                            <div class="flex gap-2">
                                <button type="button" onclick="setSendGridConfig()" class="btn btn-sm btn-secondary">Use SendGrid Settings</button>
                                <button type="button" onclick="showInstructions('sendgrid')" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-question-circle"></i> Help
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>1. Sign up at sendgrid.com</p>
                                <p>2. Create API key in Settings</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Mailgun (Free trial)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">5,000 emails/month for 3 months</p>
                            <div class="flex gap-2">
                                <button type="button" onclick="setMailgunConfig()" class="btn btn-sm btn-secondary">Use Mailgun Settings</button>
                                <button type="button" onclick="showInstructions('mailgun')" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-question-circle"></i> Help
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>1. Sign up at mailgun.com</p>
                                <p>2. Get SMTP credentials from domain settings</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Log Driver (Testing)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Emails saved to log file</p>
                            <div class="flex gap-2">
                                <button type="button" onclick="setLogConfig()" class="btn btn-sm btn-secondary">Use Log Driver</button>
                                <button type="button" onclick="showInstructions('log')" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-question-circle"></i> Help
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>Emails will be saved to storage/logs/laravel.log</p>
                                <p>Perfect for testing without sending real emails</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="testEmailConfig()" class="btn btn-secondary">
                        Test Configuration
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save Configuration
                    </button>
                </div>
            </form>
        </div>

        <!-- Instructions Modal -->
        <div id="instructionsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white mb-4"></h3>
                    <div id="modalContent" class="mt-2 text-sm text-gray-600 dark:text-gray-300"></div>
                    <div class="mt-4">
                        <button onclick="closeInstructions()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @push('scripts')
    <script>
        function toggleMailFields(driver) {
            const smtpFields = document.getElementById('smtp-fields');
            const driverInfo = document.getElementById('driver-info');
            const infoText = driverInfo.querySelector('p');
            
            if (driver === 'smtp') {
                smtpFields.classList.remove('hidden');
                driverInfo.classList.add('hidden');
            } else {
                smtpFields.classList.add('hidden');
                driverInfo.classList.remove('hidden');
                
                // Update info message based on driver
                let message = '';
                switch(driver) {
                    case 'mail':
                        message = '<strong>PHP Mail Selected:</strong> No additional configuration needed. Just set your From Email and Name below.';
                        break;
                    case 'sendmail':
                        message = '<strong>Sendmail Selected:</strong> Uses your server\'s sendmail binary. No SMTP configuration needed.';
                        break;
                    case 'log':
                        message = '<strong>Log Driver Selected:</strong> Emails will be saved to storage/logs/laravel.log for testing.';
                        break;
                    case 'mailgun':
                        message = '<strong>Mailgun Selected:</strong> You need to configure Mailgun API settings in your .env file.';
                        break;
                    case 'ses':
                        message = '<strong>Amazon SES Selected:</strong> You need to configure AWS credentials in your .env file.';
                        break;
                    default:
                        message = '<strong>Selected Driver:</strong> Configuration may be required based on the service.';
                }
                infoText.innerHTML = message;
            }
        }

        function setPhpMailConfig() {
            document.getElementById('mail_driver').value = 'mail';
            toggleMailFields('mail');
            alert('PHP Mail selected. No additional configuration needed! Just add your From Email and From Name below.');
        }

        function setGmailConfig() {
            document.getElementById('mail_driver').value = 'smtp';
            document.getElementById('mail_host').value = 'smtp.gmail.com';
            document.getElementById('mail_port').value = '587';
            document.getElementById('mail_encryption').value = 'tls';
            toggleMailFields('smtp');
            alert('Gmail settings applied. Enter your email and app password.');
        }

        function setSendGridConfig() {
            document.getElementById('mail_driver').value = 'smtp';
            document.getElementById('mail_host').value = 'smtp.sendgrid.net';
            document.getElementById('mail_port').value = '587';
            document.getElementById('mail_username').value = 'apikey';
            document.getElementById('mail_encryption').value = 'tls';
            toggleMailFields('smtp');
            alert('SendGrid settings applied. Enter your API key as the password.');
        }

        function setMailgunConfig() {
            document.getElementById('mail_driver').value = 'smtp';
            document.getElementById('mail_host').value = 'smtp.mailgun.org';
            document.getElementById('mail_port').value = '587';
            document.getElementById('mail_encryption').value = 'tls';
            toggleMailFields('smtp');
            alert('Mailgun settings applied. Enter your credentials.');
        }

        function setLogConfig() {
            document.getElementById('mail_driver').value = 'log';
            toggleMailFields('log');
            alert('Log driver selected. Emails will be saved to log file.');
        }

        function testEmailConfig() {
            const testEmail = prompt('Enter email address to send test email to:');
            if (!testEmail) return;

            fetch('{{ route('admin.email.test') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ test_email: testEmail })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Success: ' + data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }

        // Initialize the page with current driver
        document.addEventListener('DOMContentLoaded', function() {
            toggleMailFields(document.getElementById('mail_driver').value);
        });

        function showInstructions(service) {
            const modal = document.getElementById('instructionsModal');
            const title = document.getElementById('modalTitle');
            const content = document.getElementById('modalContent');
            
            const instructions = {
                phpmail: {
                    title: 'PHP Mail Setup Instructions',
                    content: `
                        <h4 class="font-semibold mb-2">How PHP Mail Works:</h4>
                        <p class="mb-3">PHP Mail uses your server's built-in mail() function. No external service required!</p>
                        
                        <h4 class="font-semibold mb-2">Requirements:</h4>
                        <ul class="list-disc ml-5 mb-3">
                            <li>PHP with mail() function enabled (most servers have this)</li>
                            <li>Valid "From" email address</li>
                        </ul>
                        
                        <h4 class="font-semibold mb-2">Setup Steps:</h4>
                        <ol class="list-decimal ml-5 mb-3">
                            <li>Click "Use PHP Mail" button</li>
                            <li>Enter your From Email (e.g., noreply@yourdomain.com)</li>
                            <li>Enter your From Name (e.g., Your Server Name)</li>
                            <li>Save Configuration</li>
                        </ol>
                        
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded mt-3">
                            <strong>Note:</strong> Emails may go to spam folder. To improve delivery:
                            <ul class="list-disc ml-5 mt-2">
                                <li>Use an email address from your domain</li>
                                <li>Set up SPF records in your DNS</li>
                                <li>Consider using SMTP for better delivery</li>
                            </ul>
                        </div>
                    `
                },
                gmail: {
                    title: 'Gmail Setup Instructions',
                    content: `
                        <h4 class="font-semibold mb-2">Gmail SMTP Setup:</h4>
                        <p class="mb-3">Gmail provides free SMTP service with up to 500 emails per day.</p>
                        
                        <h4 class="font-semibold mb-2">Step-by-Step Setup:</h4>
                        <ol class="list-decimal ml-5 mb-3">
                            <li class="mb-2">
                                <strong>Enable 2-Factor Authentication:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Go to <a href="https://myaccount.google.com/security" target="_blank" class="text-blue-600 hover:underline">Google Account Security</a></li>
                                    <li>Click on "2-Step Verification"</li>
                                    <li>Follow the setup process</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>Generate App Password:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Go to <a href="https://myaccount.google.com/apppasswords" target="_blank" class="text-blue-600 hover:underline">App Passwords</a></li>
                                    <li>Select "Mail" as the app</li>
                                    <li>Select "Other" as device and name it (e.g., "Laravel App")</li>
                                    <li>Copy the 16-character password</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>Configure in Panel:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Click "Use Gmail Settings"</li>
                                    <li>Username: your-email@gmail.com</li>
                                    <li>Password: The 16-character app password</li>
                                    <li>From Email: your-email@gmail.com</li>
                                </ul>
                            </li>
                        </ol>
                        
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded mt-3">
                            <strong>Benefits:</strong> Excellent delivery rate, reliable, and completely free for up to 500 emails/day.
                        </div>
                    `
                },
                sendgrid: {
                    title: 'SendGrid Setup Instructions',
                    content: `
                        <h4 class="font-semibold mb-2">SendGrid Free Tier Setup:</h4>
                        <p class="mb-3">SendGrid offers 100 free emails per day forever.</p>
                        
                        <h4 class="font-semibold mb-2">Setup Process:</h4>
                        <ol class="list-decimal ml-5 mb-3">
                            <li class="mb-2">
                                <strong>Create SendGrid Account:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Go to <a href="https://signup.sendgrid.com/" target="_blank" class="text-blue-600 hover:underline">SendGrid Signup</a></li>
                                    <li>Complete the registration (may require business info)</li>
                                    <li>Verify your email address</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>Create API Key:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Go to Settings → API Keys</li>
                                    <li>Click "Create API Key"</li>
                                    <li>Name it (e.g., "Laravel SMTP")</li>
                                    <li>Select "Full Access"</li>
                                    <li>Copy the API key (you won't see it again!)</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>Configure in Panel:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Click "Use SendGrid Settings"</li>
                                    <li>Username: <code>apikey</code> (literally this word)</li>
                                    <li>Password: Your API key</li>
                                    <li>From Email: Must be verified in SendGrid</li>
                                </ul>
                            </li>
                        </ol>
                        
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded mt-3">
                            <strong>Note:</strong> You may need to verify your sender email in SendGrid's Sender Authentication section.
                        </div>
                    `
                },
                mailgun: {
                    title: 'Mailgun Setup Instructions',
                    content: `
                        <h4 class="font-semibold mb-2">Mailgun Trial Setup:</h4>
                        <p class="mb-3">Mailgun offers 5,000 emails/month for 3 months trial.</p>
                        
                        <h4 class="font-semibold mb-2">Setup Steps:</h4>
                        <ol class="list-decimal ml-5 mb-3">
                            <li class="mb-2">
                                <strong>Create Mailgun Account:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Go to <a href="https://signup.mailgun.com/new/signup" target="_blank" class="text-blue-600 hover:underline">Mailgun Signup</a></li>
                                    <li>Complete registration</li>
                                    <li>Add credit card (required but won't be charged during trial)</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>Get SMTP Credentials:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Go to Sending → Domains</li>
                                    <li>Click on your sandbox domain</li>
                                    <li>Select "SMTP" tab</li>
                                    <li>Copy the SMTP credentials</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>Configure in Panel:</strong>
                                <ul class="list-disc ml-5 mt-1">
                                    <li>Click "Use Mailgun Settings"</li>
                                    <li>Username: Default SMTP Login from Mailgun</li>
                                    <li>Password: Default Password from Mailgun</li>
                                </ul>
                            </li>
                        </ol>
                        
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded mt-3">
                            <strong>Trial Note:</strong> After 3 months, you'll need to upgrade to continue using Mailgun.
                        </div>
                    `
                },
                log: {
                    title: 'Log Driver Instructions',
                    content: `
                        <h4 class="font-semibold mb-2">Log Driver Setup:</h4>
                        <p class="mb-3">Perfect for testing! Emails are saved to a file instead of being sent.</p>
                        
                        <h4 class="font-semibold mb-2">How It Works:</h4>
                        <ul class="list-disc ml-5 mb-3">
                            <li>All emails are written to: <code>storage/logs/laravel.log</code></li>
                            <li>No actual emails are sent</li>
                            <li>Great for development and testing</li>
                            <li>You can see the full email content in the log</li>
                        </ul>
                        
                        <h4 class="font-semibold mb-2">Setup:</h4>
                        <ol class="list-decimal ml-5 mb-3">
                            <li>Click "Use Log Driver"</li>
                            <li>Enter From Email and Name</li>
                            <li>Save Configuration</li>
                        </ol>
                        
                        <h4 class="font-semibold mb-2">View Emails:</h4>
                        <p class="mb-2">To see sent emails, check your log file:</p>
                        <code class="block bg-gray-100 dark:bg-gray-700 p-2 rounded mb-3">
                            tail -f storage/logs/laravel.log
                        </code>
                        
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded mt-3">
                            <strong>Perfect for:</strong> Testing password resets, notifications, and any email functionality without sending real emails.
                        </div>
                    `
                }
            };
            
            if (instructions[service]) {
                title.textContent = instructions[service].title;
                content.innerHTML = instructions[service].content;
                modal.classList.remove('hidden');
            }
        }
        
        function closeInstructions() {
            document.getElementById('instructionsModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('instructionsModal');
            if (event.target == modal) {
                closeInstructions();
            }
        }
    </script>
    @endpush
</x-hrace009.layouts.admin>