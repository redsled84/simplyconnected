<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	
	if (!$conn) {
		die('Failed to connect: ' . mysql_error());
	}

	mysql_select_db('lucas');

	$sql = "SELECT * FROM Users";
	$result = mysql_query($sql, $conn);

	$users = array();

	while ($row = mysql_fetch_array($result)) {
		array_push($users, $row);
	}

	if (sizeof($users) < 1) {
		die('Unable to retrieve data from table');
	}

	//Incase the order of AUTO_INCREMENT is off when loaded
	mysql_query("SET @count = 0");
	mysql_query("UPDATE Users SET U_ID = @count:= @count + 1");

	$management_sql = array("delete"=>"DELETE FROM Users WHERE Username='".$_POST['delete-input']."'");
	
	if (isset($_POST["delete-submit"])) {
		mysql_query($management_sql["delete"]);
	}	
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>SimplyConnected</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap 3 -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- CSS files -->
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<!-- CSS resources -->
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<!-- JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
</head>
<body>
	<div class="container-fullwidth" ng-app='showApp' ng-controller='mainController'>
		<div class='navbar navbar-default navbar-static-top' role='navigation'>
			<div class='navbar-header navbar-left'>
				<a href="index.php" class='navbar-brand'>SimplyConnected</a>
			</div>
			<div class="container-fluid">
				<div class="collapse navbar-collapse">
					<ul class='nav navbar-nav navbar-right navbar-text'>
						<li><a href="index.php">Home</a></li>
						<li><a href="login.php">Login</a></li>
						<li><a class='fa fa-cog' ng-click='show = !show'></a></li>
					</ul>
				</div>
			</div>

		</div>
		
		<div class="management" ng-if="show" ng-show="show">
			<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="form-group">
					<label for="delete-input" class="col-sm-2 control-label">Delete a user</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="delete-input" name="delete-input" placeholder="Username" value="">
					</div>
				</div>                                                                                                          	
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-1 text-center">
						<input id="delete-submit" name="delete-submit" type="submit" value="DELETE" class="btn btn-danger btn-lg text-center">
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid user-list">
			<br>
			<h2>SimplyConnected User List</h2>
			<br>
			<table class="table table-hover">
				<thead>
				  	<tr>
						<th>User ID</th>						
						<th>Username</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Password</th>
						<th>Email</th>
						<th>Created At </th>
				  	</tr>
				</thead>
				<tbody>
					<?php foreach($users as $key=>$value): ?>
				  	<tr>  	
						<td><?=$value['U_ID']?></td>
						<td><?=$value['Username']?></td>
						<td><?=$value['FirstName']?></td>
						<td><?=$value['LastName']?></td>
						<td><?=$value['Password']?></td>
						<td><?=$value['Email']?></td>
						<td><?=$value['CreatedAt']?></td>
					</tr>	
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
