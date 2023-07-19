<?php
session_start();
if ($_SESSION['logged']!==True) {
	header("location:index.html");
}
echo "<a href='logout.php'>Log out</a><br>";
echo "<a href='index.php'>Main page</a><br>";

$pol = mysqli_connect("localhost","root","","sklep");
//czy polaczenie dziala
if ($pol -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli_connect_error();
  exit();
}

if (!isset($_SESSION['username']) or !isset($_POST['product_id'])) {
  exit();
}
$id=$_POST['product_id'];
$sql=mysqli_query($pol,"DELETE FROM products WHERE id='$id'");
if ($sql) {
  echo "deleted successfully";
  unset($_POST['product_id']);
}
else{
  echo "error".mysqli_errno($sql);
}
?>