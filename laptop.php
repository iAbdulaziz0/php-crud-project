<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title> Laptop </title>
</head>
<body style="background-color:powderblue;">
    <div align="center">
    <fieldset>

    <legend> <h2> Add Laptop </h2> </legend>

    <form method="post" enctype="multipart/form-data">
        <label> Brand :</label>
        <select name="bno" required>
            <?php
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "laptopdb";

            
            $conn = new mysqli($servername, $username, $password, $dbname);

            
            if ($conn->connect_error) {
                die("فشل الاتصال: " . $conn->connect_error);
            }

            
            $brandQuery = "SELECT bno, bname FROM brand";
            $brandResult = $conn->query($brandQuery);
            if ($brandResult->num_rows > 0) {
                while ($row = $brandResult->fetch_assoc()) {
                    echo "<option value='" . $row['bno'] . "'>" . $row['bname'] . "</option>";
                }
            }
            ?>
        </select>
        
        <br><label>Model :</label>
        <input type="text" name="model" required> <br><br>
        

        <br><label>Ram :</label>
        <input type="radio" name="ram" value="4" required> 4 GB
        <input type="radio" name="ram" value="8"> 8 GB
        <input type="radio" name="ram" value="16"> 16 GB
        <input type="radio" name="ram" value="32"> 32 GB
        
       
        <br><label>Processor :</label>
        <input type="radio" name="processor" value="Intel i3" required> Intel i3
        <input type="radio" name="processor" value="Intel i5"> Intel i5
        <input type="radio" name="processor" value="Intel i7"> Intel i7
        <input type="radio" name="processor" value="Intel i9"> Intel i9
        <br>
        <br><label>Storage :</label>
        <select name="storage" required>
            <option value="256 GB SSD">256 GB SSD</option>
            <option value="512 GB SSD">512 GB SSD</option>
            <option value="1 TB SSD">1 TB SSD</option>
            <option value="1 TB HDD">1 TB HDD</option>
        </select>
        <br>
        <br><label>Image :</label>
        <input type="file" name="image" required>
        
        <br><input type="submit" name="insert">
    </form>

    <?php
   
    if (isset($_POST['insert'])) {
        $bno = $_POST['bno'];
        $model = $_POST['model'];
        $ram = $_POST['ram'];
        $processor = $_POST['processor'];
        $storage = $_POST['storage'];
        
       
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = "uploads/" . $imageName;
        
       
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            
            $sql = "INSERT INTO laptop (ram, processor, storage, image, model, bno) VALUES ('$ram', '$processor', '$storage', '$imagePath', '$model', '$bno')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>تم ادخال بيانات الابتوب بنجاح</p>";
            } else {
                echo "<p>حدث خطأ: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>حدث خطأ في رفع الصورة</p>";
        }
    }

    
    $conn->close();
    ?>
    </fieldset>
    </div>
</body>
</html>