<?php
// page2.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'video_portal');
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "UPDATE video SET is_deleted=1 WHERE id=$delete_id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Video successfully deleted.";
    } else {
        $error_message = "Deletion error: " . $conn->error;
    }
}

$sql = "SELECT * FROM video WHERE is_deleted=0";
$result = $conn->query($sql);

function extractYouTubeID($url) {
    preg_match("/[\\?\\&]v=([^\\?\\&]+)/", $url, $matches);
    return $matches[1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; 
            padding-top: 90px; 
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
                
        .container {
            text-align: center;
            margin: 0 auto;
            padding-top: 40px; 
        }

        .container p {
            font-size: 20px; 
        }

        .container p.date {
            font-size: 12px; 
        }

        .container table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .container table th, .container table td {
            border: 2px solid black;
            padding: 8px;
            text-align: left;
        }

        .container table th:nth-child(1), .container table td:nth-child(1) {
            width: 100px; 
        }

        .container table th:nth-child(2), .container table td:nth-child(2) {
            width: 100%; 
        }

        .container .video-thumbnail {
            width: 120px;
            height: 90px;
        }

        .container .actions a {
            padding: 5px 10px;
            text-decoration: none;
            border: 2px solid black;
            background-color: #f2f2f2;
            color: black;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            font-weight: bold;
        }

        .container .actions a:hover {
            background-color: #dcdcdc;
        }

        .container .actions button {
            background-color: #dc3545;
            color: #fff;
            padding: 10px 11px;
            border-radius: 100px;
            border: 2px solid black;
            display: inline-block;
            text-decoration: none;
            line-height: 10px;
            font-weight: bold;      
        }

        .container .actions button:hover {
            background-color: #c82333;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Video Admin</h1>
        <div class="add-video">
            Add New Video <a href="page3.php">+</a>
        </div>
    </div>
    <div class="container">
        <table>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <a href="<?php echo $row['link']; ?>" target="_blank">
                            <img class="video-thumbnail" src="https://img.youtube.com/vi/<?php echo extractYouTubeID($row['link']); ?>/default.jpg" alt="Video Thumbnail">
                        </a>
                    </td>
                    <td colspan="2">
                        <p><?php echo $row['description']; ?></p>
                        <p class="date">Date Added: <?php echo date("d.m.Y", strtotime($row['date_added'])); ?></p>
                    </td>
                    <td class="actions">
                        <a href="page4.php?id=<?php echo $row['id']; ?>">Update</a>
                        <form method="POST" onsubmit="return confirmDelete();">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <td class="actions">
                                <button type="submit">X</button>
                            </td>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to remove this video?");
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>
