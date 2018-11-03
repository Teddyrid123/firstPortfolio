<? php

	if (isset($_SESSION['id'])) {
		header("Location: index.php");
	}

	if (isset($_POST['register'])) {
		include_once("db.php");
	 

	$username = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);
	$password_confirm = strip_tags($_POST['password_confirm']);
	$email = strip_tags($_POST['email']);


	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$password_confirm = stripcslashes($password_confirm);
	$email = stripcslashes($email);


	$username = mysqli_real_escape_string($db, $username);
	$password = mysqli_real_escape_string($db, $password);
	$password_confirm = mysqli_real_escape_string($db, $password_confirm);
	$email = mysqli_real_escape_string($db, $email);

	$password = md5($password);
	$password_confirm = md5($password_confirm);


	$sql_store = "INSERT into users(username, password, email) VALUES('$username','$password','$email')";

	$sql_fetch_username = "SELECT username FROM users WHERE username = '$username'";
	$sql_fetch_email = "SELECT email FROM users WHERE email = '$email'";

	$query_username = mysqli_query($db, $sql_fetch_username);
	$query_email = mysqli_query($db, $sql_fetch_email);


	if (mysqli_num_rows($query_username)) {
	  	echo "There is already a user with this user name";
	  	return;
	  }  

	if ($username == "") {
		echo "Please enter a username";
		return;
	}

	if ($password == "" || $password_confirm == "") {
		echo "Please enter your password";
		return;
	}

	if ($password != $password_confirm) {
		echo "The password do not match!";
		return;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == " ") {
		echo "This email is not valid!";
		return;
	}

	if (mysqli_num_rows($query_email)) {
		 echo "This email is already in use!";
		 return;
	}

	mysqli_query($db, $sql_store);

	header("Location: index.php");
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hibaku.com</title>
    <!-- contom css -->
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>


  <form action="register.php" method="post" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Username" autofocus>
    <input type="password" name="password" placeholder="password">
    <input type="password" name="password_confirm" placeholder="Confirm password">
    <input type="text" name="email" placeholder="Email address">
    <input type="submit" name="register" value="Register">
  </form>

</body>
</html>


