<!DOCTYPE html>
<html>
<head>
    <title>Temporary Login</title>
    <style>
        body {
            background: #0f0f23;
            color: #e2e8f0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: #1e293b;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #6366f1;
            margin-bottom: 30px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            background: #1a1a3a;
            border: 2px solid #334155;
            border-radius: 5px;
            color: #e2e8f0;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #6366f1;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #6366f1;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #8b5cf6;
        }
        .info {
            text-align: center;
            margin-top: 20px;
            color: #94a3b8;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Emergency Login</h2>
        <form method="POST" action="/login">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="name" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="info">
            This is a temporary login page without PIN requirement.
            <br>Use your normal username and password.
        </div>
    </div>
</body>
</html>