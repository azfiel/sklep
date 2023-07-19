<?php
session_start();
if ($_SESSION['logged']!==True) {
	echo "you're logged out";
}
else{
	session_destroy();
	header("refresh:0");
}
echo "<br><a href='index.html'>main page</a>";
?>