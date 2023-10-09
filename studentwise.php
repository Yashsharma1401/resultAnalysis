<!-- index.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Student Marks Graph</title>
    <style>
        .container {
            margin: 0px 20px 20px 480px;
            width: 40%;
            
            padding: 50px 0px 50px 100px;
        }

        input[type="text"] {
            width: 40%;
            padding: 10px;
            margin-bottom: 10px;
            margin: left 50px;
        }

        input[type="submit"] {
            width: 40%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin: left 50px;
        }
        
        .graph{
            
            margin: 0px 20px 20px 480px;
            width: 40%;
            border: 3px solid green;
            padding: 50px 0px 50px 10px;
        }
/*-------------------------------*/
    .flex-wrapper {
    display: flex;
    flex-flow: row nowrap;
    }

    .single-chart {
    width: 33%;
    justify-content: space-around ;
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
            
    </style>
    <!------======CSS=======------->
    <link rel="stylesheet" href="css/style.css">

    <!-----====== Iconscout CSS=====-->
    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

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
        <h1>Student Marks Graph</h1>
<!--
        <form action="graphs/graph.php" method="GET">
            <label for="prn">Enter PRN:</label>
            <input type="text" id="prn" name="prn" required><br>
            <input type="submit" value="Generate Graph">
        </form>-->
    </div>
    <div class="graph">
    <?php
        include 'graphs/graph.php';
    ?>
<!--
    </div>
        <div class="flex-wrapper">
    <div class="single-chart">
        <svg viewBox="0 0 36 36" class="circular-chart orange">
        <path class="circle-bg"
            d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831"
        />
        <path class="circle"
            stroke-dasharray="30, 100"
            d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831"
        />
        <text x="18" y="20.35" class="percentage">30%</text>
        </svg>
    </div>
    
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
        </div>
        </div>-->
    <script src="script.js"></script>
</body>
</html>
