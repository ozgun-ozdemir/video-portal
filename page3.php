<?php
// page3.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = $_POST['link'];
    $description = $_POST['description'];
    $date_added = date('Y-m-d H:i:s');

    $conn = new mysqli('localhost', 'root', '', 'video_portal');
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "INSERT INTO video (link, description, date_added, is_deleted) VALUES ('$link', '$description', '$date_added', 0)";
    if ($conn->query($sql) === TRUE) {
        header("Location: page2.php");
    } else {
        echo "Ekleme hatası: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Video Ekle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
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
            top: 0; 
            z-index: 1000;
        }

        .header h1 {
            margin: 0;
        }

        .header .add-video a {
            margin-right: 95px;
            text-decoration: none;
            padding: 10px 10px;
            background-color: #bcbcbc;
            color: black;
            border-radius: 100px;
            border: 2px solid black;
            display: inline-block;
            line-height: 10px;
            width: 10px;
            height: 10px;
            font-weight: bold;
        }

        .header .add-video a:hover {
            background-color: #999999;
        }

        h2 {
            text-align: center;
        }

        .main-content {
            margin-top: 100px; 
        }

        .video-form h2 {
            margin-top: 0;
            text-align: center;
        }

        .container {
            margin-top: 50px;
            width: 70%;
            margin: 50px auto 0;
            padding: 50px;
            background-color: #fff;
            border: 2px solid black;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            text-align: right;  
        }

        .cancel-container {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: center;
        }

        .cancel-button {
            background-color: #dc3545;
            color: #fff;
            padding: 10px 10px;
            border-radius: 100px;
            border: 2px solid black;
            text-decoration: none;
            display: inline-block;
            line-height: 10px;
            width: 10px;
            height: 10px;
            font-weight: bold
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        .cancel-text {
            margin-top: 5px;
            color: black;
            font-size: 13px;
        }

        .form-group {
            margin-top: 30px;
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 20%;
            margin-right: 10px;
        }

        .form-group input {
            width: 160%;
            padding: 10px;
            border: 2px solid black;
            box-sizing: border-box;
            
        }

        .save-button {
            background-color: #f2f2f2;
            border: 2px solid black;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 0 auto;
            margin-top: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            font-weight: bold
        }

        .save-button:hover {
            background-color: #dcdcdc;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Video Admin</h1>
        <div class="add-video">
            Yeni Video Ekle <a href="page3.php">+</a>
        </div>
    </div>
    <div class="main-content">
        <h2>Video Ekleme</h2>
        <div class="container">
            <div class="cancel-container">
                <a href="page2.php" class="cancel-button">X</a>
                <div class="cancel-text">Vazgeç</div>
            </div>
            <div class="video-form">
                <form method="POST">
                    <div class="form-group">
                        <label for="link">Youtube Link</label>
                        <input type="url" id="link" name="link" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Video Tanımı</label>
                        <input id="description" name="description" required></input>
                    </div>
                    <button type="submit" class="save-button">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
