<!DOCTYPE html>
<html>
<head>
    <title>Student Marks Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            display: block;
            margin: 0 auto;
        }
        .sname{
            text-align:center;
        }
        /*.sgraph{
            max-width: 500px;
            height:300px;
            width:200px;
        }*/
        #marksChart{
            height: 200px;
            width: 450px;
        }

    </style>
</head>
<body>
    <?php
    // Check if PRN is provided via GET request
    if (isset($_GET['prn'])) {
        $prn = $_GET['prn'];

        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "manstud";

        // Create a new PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query
        $stmt = $conn->prepare("SELECT marks_obtained, subject_name, student_name FROM marks INNER JOIN subjects ON marks.subject_id = subjects.subject_id INNER JOIN students ON marks.prn = students.prn WHERE students.prn = :prn");
        $stmt->bindParam(':prn', $prn);
        $stmt->execute();

        // Fetch all rows as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            // Extract the marks, subject names, and student name from the result
            $marks = [];
            $subjects = [];
            $studentName = '';
            foreach ($result as $row) {
                $marks[] = $row['marks_obtained'];
                $subjects[] = $row['subject_name'];
                $studentName = $row['student_name'];
            }

            // Generate the graph using Chart.js
            //echo '<h1>Student Marks Graph</h1>';
            echo '<div class="sname">';
            echo '<h2>Student: ' . $studentName . '</h2>';
            echo '<canvas id="marksChart"></canvas>';
            echo '</div>';

            // Convert the marks and subjects arrays to JSON format
            $marks_json = json_encode($marks);
            $subjects_json = json_encode($subjects);
            echo '<div class="sgraph">';
            // Echo the JavaScript code to generate the graph
            echo "
            <script>
                var marksData = {
                    labels: $subjects_json,
                    datasets: [{
                        label: 'Marks Obtained',
                        data: $marks_json,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                };

                var marksOptions = {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                };

                var marksChart = new Chart('marksChart', {
                    type: 'bar',
                    data: marksData,
                    options: marksOptions
                });
            </script>";
            echo '</div>';
        } else {
            echo "<h1>No Data Found</h1>";
        }
    } else {
        echo "<h1>Please Enter the Data</h1>";
    }
    ?>

    <form action="" method="GET">
        <label for="prn">Enter PRN:</label>
        <input type="text" id="prn" name="prn" required><br>
        <input type="submit" value="Generate Graph">
    </form>

</body>
</html>
