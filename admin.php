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

	$management_sql = array(
		"delete"=>"DELETE FROM Users WHERE Username='{$_POST['delete-input']}'",
		"update"=>"UPDATE Users SET {$_POST['update-column']}='{$_POST['update-input']}' WHERE Username='{$_POST['update-name']}'"
		// add update function here
	);

	$update = true;
	
	if (isset($_POST["delete-submit"]) && $_POST["delete-input"] != 'admin') {
		mysql_query($management_sql["delete"]);
	
		//Incase the order of AUTO_INCREMENT is off when loaded
        	mysql_query("SET @count = 0");
        	mysql_query("UPDATE Users SET U_ID = @count:= @count + 1");
	} elseif (isset($_POST["update-submit"])) {
		for ($index = 0; $index < sizeof($users); $index++) {
			if ($users[index] == $_POST['update-name']) {
				$update = false;
			}		
		}
		if ($update == true) {
			mysql_query($management_sql["update"]);		
		}
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
						<li><a class='fa fa-cog' ng-click='formShow = !formShow; managementShow = !managementShow;'></a></li>
					</ul>
				</div>
			</div>

		</div>
		
		<div class="management" ng-if="managementShow" ng-show="managementShow">
			<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="form-delete row pagination-centered">
					<label for="delete-input" class="col-sm-3 control-label">Delete a user</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="delete-input" name="delete-input" placeholder="Username" value="">
					</div>                                                                                                    	
					<div class="col-sm-3">
						<input type="submit" class="btn btn-danger" id="delete-submit" name="delete-submit" value="DELETE" onClick="history.go(0)">
					</div>
				</div>
				<div class="form-update row pagination-centered">
                                	<label for="update-input" class="col-sm-1 control-label">Update a user</label>
                                	<div class="col-sm-2">
						<input type="text" class="form-control" id="update-name" name="update-name" placeholder="Username" value="">
					</div>
					<div class="col-sm-3">						
						<input type="text" class="form-control" id="update-column" name="update-column" placeholder="Column name" value="">
					</div>                                                                                                    	
					<div class="col-sm-4">						
						<input type="text" class="form-control" id="update-input" name="update-input" placeholder="New value" value="">
					</div>                                                                                                    	
                                	<div class="col-sm-2">
                                		<input type="submit" class="btn btn-success" id="update-submit" name="update-submit" value="UPDATE" onClick="history.go(0)">
                                	</div>
				</div>
			</div>
		</div>

		<div class="container-fluid user-list">
			<br>
			<h2>SimplyConnected User List</h2>
			<br>
			<table class="table table-hover pull-right">
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
