<?php
include 'conn.php';
$id = $_GET['id'];

$sql = "DELETE FROM laptop WHERE no=$id";
if ($conn->query($sql)) {
    mysqli_close($conn);
    echo '<script>
            alert("Device successfully deleted");
            window.location.href ="home.php";
          </script>';
}
header('Location: home.php');
?>




