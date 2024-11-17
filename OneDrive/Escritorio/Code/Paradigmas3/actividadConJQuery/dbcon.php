//dbcon.php
<?php
$conn = new mysqli('localhost','root','','crud-plugins');
if ($conn->connect_error) {
    die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
}
?>