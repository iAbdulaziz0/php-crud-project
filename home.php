<?php
session_start();  // تأكد من بداية الجلسة
include 'conn.php';  // تضمين الاتصال بقاعدة البيانات
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="user-info">
            <?php
            // التحقق من وجود صورة المستخدم واسم المستخدم في الجلسة
            if (isset($_SESSION['uname'])) {
                $profile_image = isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'uploads/default.jpg';
                echo '<img src="' . htmlspecialchars($profile_image) . '" alt="Profile Image" class="profile-img">';
                echo '<h3>مرحباً، ' . htmlspecialchars($_SESSION['uname']) . '</h3>';
            } else {
                echo '<h3>مرحباً، زائر</h3>';
            }
            ?>
        </div>
        <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
    </div>

    <div class="search-bar">
        <form method="GET" action="home.php">
            <input type="text" name="search" placeholder="ابحث عن اللابتوب">
            <button type="submit">بحث</button>
        </form>
    </div>

    <h1 class="main-title">صفحة الرئيسية</h1>

    <hr>

    <?php
    if ($conn) {
        $sql = "SELECT brand.bname, laptop.model, laptop.image, laptop.no 
                FROM laptop 
                JOIN brand ON laptop.bno = brand.bno";

        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $search = $conn->real_escape_string(trim($_GET['search']));
            $sql .= " WHERE laptop.model LIKE '%$search%' OR brand.bname LIKE '%$search%'";
        }

        $query = $conn->query($sql);

        if ($query && $query->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Brand</th><th>Model</th><th>Image</th><th>Details</th><th>Edit</th><th>Delete</th></tr>';

            while ($row = $query->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["bname"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["model"]) . '</td>';
                echo '<td><img src="' . htmlspecialchars($row["image"]) . '" alt="Image" class="product-image"></td>';
                echo '<td><a href="details.php?id=' . htmlspecialchars($row["no"]) . '"><button class="details-btn">Details</button></a></td>';
                echo '<td><a href="edit.php?id=' . htmlspecialchars($row["no"]) . '"><button class="edit-btn">Edit</button></a></td>';
                echo '<td><a href="delete.php?id=' . htmlspecialchars($row["no"]) . '" onclick="return confirm(\'Are you sure you want to delete this?\')"><button class="delete-btn">Delete</button></a></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p class="no-data">لا توجد بيانات</p>';
        }
    } else {
        echo '<p>حدث خطأ في الاتصال بقاعدة البيانات.</p>';
    }

    $conn->close();
    ?>
</body>
</html>
