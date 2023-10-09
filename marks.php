<?php
@include 'conn.php';

// Retrieve subject IDs and names from the 'subjects' table
$subjectQuery = "SELECT subject_id, subject_name FROM subjects";
$subjectResult = mysqli_query($conn, $subjectQuery);

// Store the subject IDs and names in an associative array
$subjects = [];
while ($row = mysqli_fetch_assoc($subjectResult)) {
    $subjects[$row['subject_id']] = $row['subject_name'];
}

// Retrieve registered student PRNs from the 'students' table
$studentQuery = "SELECT prn FROM students";
$studentResult = mysqli_query($conn, $studentQuery);

// Store the student PRNs in an array
$studentPRNs = [];
while ($row = mysqli_fetch_assoc($studentResult)) {
    $studentPRNs[] = $row['prn'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve marks details from the form
    $prn = $_POST['prn'];
    $subjectIDs = $_POST['subject_id'];
    $marksObtained = $_POST['marks_obtained'];
    $semesters = $_POST['semester'];

    // Check if marks already exist for the subject and student
    foreach ($subjectIDs as $key => $subjectID) {
        $checkMarksQuery = "SELECT COUNT(*) AS count FROM marks WHERE prn = '$prn' AND subject_id = '$subjectID'";
        $checkMarksResult = mysqli_query($conn, $checkMarksQuery);
        $row = mysqli_fetch_assoc($checkMarksResult);
        $count = $row['count'];

        // If marks already exist, skip inserting new marks and display an error message
        if ($count > 0) {
            echo '<script>alert("Marks already exist for PRN  and Subject . Skipping insertion.")</script>';
            //echo "Marks already exist for PRN $prn and subject ID $subjectID. Skipping insertion.<br>";
            continue;
        }

        // Insert marks details into the 'marks' table
        if (isset($marksObtained[$key]) && isset($semesters[$key])) {
            $marksQuery = "INSERT INTO marks (prn, subject_id, marks_obtained, semester) 
                           VALUES ('$prn', '$subjectID', '{$marksObtained[$key]}', '{$semesters[$key]}')";
            mysqli_query($conn, $marksQuery);
            //echo "Marks inserted for PRN $prn and subject ID $subjectID.<br>";
            // echo '<script>alert("Marks  Inserted.")</script>';
        }
        echo '<script>alert("Marks  Inserted.")</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Enter Marks</title>
    <script>
        function addOne() {
            var container = document.getElementById("marks-container");
            var clone = document.getElementById("marks-template").cloneNode(true);
            clone.removeAttribute("id");

            // Update input field IDs to make them unique
            clone.querySelector('[name="subject_id[]"]').id += container.children.length;
            clone.querySelector('[name="marks_obtained[]"]').id += container.children.length;
            clone.querySelector('[name="semester[]"]').id += container.children.length;

            container.appendChild(clone);
        }
    </script>
    <style>
        body{
            background:white
        }
        .center
        {
            align-content: center;
            align-items: center;
            justify-content: center;
            display:flex;
            width: 100%;
            height: 100%;
            margin-top: 15%;
            background-color: blanchedalmond;
            width: 50%;
            border: 15px solid black;
            padding: 100px;
           margin: auto;
        }
        h2{
            text-decoration: solid;
            align-items: center;
            justify-content: center;
            display: flex;
            margin-top: 40px;
            margin-bottom: 100px;

           
        }
        body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Full-width input fields */
input[type=text], input[type=submit],input[type=number] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

 /*label {
    width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
} */

/* Add a background color when the inputs get focus */
input[type=text]:focus, input[type=number]:focus ,input[type=submit]:focus{
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

h3{
    justify-content: center;
    display: flex;

}
    </style>
</head>
<body>
    <h2><b>ENTER MARKS</b></h2>
    <div class="center">
   
    <form method="POST" action="">
        <label for="prn">PRN  </label>
        <select name="prn" id="prn" required>
            <option disabled="disabled" selected="selected">Select prn</option>
            <?php foreach ($studentPRNs as $prn) { ?>
                <option value="<?php echo $prn; ?>"><?php echo $prn; ?></option>
            <?php } ?>
        </select><br>

        <h3><b>MARKS DETAIL</b></h3>
        <div id="marks-container">
            <div id="marks-template">
                <label for="subject_id">Subject:</label>
                <select name="subject_id[]" required>
                    <option disabled="disabled" selected="selected">Select Subject</option>
                    <?php foreach ($subjects as $subjectID => $subjectName) { ?>
                        <option value="<?php echo $subjectID; ?>"><?php echo $subjectName; ?></option>
                    <?php } ?>
                </select><br>

                <label for="marks_obtained">Marks Obtained:</label>
                <input type="text" name="marks_obtained[]" id="marks_obtained" required><br>
                
                <label for="semester">Semester:</label>
                <input type="number" name="semester[]" id="semester" required><br>
            </div>
        </div>

        <button type="button" onclick="addOne()">Add One</button>

        <input type="submit" value="Submit">
        <a href="admindashboard.php"><button type="button" >Back</button></a>

    </form>
</div>
</body>
</html>