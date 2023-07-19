<?php
session_start();
if ($_SESSION['logged']!==True) {
	header("location:index.html");
}

echo "<a href='logout.php'>Log out</a><br>";
echo "<a href='user.php'>Profile</a><br>";
echo "<a href='index.php'>Main page</a><br>";

$pol = mysqli_connect("localhost","root","","sklep");
//czy polaczenie dziala
if ($pol -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli_connect_error();
  exit();
}

if (isset($_POST['submit'])) {
  unset($_POST['submit']);
  if (!empty($_POST['product_name']) and !empty($_POST['cost']) and !empty($_POST['contact']) and !empty($_POST['image_url']) and !empty($_POST['category']) and !empty($_POST['description'])) {
    $sql=mysqli_query($pol,"INSERT INTO products(host_username,product_name,cost,contact,image_url,category,description) VALUES('$_SESSION[username]','$_POST[product_name]','$_POST[cost]','$_POST[contact]','$_POST[image_url]','$_POST[category]','$_POST[description]')");
    if ($sql) {
      echo "created the offer";
      unset($_POST);
      header("location:index.php");
      exit();
    }
    else{
      echo "error while creating the offer: ".mysql_errno($sql);
    }
  }
}
?>
<!DOCTYPE html>
<html>
<body>
  <form action="offer.php" method="post">
    <input type="text" name="product_name" placeholder="product name" required><br>
    <input type="number" name="cost" placeholder="product cost" required><br>
    <input type="text" name="contact" placeholder="contact data" required><br>
    <input type="text" name="image_url" placeholder="product thumbnail url" required><br>
    <label><input type="radio" name="category" value="Videos">Videos</label>
    <label><input type="radio" name="category" value="Electronics">Electronics</label>
    <label><input type="radio" name="category" value="Miscellaneous" checked>Misc</label><br>
    <textarea maxlength="1000" name="description" placeholder="description" required></textarea><br>
    <input type="submit" name="submit" value="create the offer">
  </form>
</body>
</html>