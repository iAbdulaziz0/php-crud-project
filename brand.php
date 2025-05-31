<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Brands</title>
</head>
<body style="background-color:powderblue;">
    <div align="center">
        <fieldset>
    <h>Add Brand Laptop</h2> <br><br>
    <form method="post">
        <label> Brand :</label>
        <input type="text" name="brand" required> <br><br>
        <input type="submit" name="insert" value="Insert">
    </form>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "laptopdb";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }

    
    if (isset($_POST['insert'])) {
        $brand = $_POST['brand'];

        
        $sql = "INSERT INTO brand (bname) VALUES ('$brand')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>تم إدخال العلامة التجارية بنجاح</p>";
        } else {
            echo "<p>حدث خطأ: " . $conn->error . "</p>";
        }
    }

    
    $conn->close();
    ?>
    </fieldset>
    </div>
</body>
</html>