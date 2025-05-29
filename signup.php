<?php
session_start();
$msg = "";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $uname = $_POST['username'];
    $email = $_POST['email'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    if ($pass1 !== $pass2) {
        $msg = "Mismatched passwords";
    } else {
        include 'conn.php';
        
        // التحقق من أن اسم المستخدم أو البريد الإلكتروني غير موجودين مسبقًا
        $sql_check = "SELECT * FROM users WHERE uname='$uname' OR email='$email'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $msg = "Username or Email already exists!";
        } else { 
            // رفع صورة البروفايل
            $profileImage = $_FILES['profile_image']['name'];
            $profileImageTmp = $_FILES['profile_image']['tmp_name'];
            $profileImagePath = "uploads/" . $profileImage;
            move_uploaded_file($profileImageTmp, $profileImagePath);

            // تشفير كلمة المرور
            $hashed_pass = password_hash($pass1, PASSWORD_DEFAULT);

            // إدخال البيانات في قاعدة البيانات
            $sql = "INSERT INTO users (name, uname, pass, email, level, profile_image) 
                    VALUES ('$name', '$uname', '$hashed_pass', '$email', 0, '$profileImagePath')";
            $query = $conn->query($sql);
            
            if ($query) {
                $user_id = $conn->insert_id;
                $_SESSION['uid'] = $user_id;
                $_SESSION['uname'] = $name;
                $_SESSION['ulevel'] = 0;

                header('location:home.php');
            } else {
                $msg = "Error during registration. Please try again.";
            }
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body style="background-color:powderblue;">
    <div align="center">
    <fieldset>
        <legend><h1>Sign Up</h1></legend>
        <form action="signup.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required> <br><br>
            <input type="email" name="email" placeholder="Email" required> <br><br>
            <input type="text" name="username" placeholder="Username" required> <br><br>
            <input type="password" name="password1" placeholder="Password" required> <br><br>
            <input type="password" name="password2" placeholder="Re-Password" required> <br><br>
            <input type="file" name="profile_image" required> <br><br>
            <input type="submit" name="submit" value="Register"> <br><br>
            <?php echo $msg; ?>
            <font>You have an account? </font><a href="login.php">Login</a>
        </form>
    </fieldset>
    </div>
</body>
</html>
