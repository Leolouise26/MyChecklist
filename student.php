<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Checklist</title>
    <style>
        @import url('fonts.css');

        body {
            font-family: 'Content'; /* Font family */
            font-size: 100%; /* Base font size */
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
            border-radius: 50px; /* Rounded corners */
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.30); /* Subtle shadow */
            text-align: center; /* Center content within the container */
            margin-bottom: 20px; /* Bottom margin for spacing */
            z-index: 2;
            width: 25%;
        }

        .container2 {
            font-size: 12px;    
            background-color: white; /* White background for the second container */
            padding: 20px; /* Padding inside the container */
            border-radius: 25px; /* Rounded corners */
            margin-left: -2%;
            padding-left: 3.5%;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.30); /* Subtle shadow */
            text-align: center; /* Center content within the container */
            z-index: 1;
            width: 40%;
            margin-top: -1%;
        }

        header {
            padding: 20px; /* Padding for the header */
            line-height: 10px;
            text-align: center; /* Center header content */
        }

        img {
            height: 100px; /* Adjust the logo image size */
        }

        .student-info {
            list-style-type: none; /* Remove default list styles */
            padding: 0;
            text-align: left; /* Align text to the left */
            font-size: 120%;
        }

        .student-info li {
            padding: 8px; /* Padding for list items */
            border-bottom: 1px solid #ddd; /* Border between items */
        }

        .student-info li:last-child {
            border-bottom: none; /* Remove border from the last item */
        }

        .view-button {
            background-color: blue; /* Blue background for the button */
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
            background-color: darkblue; /* Darker blue on hover */
        }

        .gwa-overview {
            margin-top: 20px;
            font-size: 120%;
        }

        .current-adviser {
            margin-top: 20px;
            font-size: 120%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        
    </style>
</head>
<body>
<div class="container"> <!-- First container -->
    <header>
        <h1> Student Information </h1>
        <img src="Student Profile.png" alt="Student Profile"> <!-- Student's photo -->
    </header>

    <?php
    // Database connection
    require 'connection.php';

    // Get student information
    $student_sql = "SELECT * FROM student";
    $student_result = mysqli_query($connection, $student_sql);

    // Output the student information as a list within the container
    if ($student_result && mysqli_num_rows($student_result) > 0) {
        while ($row = mysqli_fetch_assoc($student_result)) {
            echo "<ul class='student-info'>";
            echo "<li><strong>Student Number:</strong> " . htmlspecialchars($row["student_number"]) . "</li>";
            echo "<li><strong>Student Name:</strong> " . htmlspecialchars($row["student_name"]) . "</li>";
            echo "<li><strong>Address:</strong> " . htmlspecialchars($row["address"]) . "</li>";
            echo "<li><strong>Contact Number:</strong> " . htmlspecialchars($row["contact_number"]) . "</li>";
            echo "</ul>";
        }
    } else {
        echo "No student data available."; // If no student data is found
    }

    // Centered "View Checklist" button
    echo "<div>"; // No specific class needed
    echo "<br>";
    echo "<a href='index.php' class='view-button'>Back to Home</a>"; // Centered button
    echo "</div>"; 

    // Close the database connection
    mysqli_close($connection);
    ?>

</div> <!-- Close the first container div -->

<div class="container2"> <!-- Second container -->
    <h2 class="gwa-overview">GWA Overview</h2>
    <?php
    // Database connection
    require 'connection.php';

    // Query to fetch GWA from the database view average_grades
    $gwa_sql = "SELECT * FROM stud_average_grades";
    $gwa_result = mysqli_query($connection, $gwa_sql);

    // Check if there are results
    if ($gwa_result && mysqli_num_rows($gwa_result) > 0) {
        // Display table header
        echo "<table>";
        echo "<tr><th>Year</th><th>Semester</th><th>Grade Weighted Average</th></tr>";

        // Display data rows
        while ($row = mysqli_fetch_assoc($gwa_result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["year_level"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["semester"]) . "</td>";
            
            // Check if GWA is null or not
            if ($row["GWA"] === null) {
                echo "<td>Not yet available</td>";
            } else {
                echo "<td>" . number_format($row["GWA"], 2) . "</td>"; // Format the GWA to two decimal places
            }
            
            echo "</tr>";
        }

        echo "</table>";

        // Query to fetch current adviser from the student table
        $adviser_sql = "SELECT name_of_adviser FROM student LIMIT 1"; // Assuming there's only one current adviser
        $adviser_result = mysqli_query($connection, $adviser_sql);
        
        if ($adviser_result && mysqli_num_rows($adviser_result) > 0) {
            $adviser_row = mysqli_fetch_assoc($adviser_result);
            $current_adviser = htmlspecialchars($adviser_row["name_of_adviser"]);
            echo "<p><strong>Current Adviser:</strong> " . $current_adviser . "</p>";
        } else {
            echo "<p><strong>Current Adviser:</strong> Not available</p>";
        }
    } else {
        echo "No data available."; // If no GWA data is found
    }

    // Close the database connection
    mysqli_close($connection);
?>



</div> <!-- Close the second container div -->
</body>
</html>
