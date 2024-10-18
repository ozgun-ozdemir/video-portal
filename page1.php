<?php
// page1.php
session_start();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'video_portal');
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: page2.php");
        exit();
    } else {
        $message = "Geçersiz kullanıcı adı veya şifre";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .header {
            width: 100%; 
            background-color: #fff;
            border: 2px solid black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 0; 
            z-index: 1000;
        }

        .header h1 {
            margin: 0;
        }
        
        .container {
            padding: 50px;
            background-color: #fff;
            border: 2px solid black;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 180px;
            text-align: center; 
        }

        .container h2 {
            margin: 0 0 50px;
            text-align: center;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            margin-right: 50px;
            margin-left: 50px;
            justify-content: center; 
        }

        .form-group label {
            width: 100px;
            margin-right: 20px;
            text-align: right;  
        }

        .form-group input {
            padding: 10px;
            border: 2px solid black;
        }

        .form-group button{
            padding: 10px 20px;
            border: 2px solid black;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            color: black;
            font-size: 16px;
            background-color: #f2f2f2;
            margin: 50px auto 0;
            display: block;
            cursor: pointer;
            font-weight: bold
            
        }

        .form-group button:hover  {
            background-color: #dcdcdc; 
        }

        .alert {
            padding-top: 10px;
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Video Admin</h1>
    </div>
    <div class="container">
        <h2>Giriş</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Giriş Yap</button>
            </div>
            <?php
        if (!empty($message)) {
            echo "<div class='alert'>$message</div>";
        }
        ?>
        </form>
    </div>
</body>
</html>
