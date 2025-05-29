<?php
session_start();

// إذا كان المستخدم قد قام بتسجيل الدخول مسبقًا
if (isset($_SESSION['uid'])) {
    header('location:home.php');
    exit();
}

$msg = "";
if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $pass = $_POST['password'];

    include 'conn.php';

    // إعداد الاستعلام مع Prepared Statements
    $sql = "SELECT * FROM users WHERE uname = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uname, $uname); // ربط المتغيرات
    $stmt->execute();
    $result = $stmt->get_result();
    
    // إذا تم العثور على المستخدم
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // التحقق من كلمة المرور باستخدام password_verify
        if (password_verify($pass, $user['pass'])) {
            // حفظ بيانات الجلسة
            $_SESSION['id'] = $user['id'];
            $_SESSION['uname'] = $user['name'];
            $_SESSION['ulevel'] = $user['level'];
            
            header('location:home.php');
            exit();
        } else {
            $msg = "Incorrect username or password.";
        }
    } else {
        $msg = "User does not exist.";
    }
    

}
?>

<html>
<head><title>Log in Page</title></head>
<body style="background-color:powderblue;">
<div align="center">
    <fieldset>
        <legend><h1>Log in</h1></legend>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username/Email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input type="submit" name="submit" value="Log in"><br><br>

            <?php if ($msg): ?>
                <div style="color: red;"><?php echo $msg; ?></div>
            <?php endif; ?>

            <label>You don't have an account yet? </label><a href="signup.php">Sign Up</a>
        </form>
    </fieldset>
</div>
</body>
</html>
