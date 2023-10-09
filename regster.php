<?php
@include 'conn.php';

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
    mysqli_query($connection, $studentQuery);
}
?>