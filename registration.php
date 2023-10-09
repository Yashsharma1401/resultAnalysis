<?php
@include 'conn.php';

// Define variables to store the notification message and the redirect URL
$notification = "";
$redirectURL = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve student details from the form
    $prn = $_POST['prn'];
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $date_of_birth = $_POST['date_of_birth'];
    $admi_year = $_POST['admi_year'];

    // Insert student details into the 'students' table
    $studentQuery = "INSERT INTO students (prn, student_name, student_email, date_of_birth, admi_year) 
                     VALUES ('$prn', '$student_name', '$student_email', '$date_of_birth', '$admi_year')";

    if (mysqli_query($conn, $studentQuery)) {
        // Student added successfully
        $notification = "Student added successfully!";
        $redirectURL = "admindashboard.php";
    } else {
        // Error occurred while adding the student
        $notification = "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Full-width input fields */
input[type=text], input[type=email],input[type=date],input[type=number] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

/* Add a background color when the inputs get focus */
input[type=text]:focus, input[type=email]:focus ,input[type=date]:focus,input[type=number]:focus{
  background-color: #ddd;
  outline: none;
}

/* Set a style for all buttons */
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d;
  padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
 
/* The Close Button (x) */
.close {
  position: absolute;
  right: 35px;
  top: 15px;
  font-size: 40px;
  font-weight: bold;
  color: #f1f1f1;
}

.close:hover,
.close:focus {
  color: #f44336;
  cursor: pointer;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

.center {
    justify-content: center;
    align-items: center;
    display: flex;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
body{
  background-color:blanchedalmond;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 10px 15px; /* Adjust the padding to reduce button length */
  margin: 8px 5px; /* Adjust the margin to reduce space between buttons */
  border: none;
  cursor: pointer;
  width: 40%; /* Change width to "auto" to adjust based on content */
  opacity: 0.9;
}


/* Alert styles */
.alert {
    padding: 20px;
    color: white;
    font-weight: bold;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #4CAF50;
}

.alert-error {
    background-color: #f44336;
}

</style>
<body>

<h2>STUDENT REGISTRATION FORM </h2>
<style>
    h2{
        text-align: center;
    }

</style>
<form class="modal-content" action="" method="POST">
    <div class="container">
      <h1>Student Registration</h1>
      
      <hr>
      <label for="prn"><b>PRN</b></label>
      <input type="text" placeholder="Enter PRN" name="prn" id="prn" required>

      <label for="student_name"><b>Student Name</b></label>
      <input type="text" placeholder="Enter name" name="student_name" id="student_name" required>

      <label for="student_email"><b>Email</b></label>
      <input type="email" placeholder="Enter email" name="student_email" id="student_email" required>

      <label for="date_of_birth"><b>Date of Birth</b></label>
      <input type="date" placeholder="Date of Birth" name="date_of_birth" id="date_of_birth" required>

      <label for="admi_year"><b>Admission Year</b></label>
      <input type="number" placeholder="Admission Year" name="admi_year" id="admi_year" required><br>

      

      

      <div class="clearfix">
        <a href="admindashboard.php"><button type="button" >Cancel</button></a>

        <button type="submit" class="signupbtn">Register</button>
      </div>
    </div>
  </dev>
</form>
<!-- Display the notification using JavaScript -->
<?php if ($notification !== ""): ?>
    <script>
        // Use JavaScript to display the alert box
        alert("<?php echo $notification; ?>");
        // Redirect to the admin dashboard page if needed
        <?php if ($redirectURL !== ""): ?>
            window.location.href = "<?php echo $redirectURL; ?>";
        <?php endif; ?>
    </script>
<?php endif; ?>


  <!-- <form method="POST" action="">
    <label for="prn">PRN:</label>
    <input type="text" name="prn" id="prn" required><br>

    <label for="student_name">Student Name:</label>
    <input type="text" name="student_name" id="student_name" required><br>

    <label for="student_email">Email:</label>
    <input type="email" name="student_email" id="student_email" required><br>

    <label for="date_of_birth">Date of Birth:</label>
    <input type="date" name="date_of_birth" id="date_of_birth" required><br>

    <label for="admi_year">Admission Year:</label>
    <input type="number" name="admi_year" id="admi_year" required><br>

    <input type="submit" value="Register">
</form>  -->
 
 
<!--  
<form class="modal-content" action="" method="POST">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label for="prn"><b>PRN</b></label>
      <input type="text" placeholder="Enter PRN" name="prn" id="prn" required>

      <label for="student_name"><b>Student Name</b></label>
      <input type="text" placeholder="Enter name" name="student_name" id="student_name" required>

      <label for="student_email"><b>Email</b></label>
      <input type="email" placeholder="Enter email" name="student_email" id="student_email" required>

      <label for="date_of_birth"><b>Date of Birth</b></label>
      <input type="date" placeholder="Date of Birth" name="date_of_birth" id="date_of_birth" required>

      <label for="admi_year"><b>Admission Year</b></label>
      <input type="number" placeholder="Admission Year" name="admi_year" id="admi_year" required><br>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>

        <button type="submit" class="signupbtn">Register</button>
      </div>
    </div>
  </dev>
</form>-->








</body>
</html>