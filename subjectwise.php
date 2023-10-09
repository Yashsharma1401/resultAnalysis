<?php
    $averageMarks = null;
?>
<!DOCTYPE html>
<html>
<head>
    <!------======CSS=======------->
    <link rel="stylesheet" href="css/style.css">

    <!-----====== Iconscout CSS=====-->
    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Top Rankers by Subject</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        .flex-wrapper{
            margin: 0 auto;
            text-align: center;
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
            background-color: #346c60;
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
            border: 3px solid #4b230f
        }

        table th {
            background-color: #4a746d;;
            font-weight: bold;
        }

        .subject-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        body {
            background: #ceebed;
            padding: 100px 0px 0px 220px;
        }
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
        link-name{
            background-color: #6b5b95;
        }
        /*Persentage Start*/
.flex-wrapper {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center; /* Add this line */
    }





    .single-chart {
    width: 33%;
    justify-content: space-around ;
    text-align: center; /* Add this line */
    }

    .circular-chart {
    display: block;
    margin: 10px auto;
    max-width: 80%;
    max-height: 250px;
    }

    .circle-bg {
    fill: none;
    stroke: #eee;
    stroke-width: 3.8;
    }

    .circle {
    fill: none;
    stroke-width: 2.8;
    stroke-linecap: round;
    animation: progress 1s ease-out forwards;
    }

    @keyframes progress {
    0% {
        stroke-dasharray: 0 100;
    }
    }

    .circular-chart.orange .circle {
    stroke: #ff9f00;
    }

    .circular-chart.green .circle {
    stroke: #4CC790;
    }

    .circular-chart.blue .circle {
    stroke: #3c9ee5;
    }

    .percentage {
    fill: #666;
    font-family: sans-serif;
    font-size: 0.5em;
    text-anchor: middle;
    }

/*persentage end*/
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
        <h1>Top Rankers by Subject</h1>

        <form action="" method="POST">
            <label for="subject">Select Subject:</label>
            <select id="subject" name="subject">
            
                <?php
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "manstud";

                // Create a new PDO instance
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Retrieve the subjects from the database
                $stmt = $conn->prepare("SELECT * FROM subjects");
                $stmt->execute();
                $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '  <option disabled="disabled" selected="selected">Select an option.</option>';
                // Generate the options for the select element
                foreach ($subjects as $subject) {
                    echo '<option value="' . $subject['subject_id'] . '">' . $subject['subject_name'] . '</option>';
                }

                // Close the database connection
                $conn = null;
                ?>
            </select>
            <input type="submit" value="Show Top Rankers">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the selected subject ID
            $subjectId = $_POST["subject"];

            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve the subject name from the database
            $stmt = $conn->prepare("SELECT subject_name FROM subjects WHERE subject_id = :subject_id");
            $stmt->bindParam(':subject_id', $subjectId);
            $stmt->execute();
            $subject = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($subject) {
                echo '<div class="subject-name">';
                echo 'Subject: ' . $subject['subject_name'];
                echo '</div>';

                // Retrieve the top rankers for the selected subject
                $stmt = $conn->prepare("
                    SELECT marks.marks_obtained, students.student_name
                    FROM marks
                    INNER JOIN students ON marks.prn = students.prn
                    WHERE marks.subject_id = :subject_id
                    ORDER BY marks.marks_obtained DESC
                    LIMIT 3
                ");
                $stmt->bindParam(':subject_id', $subjectId);
                $stmt->execute();
                $rankers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($rankers) {
                    echo '<table>';
                    echo '<tr><th>Rank</th><th>Student Name</th><th>Marks Obtained</th></tr>';
                    $rank = 1;
                    foreach ($rankers as $ranker) {
                        echo '<tr>';
                        echo '<td>' . $rank . '</td>';
                        echo '<td>' . $ranker['student_name'] . '</td>';
                        echo '<td>' . $ranker['marks_obtained'] . '</td>';
                        echo '</tr>';
                        $rank++;
                    }
                    echo '</table>';

                    // Calculate the average marks for the selected subject
                    $stmt = $conn->prepare("SELECT AVG(marks_obtained) AS average_marks FROM marks WHERE subject_id = :subject_id");
                    $stmt->bindParam(':subject_id', $subjectId);
                    $stmt->execute();
                    $averageMarks = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($averageMarks) {
                        $percentage = round($averageMarks['average_marks']);
                        echo'<br>';
                        echo '<div class="average-marks">';
                        echo '<p>Average Marks: ' . number_format($averageMarks['average_marks'], 2) . '</p>';

                        //echo '<div class="circle-wrapper">';
                        //echo '<div class="circle-progress" data-progress="' . $percentage . '">';
                        //echo '<span class="percentage">' . $percentage . '%</span>';
                        //echo '</div>';
                        //echo '</div>';
                       
                    }
                } else {
                    echo '<p>No top rankers found for the selected subject.</p>';
                }
            } else {
                echo '<p>Invalid subject selected.</p>';
            }

            // Close the database connection
            $conn = null;
        }
        
        ?>


    
<div class="flex-wrapper">
    <div class="single-chart">
        <svg viewBox="0 0 36 36" class="circular-chart orange">
            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <path class="circle" stroke-dasharray="<?php echo $averageMarks ? number_format($averageMarks['average_marks'], 2) : '0.00' ?>, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <text x="18" y="20.35" class="percentage"><?php echo $averageMarks ? number_format($averageMarks['average_marks'], 2) . '%' : '0.00%' ?></text>
        </svg>
    </div>
</div>
       <!-- 
        <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart green">
            <path class="circle-bg"
                d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"
            />
            <path class="circle"
                stroke-dasharray="60, 100"
                d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"
            />
            <text x="18" y="20.35" class="percentage">60%</text>
            </svg>
        </div>

            <div class="single-chart">
                <svg viewBox="0 0 36 36" class="circular-chart blue">
                <path class="circle-bg"
                    d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <path class="circle"
                    stroke-dasharray="90, 100"
                    d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <text x="18" y="20.35" class="percentage">90%</text>
                </svg>
            </div>-->
            </div>
        <script src="script.js"></script>
        <script>
    // Get the average marks value from PHP
    var averageMarks = <?php echo json_encode($averageMarks['average_marks']); ?>;
  
    // Create the percentage graph
    var percentageGraph = document.createElement('div');
    percentageGraph.className = 'single-chart';
    percentageGraph.innerHTML = `
        <svg viewBox="0 0 36 36" class="circular-chart orange">
            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <path class="circle" stroke-dasharray="${averageMarks}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <text x="18" y="20.35" class="percentage">${averageMarks}%</text>
        </svg>
    `;
  
    // Append the percentage graph to the container
    document.getElementById('percentage-graph').appendChild(percentageGraph);
</script>

</body>
</html>
