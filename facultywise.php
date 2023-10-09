<?php
@include 'conn.php';

// Retrieve the top 5 students with the highest total marks
$topStudentsQuery = "SELECT s.prn, s.student_name, SUM(m.marks_obtained) AS total_marks
                     FROM students s
                     JOIN marks m ON s.prn = m.prn
                     GROUP BY s.prn
                     ORDER BY total_marks DESC
                     LIMIT 5";
$topStudentsResult = mysqli_query($conn, $topStudentsQuery);

// Query to get the count of students who failed (marks below 40%)
$sqlFailed = "SELECT COUNT(*) AS total_failed FROM (
    SELECT s.prn
    FROM students s
    JOIN marks m ON s.prn = m.prn
    GROUP BY s.prn
    HAVING AVG(m.marks_obtained) < 40
) AS failed";
$resultFailed = mysqli_query($conn, $sqlFailed);
$rowFailed = mysqli_fetch_assoc($resultFailed);
$totalFailed = $rowFailed['total_failed'];

// Query to get the total number of students
$sql = "SELECT COUNT(*) AS total_students FROM students";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalStudents = $row['total_students'];

// Query to get the count of students with more than 40% marks
$sqlPassed = "SELECT COUNT(*) AS total_passed FROM (
                    SELECT s.prn
                    FROM students s
                    JOIN marks m ON s.prn = m.prn
                    GROUP BY s.prn
                    HAVING AVG(m.marks_obtained) >= 40
                ) AS passed";
$resultPassed = mysqli_query($conn, $sqlPassed);
$rowPassed = mysqli_fetch_assoc($resultPassed);
$totalPassed = $rowPassed['total_passed'];

// Query to get the total number of registered students
$sqlRegistered = "SELECT COUNT(*) AS total_registered FROM marks";
$resultRegistered = mysqli_query($conn, $sqlRegistered);
$rowRegistered = mysqli_fetch_assoc($resultRegistered);
$totalRegistered = $rowRegistered['total_registered'];

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!------======CSS=======------->
    <link rel="stylesheet" href="css/style.css">

    <!-----====== Iconscout CSS=====-->
    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <title>Faculty-wise Analysis</title>

    <style>
        .container {
            max-width: 850px;
            margin: 0 auto;
            text-align: center;
            padding: 75px 0px 50px 250px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 3px solid #4b230f;
        }

        table th {
            background-color: #4a746d;
            font-weight: bold;
        }
        body {
            background: #ceebed;
            padding: auto;

        h2 {
            color: #FFFFFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #FFFFFF;
            padding: 8px;
        }
        th {
            background-color: #808080;
            color: #FFFFFF;
        }
        #chart_div{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 40%;
        }
        .fchart{
            width: 500px;
            padding: 0px 0px 0px 15px;
        }
        #chart_div {
        display: block;
        margin: 0 auto;
        width: 80%; /* Adjust the width as needed */
        max-width: 500px; /* Set a maximum width for responsiveness */
    }

    </style>

</head>
<body>
    
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="logo.png"  alt="">
            </div>

             <span class="logo name">RESULT ANALYSIS</span>
            
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="index.php">
                        <i class="uil uil-home"></i>
                      <span class="link-name">home</span>
                    </a>

                </li>
                <li>
                    <a href="adminlogin/index.php">
                        <i class="uil uil-sign-in-alt"></i>
                      <span class="link-name">Admin Page</span>
                    </a>

                </li>
                <li>
                    <a href="studentwise.php">
                      <i class="uil uil-estate"></i>
                      <span class="link-name">StudentWA</span>
                    </a>

                </li>
                <li>
                    <a href="subjectwise.php">
                        <i class="uil uil-align-center-alt"></i>
                      <span class="link-name">SBA</span>
                    </a>

                </li>
                <li>
                    <a href="facultywise.php">
                        <i class="uil uil-chart-line"></i>
                      <span class="link-name">FWA</span>
                    </a>

                </li>
                
            </ul>
            <ul class="logout-mod">
                <li>
                    <a href="index.php">
                        <i class="uil uil-signout"></i>
                      <span class="link-name">logout</span>
                    </a>

                </li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                      <span class="link-name">Dark-mode</span>
                    </a>

                <div class="mode-toggle">
                    <span class="switch"></span>
                </div>

                </li>


            </ul>


        </div>

    </nav>
    

    <div class="container">
        <h1>Faculty-wise Analysis</h1>

        <form action="" method="POST">
            <label for="faculty">Select Faculty:</label>
            <select id="faculty" name="faculty">
                <?php
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "manstud";

                // Create a new PDO instance
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Retrieve the faculty from the database
                $stmt = $conn->prepare("SELECT * FROM faculty");
                $stmt->execute();
                $faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo'<option disabled="disabled" selected="selected">Select an option.</option>';

                // Generate the options for the select element
                foreach ($faculty as $fac) {
                    echo '<option value="' . $fac['faculty_id'] . '">' . $fac['faculty_name'] . '</option>';
                }

                // Close the database connection
                $conn = null;
                ?>
            </select>
            <input type="submit" value="Show Analysis">
        </form>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected faculty ID
    $facultyId = $_POST["faculty"];

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the faculty name from the database
    $stmt = $conn->prepare("SELECT faculty_name FROM faculty WHERE faculty_id = :faculty_id");
    $stmt->bindParam(':faculty_id', $facultyId);
    $stmt->execute();
    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($faculty) {
        echo '<h2>Faculty: ' . $faculty['faculty_name'] . '</h2>';

        // Retrieve the student marks for the selected faculty in descending order
        $stmt = $conn->prepare("
        SELECT marks.marks_obtained, students.student_name, subjects.subject_name
        FROM marks
        INNER JOIN students ON marks.prn = students.prn
        INNER JOIN subjects ON marks.subject_id = subjects.subject_id
        WHERE subjects.faculty_id = :faculty_id
        ORDER BY marks.marks_obtained DESC
        LIMIT 5
    ");

        $stmt->bindParam(':faculty_id', $facultyId);
        $stmt->execute();
        $marks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($marks) {
            echo '<table>';
            echo '<tr><th>Student Name</th><th>Subject Name</th><th>Marks Obtained</th></tr>';

            $chartData = [['Student Name', 'Marks Obtained']]; // Initialize chart data array

            $counter = 0;
foreach ($marks as $mark) {
    echo '<tr>';
    echo '<td>' . $mark['student_name'] . '</td>';
    echo '<td>' . $mark['subject_name'] . '</td>';
    echo '<td>' . $mark['marks_obtained'] . '</td>';
    echo '</tr>';
    // Append the data to the chart data array
    $chartData[] = [$mark['student_name'], (int)$mark['marks_obtained']];
    
    $counter++;
    if ($counter >= 5) {
        break; // Exit the loop after displaying the top 5 entries
    }
}

            echo '</table>';
        } else {
            echo '<p>No student marks found for the selected faculty.</p>';
        }
    } else {
        echo '<p>Invalid faculty selected.</p>';
    }

    // Close the database connection
    $conn = null;
}
?>

    </div>
    <!-- Add the Google Charts library -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Load the Visualization API and the corechart package
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    // Create the data table
    var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);

    // Set chart options
    var options = {
        title: 'Marks Obtained in Faculty Subjects',
        hAxis: {title: 'Student Name'},
        vAxis: {title: 'Marks Obtained'},
        legend: 'none'
    };

    // Instantiate and draw the chart
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

</script>

<!-- Add a container for the chart -->
<div class="fchart">
<div id="chart_div" style="width: 100% ; height: 400px; padding:0px 50px 0px 310px"></div>
</div>
    <script src="script.js"></script>
    <!-- Add the Google Charts library -->



</body>
</html>
