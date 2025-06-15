<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Poly-Uni Admin</title>
	<link rel="stylesheet" href="style1.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
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
		<div class="main active" id="dashboard">
			<div class="top-bar">
				<div class="DB"><h1>Dashboard</h1></div>
				<i class="fas fa-bell"></i>
				<div class="user"><i class="far fa-user-circle"></i></div>
			</div>
			<div class="cards">
				<div class="cards-con">
					<div class="card_title"><h1>COURSES</h1></div><br>
					<div class="card_text">Total Courses (50)</div><br>
					<div class="bar_course"></div><br>
					<div class="card_text">Enrolled (50)</div><br>
					<div class="bar_course"></div><br>
					<div class="card_text">Pending (50)</div><br>
					<div class="bar_course"></div><br>
				</div>
				<div class="cards-con">
					<div class="card_title"><h1>EXAMS</h1></div><br>
					<div class="card_text">Total (70)</div><br>
					<div class="bar_exams"></div><br>
					<div class="card_text">Passed (70)</div><br>
					<div class="bar_exams"></div><br>
					<div class="card_text">Failed (70)</div><br>
					<div class="bar_exams"></div><br>
					<div class="card_text">Pending (70)</div><br>
					<div class="bar_exams"></div>
				</div>
				<div class="cards-con">
					<div class="card_title"><h1>USERS</h1></div><br>
					<div class="card_text">Total (70)</div><br>
					<div class="bar_users"></div><br>
					<div class="card_text">Registered (70)</div><br>
					<div class="bar_users"></div><br>
					<div class="card_text">Pending (70)</div><br>
					<div class="bar_users"></div>	
				</div>
				<div class="cards-con">
					<div class="card_title"><h1>ADMISSIONS</h1></div><br>
					<div class="card_text">Total (70)</div><br>
					<div class="bar_adm"></div><br>
					<div class="card_text">Accepted (70)</div><br>
					<div class="bar_adm"></div><br>
					<div class="card_text">Rejected (70)</div><br>
					<div class="bar_adm"></div><br>
					<div class="card_text">Pending (70)</div><br>
					<div class="bar_adm"></div><br>	
				</div>
			</div>
		</div>
	</div>
</body>
</html>