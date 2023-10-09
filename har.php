<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorial";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the PRN value from the form
    $prn = $_POST["prn"];

    // Query the "marks" table to retrieve the data for the provided PRN
    $sql = "SELECT sub1, sub2, sub3, sub4, sub5, mark1, mark2, mark3, mark4, mark5 FROM marks WHERE prn = $prn";
    $result = $conn->query($sql);

    // Query the "student" table to retrieve the name for the provided PRN
    $name_query = "SELECT name FROM student WHERE prn = $prn";
    $name_result = $conn->query($name_query);

    // Fetch the name
    $name_row = $name_result->fetch_assoc();
    $name = $name_row['name'];

    // Create an array to store the data
    $data = array();

    if ($result->num_rows > 0) {
        // Loop through the result set and add each subject and its corresponding marks to the data array
        while ($row = $result->fetch_assoc()) {
            $subjectMarks = array();
            for ($i = 1; $i <= 5; $i++) {
                $subjectKey = "sub" . $i;
                $markKey = "mark" . $i;
                $subject = $row[$subjectKey];
                $mark = (int)$row[$markKey];
                $subjectMarks[] = array($subject, $mark);
            }
            $data[] = $subjectMarks;
        }

        // Output the accepted PRN and name on the graph
        echo "<h2>Accepted PRN: $prn</h2>";
        echo "<h2>Name: $name</h2>";
    } else {
        echo "No data found.";
    }

    // Close the database connection
    $conn->close();

    // Format the data as a JSON string that can be used by Google Charts
    $data_json = json_encode($data);

    if ($data_json === false) {
        echo "JSON encoding failed: " . json_last_error_msg();
    } else {
        // Output the HTML and JavaScript code for the line chart
        echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Line Graph</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Chart code goes here
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
    <p>Name: $name</p>
</body>
</html>
HTML;
}
?>

<!-- Add a form to input the PRN -->
<form method="POST" action="">
    <label for="prn">Enter PRN:</label>
    
    <input type="text" name="prn" id="prn" required>
    <button type="submit">Submit</button>
</form>

<?php
    echo <<<HTML
    <script type="text/javascript">
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Subject');
            data.addColumn('number', 'Mark');

            var dataArray = $data_json;
            for (var i = 0; i < dataArray.length; i++) {
                var subjectMarks = dataArray[i];
                for (var j = 0; j < subjectMarks.length; j++) {
                    var subject = subjectMarks[j][0];
                    var mark = subjectMarks[j][1];
                    data.addRow([subject, mark]);
                }
            }

            var options = {
                title: 'Marks by Subject',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        google.charts.setOnLoadCallback(drawChart);
    </script>
</body>
</html>
HTML;
}
?>
