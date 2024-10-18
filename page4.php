<?php
// page4.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'video_portal');
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM video WHERE id=$id";
    $result = $conn->query($sql);
    $video = $result->fetch_assoc();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $link = $_POST['link'];
    $description = $_POST['description'];

    $conn = new mysqli('localhost', 'root', '', 'video_portal');
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "UPDATE video SET link='$link', description='$description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: page2.php");
    } else {
        echo "Güncelleme hatası: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Video Güncelle</title>
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

        .container {
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

        .video-form h2 {
            margin-top: 0;
            text-align: center;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-top: 30px;
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
        <h2>Video Güncelleme</h2>
        <div class="container">
            <div class="cancel-container">
                <a href="page2.php" class="cancel-button">X</a>
                <div class="cancel-text">Vazgeç</div>
            </div>
            <div class="video-form">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $video['id']; ?>">
                    <div class="form-group">
                        <label for="link">Youtube Link</label>
                        <input type="url" id="link" name="link" value="<?php echo $video['link']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Video Tanımı</label>
                        <input type="text" id="description" name="description" value="<?php echo $video['description']; ?>" required></input>
                    </div>
                    <button type="submit" class="save-button">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
