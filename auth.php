<?php
$pol = mysqli_connect("localhost","root","","sklep");
//czy polaczenie dziala
if ($pol -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli_connect_error();
  exit();
}

//rejestracja
if (isset($_POST['register'])) {
	if (empty($_POST["username"])) {
		echo "username is empty";
		header("refresh:2;url=index.html");
		exit();
	}
	elseif (empty($_POST['password'])) {
		echo "password is empty";
		header("refresh:2;url=index.html");
		exit();
	}
	elseif (empty($_POST['code'])) {
		echo "code is empty";
		header("refresh:2;url=index.html");
		exit();
	}
	else{
		$username=mysqli_real_escape_string($pol,$_POST["username"]);
		$password=mysqli_real_escape_string($pol,$_POST["password"]);
		$passwordhash=password_hash($password, PASSWORD_DEFAULT);
		$code=mysqli_real_escape_string($pol,$_POST["code"]);

		$sql=mysqli_query($pol,"SELECT username FROM user WHERE username='$username'");
		if (mysqli_num_rows($sql)>0) {
			echo "username in use";
			exit();
		}
		else {
			$sql=mysqli_query($pol,"SELECT NULL FROM invite_codes WHERE code='$code'");
			if (mysqli_num_rows($sql)<1) {
				echo "bad code";
				header("refresh:3;url=index.html");
				exit();
			}
			else{
			$sql=mysqli_query($pol,"INSERT INTO user(`username`,`password`) VALUES('$username','$passwordhash')");
			if ($sql==True) {
				echo "registration successful;<br>$username,$password";
				//USUN KOMENTARZ JESLI CHCESZ JEDNORAZOWE KODY ZAPROSZENIOWE
				//$sql=mysqli_query($pol,"DELETE FROM `invite_codes` WHERE code=$code");
				unset($_POST['register']);
				exit();
			}
			else{
				echo "registration unsuccessful".mysql_errno($sql);
			}
		}
	}
	}
}
elseif (isset($_POST['login'])) {
	if (empty($_POST["username2"])) {
		echo "username is empty";
		exit();
	}
	elseif (empty($_POST['password2'])) {
		echo "password is empty";
		exit();
	}
	$username2=mysqli_real_escape_string($pol,$_POST['username2']);
	$password2=mysqli_real_escape_string($pol,$_POST['password2']);
	$sql=mysqli_query($pol,"SELECT password FROM user WHERE username='$username2'");
	while ($row=mysqli_fetch_array($sql)) {
		$password_db=$row['password'];
	}
	if(mysqli_num_rows($sql)>0 and password_verify($password2, $password_db)==True){
		session_start();
		$_SESSION['logged']=True;
		$_SESSION['username']=$username2;
		header("location:index.php");
		exit();
	}
	else{
		echo "wrong credentials";
		header("refresh:2;url=index.html");
		exit();
	}

}
else{
	header("location:index.html");
}
?>