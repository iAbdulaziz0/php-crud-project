<?php
session_start();  // تأكد من بداية الجلسة
include 'conn.php';  // تضمين الاتصال بقاعدة البيانات

?>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Device Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="device-details">
    <?php
    $id = $_GET['id'];
    include 'conn.php';
    $sql = "SELECT * FROM laptop WHERE no=$id";
    $query = $conn->query($sql);
    echo '<div class="device-container">';
    $rslt = $query->fetch_assoc();
    $sql2 = "SELECT bname FROM brand WHERE bno=" . $rslt['bno'];
    $query2 = $conn->query($sql2);
    $rslt2 = $query2->fetch_assoc();

    echo '<h1> - جميع التفاصيل </h1>';
    echo '<table>';
    echo '<tr><td><strong>العلامة التجارية:</strong> ' . $rslt2['bname'] . '</td></tr>';
    echo '<tr><td><strong>الموديل:</strong> ' . $rslt['model'] . '</td></tr>';
    echo '<tr><td><strong>المعالج:</strong> ' . $rslt['processor'] . '</td></tr>';
    echo '<tr><td><strong>الذاكرة العشوائية:</strong> ' . $rslt['ram'] . '</td></tr>';
    echo '<tr><td><strong>التخزين:</strong> ' . $rslt['storage'] . '</td></tr>';
    echo '<tr><td><img src="' . $rslt['image'] . '" class="device-image"></td></tr>';
    echo '<tr><td><a href="home.php"><button class="back-btn">عودة</button></a></td></tr>';
    echo '</table>';
    echo '</div>';

    $conn->close();
    ?>
</body>
</html>
