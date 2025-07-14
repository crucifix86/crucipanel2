<%@ page contentType="text/html; charset=UTF-8"%>
<%@page import="java.lang.*"%>
<%@page import="java.sql.*"%>
<%@page import="java.util.*"%>
<%@page import="java.security.*"%>
<%@page import="org.apache.commons.logging.Log"%>
<%@page import="org.apache.commons.logging.LogFactory"%>
<%@page import="org.apache.catalina.util.*"%>
<%@page import="com.goldhuman.util.LocaleUtil"%>
<%@include file="WEB-INF/.pwadminconf.jsp"%>

<%!
    String pw_encode(String salt, MessageDigest alg)
	{
		alg.reset();
        alg.update(salt.getBytes());
        byte[] digest = alg.digest();
        salt = Base64.encode(digest).toString();
        return salt;
   	}
%>

<%
	boolean allowed = false;

	if(request.getSession().getAttribute("ssid") == null)
	{
		out.println("<p class=\"has-text-right has-text-danger\"><strong>Login for Account administration...</strong></p>");
	}
	else
	{
		allowed = true;
	}

	String message = "";
	if(request.getParameter("action") != null)
	{
			String action = new String(request.getParameter("action"));

			if(action.compareTo("adduser") == 0)
			{
				String getlogin = request.getParameter("getlogin");
				String login = getlogin.toLowerCase();
                String getmail = request.getParameter("getmail");
                String mail = getmail.toLowerCase();
				String password = request.getParameter("password");

				if(login.length() > 0 && password.length() > 0)
				{
					if(login.length() < 4 || login.length() > 10 || password.length() < 4 || password.length() > 10)
					{
						message = "<span class=\"has-text-danger\">Only 4-10 Characters</span>";
					}
					else
					{
						String alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
						boolean check = true;
						char c;
						for(int i=0; i<login.length(); i++)
						{
							c = login.charAt(i);
							if (alphabet.indexOf(c) == -1)
							{
								check = false;
								break;
							}
						}
						for(int i=0; i<password.length(); i++)
						{
							c = password.charAt(i);
							if (alphabet.indexOf(c) == -1)
							{
								check = false;
								break;
							}
						}

						if(!check)
						{
							message = "<span class=\"has-text-danger\">Forbidden Characters</span>";
						}
						else
						{
							try
							{
								Class.forName("com.mysql.jdbc.Driver").newInstance();
								Connection connection = DriverManager.getConnection("jdbc:mysql://" + db_host + ":" + db_port + "/" + db_database, db_user, db_password);
								Statement statement = connection.createStatement();
								ResultSet rs = statement.executeQuery("SELECT * FROM users WHERE name='" + login + "'");
								int count = 0;

								while (rs.next())
								{
									count++;
								}
								if(count > 0)
								{
									message = "<span class=\"has-text-danger\">User Already Exists</span>";
								}
								else
								{
									password = pw_encode(login + password, MessageDigest.getInstance("MD5"));
									rs = statement.executeQuery("CALL adduser('" + login + "', '" + password + "', '0', '0', '0', '0', '" + mail + "', '0', '0', '0', '0', '0', '0', '0', NULL, '', '" + password + "')");
									message = "<span class=\"has-text-success\">Account Created</span>";
								}

								rs.close();
								statement.close();
								connection.close();
							}
							catch(Exception e)
							{
								message = "<span class=\"has-text-danger\"><strong>Connection to MySQL Database Failed</strong></span>";
							}
						}
					}
				}
			}

			if(action.compareTo("passwd") == 0)
			{
				String getlogin = request.getParameter("getlogin");
                String login = getlogin.toLowerCase();
				String password_old = request.getParameter("password_old");
				String password_new = request.getParameter("password_new");

				if(login.length() > 0 && password_old.length() > 0 && password_new.length() > 0)
				{
					if(password_new.length() < 4 || password_new.length() > 10)
					{
						message = "<span class=\"has-text-danger\">Only 4-10 Characters</span>";
					}
					else
					{
						String alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
						boolean check = true;
						char c;
						for(int i=0; i<password_new.length(); i++)
						{
							c = password_new.charAt(i);
							if (alphabet.indexOf(c) == -1)
							{
								check = false;
								break;
							}
						}

						if(!check)
						{
							message = "<span class=\"has-text-danger\">Forbidden Characters</span>";
						}
						else
						{
							try
							{
								Class.forName("com.mysql.jdbc.Driver").newInstance();
								Connection connection = DriverManager.getConnection("jdbc:mysql://" + db_host + ":" + db_port + "/" + db_database, db_user, db_password);
								Statement statement = connection.createStatement();
								ResultSet rs = statement.executeQuery("SELECT ID, passwd, email FROM users WHERE name='" + login + "'");
                                String email_stored = "";
								String password_stored = "";
								String id_stored = "";
								int count = 0;
								while(rs.next())
								{
                                    email_stored = rs.getString("email");
									id_stored = rs.getString("ID");
									password_stored = rs.getString("passwd");
									count++;
								}

								if(count <= 0)
								{
									message = "<span class=\"has-text-danger\">User Doesn't Exist</span>";
								}
								else
								{
									password_old = pw_encode(login + password_old, MessageDigest.getInstance("MD5"));

									rs = statement.executeQuery("CALL adduser('" + login + "_TEMP_USER', '" + password_old + "', '0', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', NULL, '', '" + password_old + "')");
									rs = statement.executeQuery("SELECT passwd FROM users WHERE name='" + login + "_TEMP_USER'");
									rs.next();
									password_old = rs.getString("passwd");

									statement.executeUpdate("DELETE FROM users WHERE name='" + login + "_TEMP_USER'");

									if(password_old.compareTo(password_stored) != 0)
									{
										message = "<span class=\"has-text-danger\">Old Password Mismatch</span>";
									}
									else
									{
										password_new = pw_encode(login + password_new, MessageDigest.getInstance("MD5"));

										statement.executeUpdate("LOCK TABLE users WRITE");
										statement.executeUpdate("DELETE FROM users WHERE name='" + login + "'");
										rs = statement.executeQuery("CALL adduser('" + login + "', '" + password_new + "', '0', '0', '0', '0', '" + email_stored + "', '0', '0', '0', '0', '0', '0', '0', NULL, '', '" + password_new + "')");
										statement.executeUpdate("UPDATE users SET ID='" + id_stored + "' WHERE name='" + login + "'");
										statement.executeUpdate("UNLOCK TABLES");

										message = "<span class=\"has-text-success\">Password Changed</span>";
									}
								}
								rs.close();
								statement.close();
								connection.close();
							}
							catch(Exception e)
							{
								message = "<span class=\"has-text-danger\"><strong>Connection to MySQL Database Failed</strong></span>";
							}
						}
					}
				}
			}

			if(action.compareTo("deluser") == 0)
			{
				if(request.getSession().getAttribute("ssid") == null)
				{
					message = "<span class=\"has-text-danger\">Access Denied</span>";
				}
				else
				{
					String type = request.getParameter("type");
					String ident = request.getParameter("ident");
					String character = request.getParameter("character");

					if(type.length() > 0 && ident.length() > 0 && character.length() > 0)
					{
						try
						{
							Class.forName("com.mysql.jdbc.Driver").newInstance();
							Connection connection = DriverManager.getConnection("jdbc:mysql://" + db_host + ":" + db_port + "/" + db_database, db_user, db_password);
							Statement statement = connection.createStatement();
							ResultSet rs;
							int count;

							if(type.compareTo("id") == 0)
							{
								rs = statement.executeQuery("SELECT ID FROM users WHERE ID='" + ident + "'");
								count = 0;
								while(rs.next())
								{
									count++;
								}
							}

							else
							{
								rs = statement.executeQuery("SELECT ID FROM users WHERE name='" + ident + "'");
								count = 0;
								while(rs.next())
								{
									ident = rs.getString("ID");
									count++;
								}
							}

							if(count <= 0)
							{
								message = "<span class=\"has-text-danger\">User Doesn't Exist</span>";
							}
							else
							{
								statement.executeUpdate("DELETE FROM users WHERE ID='" + ident + "'");
								message = "<span class=\"has-text-success\">Account Deleted</span><br><span class=\"has-text-danger\">Please Check for Existing Characters (ID " + ident + " - " + (15+Integer.parseInt(ident)) + ")</span>";
							}
								rs.close();
								statement.close();
								connection.close();
						}
						catch(Exception e)
						{
							message = "<span class=\"has-text-danger\"><strong>Connection to MySQL Database Failed</strong></span>";
						}
					}
				}
			}

			if(action.compareTo("changegm") == 0)
			{
				if(request.getSession().getAttribute("ssid") == null)
				{
					message = "<span class=\"has-text-danger\">Access Denied</span>";
				}
				else
				{
					String type = request.getParameter("type");
					String ident = request.getParameter("ident");
					String act = request.getParameter("act");

					if(type.length() > 0 && ident.length() > 0 && act.length() > 0)
					{
						try
						{
							Class.forName("com.mysql.jdbc.Driver").newInstance();
							Connection connection = DriverManager.getConnection("jdbc:mysql://" + db_host + ":" + db_port + "/" + db_database, db_user, db_password);
							Statement statement = connection.createStatement();
							ResultSet rs;
							int count;

							if(type.compareTo("id") == 0)
							{
								rs = statement.executeQuery("SELECT ID FROM users WHERE ID='" + ident + "'");
								count = 0;
								while(rs.next())
								{
									count++;
								}
							}

							else
							{
								rs = statement.executeQuery("SELECT ID FROM users WHERE name='" + ident + "'");
								count = 0;
								while(rs.next())
								{
									ident = rs.getString("ID");
									count++;
								}
							}

							if(count <= 0)
							{
								message = "<span class=\"has-text-danger\">User Doesn't Exist</span>";
							}
							else
							{
								rs = statement.executeQuery("SELECT userid FROM auth WHERE userid='" + ident + "'");
								count = 0;
								while(rs.next())
								{
									count++;
								}
								if(count > 0)
								{
									if(act.compareTo("delete") == 0)
									{
										statement.executeUpdate("DELETE FROM auth WHERE userid='" + ident + "'");
										message = "<span class=\"has-text-success\">GM Access Removed From User</span>";
									}
									else
									{
										message = "<span class=\"has-text-danger\">User Already Has GM Access</span>";
									}
								}
								else
								{
									if(act.compareTo("add") == 0)
									{
										rs = statement.executeQuery("call addGM('" + ident + "', '1')");
										message = "<span class=\"has-text-success\">GM Access Added For User</span>";
									}
									else
									{
										message = "<span class=\"has-text-danger\">User Doesn't Have GM Access</span>";
									}
								}
							}
								rs.close();
								statement.close();
								connection.close();
						}
						catch(Exception e)
						{
							message = "<span class=\"has-text-danger\"><strong>Connection to MySQL Database Failed</strong></span>";
						}
					}
				}
			}

			if(action.compareTo("addcubi") == 0)
			{
				if(request.getSession().getAttribute("ssid") == null)
				{
					message = "<span class=\"has-text-danger\">Access Denied</span>";
				}
				else
				{
					String type = request.getParameter("type");
					String ident = request.getParameter("ident");
					int amount = 0;
					try
					{
						amount = Integer.parseInt(request.getParameter("amount"));
					}
					catch(Exception e)
					{}

					if(type.length() > 0 && ident.length() > 0)
					{
						if(amount < 1 || amount > 999999)
						{
							message = "<span class=\"has-text-danger\">Invalid Amount (1-999999)</span>";
						}
						else
						{
							try
							{
								Class.forName("com.mysql.jdbc.Driver").newInstance();
								Connection connection = DriverManager.getConnection("jdbc:mysql://" + db_host + ":" + db_port + "/" + db_database, db_user, db_password);
								Statement statement = connection.createStatement();
								ResultSet rs;
								int count;

								if(type.compareTo("id") == 0)
								{
									rs = statement.executeQuery("SELECT ID FROM users WHERE ID='" + ident + "'");
									count = 0;
									while(rs.next())
									{
										count++;
									}
								}

								else
								{
									rs = statement.executeQuery("SELECT ID FROM users WHERE name='" + ident + "'");
									count = 0;
									while(rs.next())
									{
										ident = rs.getString("ID");
										count++;
									}
								}

								if(count <= 0)
								{
									message = "<span class=\"has-text-danger\">User Doesn't Exist</span>";
								}
								else
								{
									rs = statement.executeQuery("call usecash ( '" + ident + "' , 1, 0, 1, 0, '" + 100*amount + "', 1, @error)");
									message = "<span class=\"has-text-success\">" + amount + ".00 Cubi Gold Added</span><br><span class=\"has-text-danger\">Transaction May Take Up To 5 Minutes<br>Relog Required To Receive Cubi</span>";
								}
								rs.close();
								statement.close();
								connection.close();
							}
							catch(Exception e)
							{
								message = "<span class=\"has-text-danger\"><strong>Connection to MySQL Database Failed</strong></span>";
							}
						}
					}
				}
			}
	}
%>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="include/custom.css">
</head>
<body>

<div class="container">
    <% if (message != null && !message.isEmpty()) { %>
        <div class="notification <%= message.contains("has-text-success") ? "is-success" : "is-danger" %>">
            <%= message %>
        </div>
    <% } %>

    <div class="columns is-multiline">
        <div class="column is-one-third">
            <div class="box account-management-box">
                <h2 class="title is-4">Account Registration</h2>
                <form action="index.jsp?page=account&action=adduser" method="post">
                    <div class="field">
                        <label class="label">Login</label>
                        <div class="control">
                            <input class="input account-input" type="text" name="getlogin" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input account-input" type="password" name="password" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">E-Mail</label>
                        <div class="control">
                            <input class="input account-input" type="email" name="getmail" value="NOT_NEEDED">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary is-fullwidth account-button">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column is-one-third">
            <div class="box account-management-box">
                <h2 class="title is-4">Change Password</h2>
                <form action="index.jsp?page=account&action=passwd" method="post">
                    <div class="field">
                        <label class="label">Login</label>
                        <div class="control">
                            <input class="input account-input" type="text" name="getlogin" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Old Password</label>
                        <div class="control">
                            <input class="input account-input" type="password" name="password_old" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">New Password</label>
                        <div class="control">
                            <input class="input account-input" type="password" name="password_new" required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary is-fullwidth account-button">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <% if (allowed) { %>
        <div class="column is-one-third">
            <div class="box account-management-box">
                <h2 class="title is-4">Delete Account</h2>
                <form action="index.jsp?page=account&action=deluser" method="post">
                    <div class="field">
                        <label class="label">Type</label>
                        <div class="control">
                            <div class="select is-fullwidth account-select">
                                <select name="type">
                                    <option value="id">by ID</option>
                                    <option value="login">by Login</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Identifier</label>
                        <div class="control">
                            <input class="input account-input" type="text" name="ident" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Characters</label>
                        <div class="control">
                            <div class="select is-fullwidth account-select">
                                <select name="character">
                                    <option value="keep">Keep Characters</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary is-fullwidth account-button">Delete Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column is-one-third">
            <div class="box account-management-box">
                <h2 class="title is-4">Game Master Management</h2>
                <form action="index.jsp?page=account&action=changegm" method="post">
                    <div class="field">
                        <label class="label">Type</label>
                        <div class="control">
                            <div class="select is-fullwidth account-select">
                                <select name="type">
                                    <option value="id">by ID</option>
                                    <option value="login">by Login</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Identifier</label>
                        <div class="control">
                            <input class="input account-input" type="text" name="ident" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Action</label>
                        <div class="control">
                            <div class="select is-fullwidth account-select">
                                <select name="act">
                                    <option value="add">Grant GM</option>
                                    <option value="delete">Deny GM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary is-fullwidth account-button">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column is-one-third">
            <div class="box account-management-box">
                <h2 class="title is-4">Cubi Transfer</h2>
                <form action="index.jsp?page=account&action=addcubi" method="post">
                    <div class="field">
                        <label class="label">Type</label>
                        <div class="control">
                            <div class="select is-fullwidth account-select">
                                <select name="type">
                                    <option value="id">by ID</option>
                                    <option value="login">by Login</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Identifier</label>
                        <div class="control">
                            <input class="input account-input" type="text" name="ident" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Amount</label>
                        <div class="control">
                            <input class="input account-input" type="number" name="amount" required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary is-fullwidth account-button">Transfer Cubi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column is-full">
            <div class="box account-browse-box">
                <h1 class="title has-text-centered">Browse Accounts</h1>
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table is-fullwidth is-striped role-list-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Creation Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <%
                            try
                            {
                                Class.forName("com.mysql.jdbc.Driver").newInstance();
                                Connection connection = DriverManager.getConnection("jdbc:mysql://" + db_host + ":" + db_port + "/" + db_database, db_user, db_password);
                                Statement statement = connection.createStatement();
                                ResultSet rs;

                                rs = statement.executeQuery("SELECT DISTINCT userid FROM auth");
                                ArrayList<Integer> gm = new ArrayList<Integer>();

                                while(rs.next())
                                {
                                    gm.add(rs.getInt("userid"));
                                }

                                rs = statement.executeQuery("SELECT ID, name, creatime FROM users");
                                while(rs.next())
                                {
                                    if(gm.contains(rs.getInt("ID")))
                                    {
                                        out.print("<tr><td>" + rs.getString("ID") + "</td><td class=\"has-text-danger\">" + rs.getString("name") + "</td><td>" + rs.getString("creatime").substring(0, 16) + "</td></tr>");
                                    }
                                    else
                                    {
                                        out.print("<tr><td>" + rs.getString("ID") + "</td><td>" + rs.getString("name") + "</td><td>" + rs.getString("creatime").substring(0, 16) + "</td></tr>");
                                    }
                                }

                                rs.close();
                                statement.close();
                                connection.close();
                            }
                            catch(Exception e)
                            {
                                out.println("<tr><td colspan=\"3\" class=\"has-text-danger\"><strong>Connection to MySQL Database Failed</strong></td></tr>");
                            }
                            %>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <% } %>
    </div>
</div>

</body>
</html>