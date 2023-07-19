<?php
session_start();
if ($_SESSION['logged']!==True) {
	header("location:index.html");
}
echo "<a href='logout.php'>Log out</a><br>";
echo "<a href='index.php'>Main page</a><br>";
echo "<a href='offer.php'>Create an offer</a><br>";
$pol = mysqli_connect("localhost","root","","sklep");
//czy polaczenie dziala
if ($pol -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli_connect_error();
  exit();
}

$sql=mysqli_query($pol,"SELECT money FROM user WHERE username='$_SESSION[username]'");
$row=mysqli_fetch_array($sql);
$money=$row['money'];
echo "<br><br><h1>$_SESSION[username]</h1>
      <h3>Money:$money</h3>
      <h3>Last transactions:</h3>
";
$sql2=mysqli_query($pol,"SELECT * FROM transactions WHERE host='$_SESSION[username]' or buyer='$_SESSION[username]'");
if (mysqli_num_rows($sql2)<1) {
  echo "<h4>No transactions found.</h4>";
}
else{
  echo "<table border='1'>
              <tr>
              <td>ID</td>
              <td>Seller</td>
              <td>Buyer</td>
              <td>Name</td>
              <td>Cost</td>
              <td>Date</td>
            </tr>
  ";
  while($row=mysqli_fetch_assoc($sql2)){
    if ($row['host']==$_SESSION['username']) {
      $green=True;
    }
    else{
      $green=False;
    }
    echo "
            <tr>
              <td>$row[id]</td>";
              if ($green==True) {
                echo"
                <td><span class='green'>$row[host]</span></td>
                <td>$row[buyer]</td>
                <td>$row[product_name]</td>
                <td>
                ";
              }
              else{
                echo "<td>$row[host]</td>
              <td><span class='green'>$row[buyer]</span></td>
              <td>$row[product_name]</td>
              <td>";
              }
              if ($green==True) {
                echo"<span class='green'>";   
              }
              else{
                echo "<span class='red'>";
              }
                echo "$row[cost]</span></td>
              <td>$row[date]</td>
            </tr>
";
  }
  echo "</table>";
}
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
  h1{
    text-align: center;
  }
  .green{
    color: green;
  }
  .red{
    color: red;
  }
</style>
</head>
<body>

</body>
</html>