<html>
<head>
<style type="text/css">
	body{
		margin-right: 10%;
		margin-left: 10%;
	}
	.table{
		float: left;
		width: 18%;
		margin: 10px;
	}
	#flexcenter{
		text-align: center;
		margin: 10px 40% 10px 40%;
	}
</style>
</head>
</html>
<?php
session_start();
if ($_SESSION['logged']!==True) {
	header("location:index.html");
}
echo "<a href='logout.php'>Log out</a><br>";
echo "<a href='user.php'>Profile</a><br>";
echo "<a href='offer.php'>Create an offer</a><br>";
echo "
	<form method='get'>
	   <label><input type='radio' name='category' value='Videos'>Videos</label>
    <label><input type='radio' name='category' value='Electronics'>Electronics</label>
    <label><input type='radio' name='category' value='Miscellaneous'>Misc</label>
    <label><input type='radio' name='category' value='all'>All</label>
    <input type='submit' value='select'>
  </form><br>";
$pol = mysqli_connect("localhost","root","","sklep");
//czy polaczenie dziala
if ($pol -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli_connect_error();
  exit();
}
if (isset($_GET['info'])) {
	$sql=mysqli_query($pol,"SELECT * FROM products WHERE id='$_GET[product_id]'");
	while ($row=mysqli_fetch_assoc($sql)) {
		echo"
			<table border='1' id='flexcenter'>
				<tr>
					<td>Name</td>
					<td>Cost</td>
					<td>Author</td>
				</tr>
				<tr>
					<td>$row[product_name]</td>
					<td>$row[cost]</td>
					<td>$row[host_username]</td>
				</tr>
				<tr>
					<td colspan='3' ><img src='$row[image_url]' height='300px' width='300px' alt='product image unavailable'></td>
				</tr>
				<tr>
					<td colspan='3' style='text-align: center;''>contact:$row[contact](post id:$row[id])</td>
				</tr>
				<tr>";
				if ($_SESSION['username']!==$row['host_username']) {
					echo"
						<td><form method='post' action='buy.php'>
							<input type='hidden' name='product_name' value='$row[product_name]'>
							<input type='hidden' name='product_id' value='$row[id]'>
							<input type='submit' value='buy now'>
						</form></td>";
				}
								if ($row['host_username']==$_SESSION['username']) {
								echo "<td colspan='3'><form method='post' action='delete.php'>
							<input type='hidden' name='product_id' value='$row[id]'>
							<input type='submit' value='delete'>
							</form></td></table>
							<h4>description:</h4>
							<p>$row[description]</p>
							";
							exit();
				}
	}
}

if (!isset($_GET['category']) or $_GET['category']=="all") {
		$sql=mysqli_query($pol,"SELECT * FROM PRODUCTS ORDER BY id DESC");
		echo "<h3>All</h3>";
	if (mysqli_num_rows($sql)>0) {
		while($row=mysqli_fetch_assoc($sql)){
			echo"
			<table border='1' class='table'>
				<tr>
					<td>Name</td>
					<td>Cost</td>
					<td>Author</td>
				</tr>
				<tr>
					<td>$row[product_name]</td>
					<td>$row[cost]</td>
					<td>$row[host_username]</td>
				</tr>
				<tr>
					<td colspan='3' ><img src='$row[image_url]' height='300px' width='300px' alt='product image unavailable'></td>
				</tr>
				<tr>
					<td colspan='3' style='text-align: center;''>contact:$row[contact](post id:$row[id])</td>
				</tr>
				<tr>";
			if ($_SESSION['username']!==$row['host_username']) {
					echo"
						<td><form method='post' action='buy.php'>
							<input type='hidden' name='product_name' value='$row[product_name]'>
							<input type='hidden' name='product_id' value='$row[id]'>
							<input type='submit' value='buy now'>
						</form></td>";
				}
			else {
							echo "<td colspan='2'><form method='post' action='delete.php'>
						<input type='hidden' name='product_id' value='$row[id]'>
						<input type='submit' value='delete'>
						</form></td>
						<td><form method='get'>
							<input type='hidden' name='product_id' value='$row[id]'>
							<input type='submit' name='info' value='more info'></td>
						</form></td>
						";
						}
					echo"
				</tr>
		</table>
			";
		}
	}
	else{
		echo"no offers.";
	}
}
else{
	$sql2=mysqli_query($pol,"SELECT * FROM products WHERE category='$_GET[category]' ORDER BY id DESC");
	echo "<h3>$_GET[category]</h3>";
	if (mysqli_num_rows($sql2)>0) {
		while($row=mysqli_fetch_assoc($sql2)){
			echo"
			<table border='1' class='table'>
				<tr>
					<td>Name</td>
					<td>Cost</td>
					<td>Author</td>
				</tr>
				<tr>
					<td>$row[product_name]</td>
					<td>$row[cost]</td>
					<td>$row[host_username]</td>
				</tr>
				<tr>
					<td colspan='3' ><img src='$row[image_url]' height='300px' width='300px' alt='product image unavailable'></td>
				</tr>
				<tr>
					<td colspan='3' style='text-align: center;''>contact:$row[contact](post id:$row[id])</td>
				</tr>
					<tr>";
			if ($_SESSION['username']!==$row['host_username']) {
					echo"
						<td><form method='post' action='buy.php'>
							<input type='hidden' name='product_name' value='$row[product_name]'>
							<input type='hidden' name='product_id' value='$row[id]'>
							<input type='submit' value='buy now'>
						</form></td>";
				}
			else {
							echo "<td colspan='2'><form method='post' action='delete.php'>
						<input type='hidden' name='product_id' value='$row[id]'>
						<input type='submit' value='delete'>
						</form></td>
						<td><form method='get'>
							<input type='hidden' name='product_id' value='$row[id]'>
							<input type='submit' name='info' value='more info'></td>
						</form></td>
						";
						}
					echo"
				</tr>
		</table>
			";
		}
	}
	else{
		echo"no offers.";
	}
}

?>