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



    <title>RESULT ANALYSIS</title>

    <style>
        body {
            background: #808080;
            padding: 20px;
        }
        h2 {
            color: black;
            text-align: center;
            padding: 30px 0px 25px 0px ;
            font-family: Castellar ;
            font-size : 37px; 
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
        .title{
            margin: top 0px;
        }
        .dashboard .dash-content{
             padding-top: 20px;
        }
        .dash-content .boxes .box{
        box-shadow: 9px 5px 16px 0px rgba(40,123,255,0.58);
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
                    <a href="#">
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

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

          <!--  <div class="search-box">
             <i class="uil uil-search"></i>
             <input type="text" placeholder="search here...">
            </div>-->
            <img src="profile.jpg" alt="">
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>

                </div>
                <div class="boxes">
                <div class="box box1  ">
                    <i class="uil uil-dialpad-alt"></i>
                    <span class="text">Total Students</span>
                    <span class="number"><?php echo $totalStudents; ?></span>
                </div>
                <div class="box box2  ">
                    <i class="uil uil-dialpad-alt"></i>
                    <span class="text">Students Passed</span>
                    <span class="number"><?php echo $totalPassed; ?></span>
                </div>

                    
                    <div class="box box3">
                        <i class="uil uil-registered"></i>
                        <span class="text">Total Students Failed</span>
                        <span class="number"><?php echo $totalFailed; ?></span>
                    </div>
                </div>

            </div>

            </div>
            <div class="activity">
            <h2 class="top5">Top 5 Students</h2>
    <table>
        <tr>
            <th>PRN</th>
            <th>Student Name</th>
            <th>Total Marks</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($topStudentsResult)) {
            $prn = $row['prn'];
            $studentName = $row['student_name'];
            $totalMarks = $row['total_marks'];
            echo "<tr>";
            echo "<td>$prn</td>";
            echo "<td>$studentName</td>";
            echo "<td>$totalMarks</td>";
            echo "</tr>";
        }
        ?>
    </table>



                </div>
            </div>
        </div>
    </section>
    <script src="script.js"></script>

</body>
</html>
