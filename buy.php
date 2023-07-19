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
$username=$_SESSION['username'];
$product_id=$_POST['product_id'];
$product_name=$_POST['product_name'];
$sql=mysqli_query($pol,"SELECT money FROM user WHERE username='$username'");
$sql2=mysqli_query($pol,"SELECT * FROM products WHERE id=$_POST[product_id]");

$row=mysqli_fetch_array($sql);
$money=$row['money'];

$row=mysqli_fetch_array($sql2);
$cost=$row['cost'];
$host_username=$row['host_username'];

if ($money>=$cost) {
  $moneynew=$money-$cost;
  $sql3=mysqli_query($pol,"UPDATE user SET money='$moneynew' WHERE username='$username'");
  $sql4=mysqli_query($pol,"DELETE FROM products WHERE id='$product_id'");
  $sql5=mysqli_query($pol,"UPDATE user SET money=money+$cost WHERE username='$host_username'");
  $sql6=mysqli_query($pol,"INSERT INTO transactions(host, buyer, product_name, cost) VALUES('$host_username','$username','$product_name','$cost')");
  if ($sql3 and $sql4 and $sql5) {
    echo "Transaction completed. Item bought for:".$cost." New balance: ".$moneynew;
    unset($_POST['product_id']);
    exit();
  }
  else{
    echo "Transaction error";
  }
}
else{
  echo "Not enough money";
}

?>