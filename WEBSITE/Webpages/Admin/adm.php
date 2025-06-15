<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Poly-Uni Admin</title>
	<link rel="stylesheet" href="adm_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	
</head>
<body>
	<form method="POST" action="new_connect.php">
	<div class="container">
		<div class="sidebar">
			<ul>
			<li><div class="brand"> </div></li>
			<li><a href="dashboard.php"><i class='fas fa-poll'></i><div class="title">Dashboard</div></a></li>
			<li><a href="#"><i class='fas fa-graduation-cap'></i><div class="title">Courses</div></a></li>
			<li><a href="#"><i class='fas fa-users'></i><div class="title">Users</div></a></li>
			<li><a href="adm.php"><i class='fas fa-school'></i><div class="title">Admissions</div></a></li>
			<li><a href="#"><i class='fas fa-file-alt'></i><div class="title">Exams</div></a></li>
			<li><a href="#"><i class='fa fa-share-square'></i><div class="title">Logout</div></a></li>
			</ul>
		</div>
		<div class="main" id="adm_front">
			<div class="top-bar">
				<div class="DB"><h1>Admissions</h1></div>
				<i class="fas fa-bell"></i>
				<div class="user"><i class="far fa-user-circle"></i></div>
			</div>
			<div class="adm_tb">
				<table>
					<thead>
						<tr>
							<th>Ad_ID</th>
							<th>Course_ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Phone Number</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT * FROM admission_form";
						$result = $conn->query($sql);

						if(!$result){
    					die("Invalid query: ".$conn->error);
						
						while ($row = $result->fetch_assoc()){
							echo "<tr>
							<td>$row[Ad_ID]</td>
							<td>$row[Course_ID]</td>
							<td>$row[First_Name]</td>
							<td>$row[Last_Name]</td>
							<td>$row[Email]</td>
							<td>$row[Phone_num]</td>";
						}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>
</body>
</html>