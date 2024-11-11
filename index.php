<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Checklist</title>
    <link rel="stylesheet" href="fonts.css">
    <style>
        

        body {
            font-family: 'Content'; /* Font family */
            font-size: 80%; /* Base font size */
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Ensure full viewport height */
            display: flex; /* Enable flexbox */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            background: linear-gradient(to bottom, blue, yellow);
            overflow: hidden; /* Prevent scrollbars */
        }

        .container {
            background-color: white; /* White background for the container */
            padding: 20px; /* Padding inside the container */
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.30); /* Subtle shadow */
            text-align: center; /* Center content within the container */
        }

        header {
            padding: 20px; /* Padding for the header */
            line-height: 10px;
            text-align: center; /* Center header content */
        }

        img {
            height: 50%; /* Adjust the logo image size */
        }

        table {
            width: 100%; /* Full-width table */
            border-collapse: collapse; /* Avoid double borders */
        }

        table, th, td {
            border: 1px solid black; /* Borders for table elements */
            padding: 8px; /* Padding for table cells */
            text-align: center; /* Center text in the table */
        }

        th {
            background-color: #f2f2f2; /* Light gray for table headers */
        }

        tr:nth-child(odd) {
            background-color: #f2f2f2; /* Alternating row colors */
        }

        .view-button {
            background-color: blue; /* Green background for the button */
            color: white;
            padding: 10px 20px; /* Padding for the button */
            text-decoration: none; 
            border-radius: 5px; /* Rounded corners */
            text-align: center; /* Center text within the button */
            cursor: pointer;
            display: inline-block; /* Prevent full-width behavior */
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.30); /* Subtle shadow for depth */
            margin: 10px auto; /* Center the button */
        }

        .view-button:hover {
            background-color: darkblue; /* Darker green on hover */
        }
    </style>
</head>
<body>
<div class="container"> <!-- Container to keep everything inside a box with rounded corners -->
    <header>
        <img src="cvsu.png" alt="School Logo"> <!-- School logo image -->
        <h2>CAVITE STATE UNIVERSITY</h2>
        <h3>Bacoor City Campus</h3><br>
        <h1>BACHELOR OF SCIENCE IN COMPUTER SCIENCE</h1>
        <h1>Checklist of Courses</h1> <!-- Checklist header -->
    </header>

    <?php
    // Database connection
    require 'connection.php';

   

    // Centered "View Checklist" button
    echo "<div>"; // No specific class needed
    echo "<br>";
    echo "<a href='wholeChecklist.php' class='view-button'>View Checklist</a><br>"; // Centered button
    echo "<a href='student.php' class='view-button'>View Student Information</a>"; // Centered button
    echo "</div>"; 

    // Close the database connection
    mysqli_close($connection);
    ?>

</div> <!-- Close the container div -->
</body>
</html>
