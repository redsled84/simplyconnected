<?php
	if (isset($_POST["submit"])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$uname = $_POST['uname'];
		$pass = $_POST['password'];
		$email = $_POST['email'];

		$dbhost = 'localhost';
        	$dbuser = 'root';
        	$dbpass = '';
        	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
        	
        	if (!$conn) {
        		die('Could not connect: ' . mysql_error());
		}                                                  	
        	mysql_select_db('lucas');

		if (!$_POST['fname']) {
			$errFName = 'Please enter your first name';
		}

		if (!$_POST['lname']) {
			$errLName = 'Please enter your last name';
		}

		$u_sql = "SELECT * FROM Users
			  WHERE Username='$uname'";
		$result = mysql_query($u_sql, $conn);

		while ($row = mysql_fetch_assoc($result)) {
			if ($uname == $row['Username']) {
				$errUName = "Username '$uname' has already been taken";
			}
		}

		if (!$_POST['uname']) {
			$errUName = 'Please enter a username';
		}
		
		if (!$_POST['password']) {
			$errPass = 'Please enter a password';
		}
		
		if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Please enter a valid email address';
		}

		if (!$errFName && !$errLName && !$errUName && !$errPass && !$errEmail) { 	
			// User entry
			$sql = "INSERT INTO Users (FirstName, LastName, Username, Email, Password)
				VALUES ('$fname', '$lname', '$uname', '$email', '$pass')";
			if(mysql_query($sql, $conn)) {
				header('Location:login.php');
			} else {
				$errMessage = 'Sorry, please try again another time';
			}

			mysql_close($conn);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>SimplyConnected</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap 3 -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- CSS files -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- CSS resources -->
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container-fullwidth">
		<div class='navbar navbar-default navbar-static-top' role='navigation'>
			<div class='navbar-header navbar-left'>
				<a class='navbar-brand' href='index.php'>SimplyConnected</a>
			</div>
			<div class="container-fluid">
				<div class="collapse navbar-collapse">
					<ul class='nav navbar-nav navbar-right'>
						<li><a href="login.php">Log In</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class='container-fluid'>
			<div class='jumbotron'>
				<h1 align="center">Introducing SimplyConnected</h1>
				<hr>
				<p align="center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			</div>
		</div>

		<div class='container register-container'>
			<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="col-sm-10 col-sm-offset-2 text-center">
					<h2 class="text-center">Register today</h2>
					<br>
					<?php echo "<p class='text-danger'>$errMessage</p?";?>
				</div>
				<div class="form-group">
					<label for="fname" class="col-sm-2 control-label">First name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="fname" name="fname" placeholder="John" value="">
						<?php echo "<p align='left' class='text-danger'>$errFName</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="lname" class="col-sm-2 control-label">Last name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lname" name="lname" placeholder="Doe" value="">
						<?php echo "<p align='left' class='text-danger'>$errLName</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="uname" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="uname" name="uname" placeholder="Username" value="">
						<?php echo "<p align='left' class='text-danger'>$errUName</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
						<?php echo "<p align='left' class='text-danger'>$errPass</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
						<?php echo "<p align='left' class='text-danger'>$errEmail</p>";?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-1 text-center">
						<input id="submit" name="submit" type="submit" value="Register" class="btn btn-primary btn-lg text-center">
					</div>
				</div>
			</form>
		</div>
	</div>

</body>
</html>
