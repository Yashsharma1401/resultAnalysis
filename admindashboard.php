<?php
@include 'conn.php';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve student PRN from the form
    $deletePrn = $_POST['delete'];

    // Retrieve the name of the student being deleted
    $studentQuery = "SELECT student_name FROM students WHERE prn = '$deletePrn'";
    $result = mysqli_query($conn, $studentQuery);
    $student = mysqli_fetch_assoc($result);
    $deletedStudentName = $student['student_name'];
    // Delete student's records from 'marks' table
    $deleteMarksQuery = "DELETE FROM marks WHERE prn = '$deletePrn'";
    mysqli_query($conn, $deleteMarksQuery);
    
    // Delete student from 'students' table
    $deleteStudentQuery = "DELETE FROM students WHERE prn = '$deletePrn'";
    mysqli_query($conn, $deleteStudentQuery);

    

    // Display alert box with the name of the deleted student
    echo "<script>alert('Student $deletedStudentName has been deleted.');</script>";
}

// Fetch student details from the database
$fetchQuery = "SELECT s.prn, s.student_name, s.student_email, s.admi_year, SUM(marks_obtained) AS total_marks
               FROM students s
               LEFT JOIN marks m ON s.prn = m.prn
               GROUP BY s.prn";
$result = mysqli_query($conn, $fetchQuery);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #adminlogin{
            background: #ea97f4;
        }
        .register{
            background: #ffa9a9;
            border:solid black 2px;
            border-radius:8px;
        }
        .regibutt{
            background:red
            float: right;
            margin-left:auto;
            margin-right: 0;
        }
        .container{
            height:auto;
            width:1000px;
            margin: left 0;
            margin: right 0;
            padding: ;
        }
        h2{
            width: 100%;
            margin: left 30px;
        }
    </style>

    <title>RESULT ANALYSIS</title>
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
                <li id="adminlogin">
                    <a href="adminlogin/login.php">
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

    <section class="dashboard">
        <!-- Dashboard section code here -->
        <div class="register">
            <h3>Register A Student :--</h3>
            <a href="registration.php" class="regibutt">Register</a>
        </div>
        <div>
            <h3>Enter Student Marks :--</h3><a href="marks.php">Marks</a>
        </div>
        <hr><hr><br>
        <div>
            <h2>Students:</h2>
            <div class="container">
                <div class="row">
                    <div class="">
                        <?php echo $deleteMsg??''; ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>PRN</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Admission Year</th>
                                    <th>Total Marks</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ($students as $student) { ?>
                                    <tr>
                                        <td><?php echo $student['prn']; ?></td>
                                        <td><?php echo $student['student_name']; ?></td>
                                        <td><?php echo $student['student_email']; ?></td>
                                        <td><?php echo $student['admi_year']; ?></td>
                                        <td><?php echo $student['total_marks']; ?></td>
                                        <td>
                                            <form method="post">
                                                <button type="submit" name="delete" value="<?php echo $student['prn']; ?>" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="script.js"></script>

</body>
</html>
