<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Polycium University Admission Profile</title>
  <link rel="stylesheet" href="form.css" />
</head>
<body>
  <div style="width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
  <div style="display: flex; align-items: center;">
      <img src="../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
    <span style="font-size: 30px; color: #FFFFFF; font-family: s; ">POLYCIUM UNIVERSITY</span>
  </div>

</div>

  <main>
    <div class="form-container">
      <div class="form-logo">
        <img src="../../Images/new.png" alt="Admission Logo" />
      </div>

      <h2>Admission Profile</h2>
      <p>Kindly fill out this profile</p>

      <form method="POST" action="new_connect.php">
        <div class="form-row">
          <input type="text" name="firstname" placeholder="First Name" required/>
          <input type="text" name="middlename" placeholder="Middle Name" required/>
        </div>
        <div class="form-row">
          <input type="text" name="lastname" placeholder="Last Name" required/>
          <input type="text" name="suffix" placeholder="Suffix" />
        </div>
        <div class="form-row">
          <input type="date" name="dob" placeholder="Date of Birth" required/>
          <select name="sex" required>
            <option class="sex" disabled selected value="">--- Select Gender ---</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="form-row">
          <input type="text" name="religion" placeholder="Religion" required/>
          <input type="text" name="address" placeholder="Address" required/>
        </div>
        <div class="form-row">
          <input type="text" name="fathername" placeholder="Father’s name" required/>
          <input type="text" name="mothername" placeholder="Mother’s Maiden name" required/>
        </div>
        <div class="form-row">
          <input type="text" name="guardianname" placeholder="Guardian’s name" required/>
          <input type="email" name="email" placeholder="Email" required/>
        </div>
        <div class="form-row">
          <input type="text" name="phoneno" placeholder="Phone Number" required/>
          <input type="text" name="contactem" placeholder="Contact in case of Emergency" required/>
        </div>
        <div class="form-row1">
          <select name="course" required>
            <option class="course" disabled selected value="">--- Select Course/Program ---</option>
            <?php 
              include ('new_connect.php');
              $course = mysqli_query($conn, "SELECT * FROM course");
              while ($co = mysqli_fetch_array($course)){
            ?>
            <option value = "<?php echo $co['Course_Name']?>"><?php echo $co['Course_Name']?></option>
            <?php } ?>
          </select>
        </div>
        <div class="submit-row">
          <button name="submit_inputs" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
