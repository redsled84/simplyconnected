<?php
	if (isset($_POST["submit"])) {
		$uname = $_POST['uname'];
		$pass = $_POST['password'];

		if (!$_POST['uname']) {
			$errUName = 'Please enter a username';
		}
		
		if (!$_POST['password']) {
			$errPass = 'Please enter a password';
		}

		if (!$errUName && !$errPass) { 
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$conn = mysql_connect($dbhost, $dbuser, $dbpass);
			
			if (!$conn) {
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db('lucas');
	
			$sql = "SELECT * FROM Users
					WHERE Username='$uname' AND Password='$pass'";
			$result = mysql_query($sql, $conn);

			if(mysql_num_rows($result) > 0) {
				$user = mysql_fetch_array($result);	
				if ($user['Username'] === 'admin') {
					header('Location:admin.php');
				} else {
					header('Location:profile.php');
				}
			} else {                                                             				
		            $errWrongPassOrUser = 'Entered a wrong password or username';
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
						<li><a href="index.php">Home</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class='container'>
			<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="col-sm-10 col-sm-offset-1 text-center">
					<h2 class="text-center">Enter your username and password</h2>
					<br>
					<?php echo "<p class='text-danger'>$errWrongPassOrUser</p>";?>
				</div>
				<div class="form-group">
					<label for="uname" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="uname" name="uname" placeholder="Username" value="">
						<?php echo "<p class='text-danger'>$errUName</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
						<?php echo "<p class='text-danger'>$errPass</p>";?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-1 text-center">
						<input id="submit" name="submit" type="submit" value="Log in" class="btn btn-primary btn-lg text-center">
					</div>
				</div>
			</form>
		</div>
	</div>

</body>
</html>

