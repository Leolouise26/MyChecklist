<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Checklist</title>
    <style>
        @import url('fonts.css');

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, blue, yellow); /* Gradient from blue to yellow */
            font-size: 80%;
            font-family: Content;
            height: 97vh;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            max-width: 90%;
            margin: 20px auto;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.30);
        }
        .greeting {
            display: flex;
            align-items: center;
            padding: 20px;
            font-family: Header;
            text-align: left;
        }
        
        .greeting h1 {
            margin: 0;
            font-size: 1.5em;
            margin-left: 1.5%;
        }
        
        .greeting img {
    margin-left: 20px;
    height: 5rem;
    border: 2px solid #0000ff; /* Replace #ffffff with your desired border color */
    border-radius: 50%;
}
        
        .filter-dropdown {
    padding: 5px; /* Padding for the dropdown */
    border-radius: 5px; /* Rounded corners */
    border: 1px solid #ccc; /* Light gray border */
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1); /* Inner shadow */
    background-color: white; /* Background color */
    font-family: Content; /* Consistent font */
}

.filter {
    display: flex;
    justify-content: space-between; /* Aligns items at the edges */
    align-items: center; /* Center vertically */
    padding: 10px 0; /* Padding around the filter */
}

        
        
table {
    width: 100%;
    border-collapse: collapse; /* Ensures there are no extra gaps between table cells */
    font-size: 10px; /* Consistent font size */
}

table, th, td {
    border: 1px solid black; /* Uniform border */
    padding: 8px; /* Consistent padding */
    text-align: center; /* Centered text */
}

th {
    background-color: #f2f2f2; /* Consistent background color for headers */
}

tr:nth-child(odd) {
    background-color: #f2f2f2; /* Alternating row colors */
}

        
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        
        .pagination a {
            color: gray;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 5px;
            min-width: 30px;
            display: inline-block;
        }
        
        .pagination a:hover {
            color: darkblue;
            font-weight: bold;
        }
        
        .pagination strong {
            font-weight: bold;
            color: darkblue;
            padding: 10px 20px;
            text-decoration: none;
            min-width: 30px;
            border-radius: 5px;
        }
        
        .back-button {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            margin: 0 auto;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.30);
        }

        .back-button:hover {
            background-color: darkblue;
        }
        
        .search-bar {
            padding: 8px;
            border-radius: 20px;
            border: 1px solid #ccc;
            width: 200px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1); /* Inner shadow */
            font-family: Content;
        }
        
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
        var searchTimeout;

        // Function to handle the search with debounce
        function handleSearch() {
            clearTimeout(searchTimeout); 
            searchTimeout = setTimeout(function() {
                var query = document.getElementById("search-input").value;
                if (query) { // If there's content in the search bar
                    $.post("search.php", { input: query }, function(data) { 
                        document.getElementById("search-results").innerHTML = data;
                    });
                } else { // If search bar is empty, reload the page to show original content
                    location.reload();
                }
            }, 300); // Debounce delay
        }

function handlePagination(page) {
    var input = document.getElementById("search-input").value; // Get the current search query
    $.post("search.php", { page: page, input: input }, function(data) {
        document.getElementById("search-results").innerHTML = data; // Update the search results
    });
}


    </script>
</head>
<body>
<div class="container"> <!-- Main container -->
<div class="greeting">
        <img src="Student Profile.png" alt="Student Profile"> <!-- Student's photo -->
        <?php
        require 'connection.php'; // Database connection
        
        $student_sql = "SELECT student_name FROM student WHERE student_number = '202211780'"; 
        $student_result = $connection->query($student_sql);

        if ($student_result->num_rows > 0) {
            $student_name = $student_result->fetch_assoc()["student_name"];
            echo "<h1>Hello, $student_name!</h1>";
        } else {
            echo "<h1>Hello, Student!</h1>";
        }
        ?>
    </div>
    <h2>CHECKLIST OF COURSES</h2>  
    <div class="filter"> <!-- Section for filter and search -->
        <div>
            <label for="filter-dropdown">Select Year:</label>
            <select id="filter-dropdown" name="filter-dropdown" class="filter-dropdown" onchange="redirectToYear(this.value)">
                <option value="">Select</option>
                <option value="firstYear.php">First Year</option>
                <option value="secondYear.php">Second Year</option>
                <option value="thirdYear.php">Third Year</option>
                <option value="fourthYear.php">Fourth Year</option>
            </select>
        </div>

        <div class="search-bar-container"> 
            <input type="text" id="search-input" class="search-bar" placeholder="Search..." onkeyup="handleSearch()"/> 
        </div>
    </div> 

    <div id="search-results"> 

    <script>
    function redirectToYear(page) {
        if (page) {
            window.location.href = page; // Redirect to the selected page
        }
    }
    </script>
    
    <?php
// Database connection
require 'connection.php';

// Define rows per page
$rows_per_page = 9;

// Determine which page to display based on a query parameter
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Default to page 1
$offset = ($page - 1) * $rows_per_page; // Calculate offset for the query

// SQL query to get the total number of rows
$count_sql = "SELECT COUNT(*) AS total FROM wholeChecklist"; 
$total_result = $connection->query($count_sql);
$total_rows = $total_result->fetch_assoc()["total"];
$total_pages = ceil($total_rows / $rows_per_page); // Total number of pages

// SQL query to fetch data from the wholeChecklist view with limit and offset
$sql = "SELECT * FROM wholeChecklist LIMIT $rows_per_page OFFSET $offset"; // Fetch only the rows for the current page
$result = $connection->query($sql);

// Modified SQL query to fetch data with the correct "Status" logic
$sql = "
  SELECT
    *,
    IF(
      (CAST(grade AS DECIMAL(3, 2)) <= 3 AND grade IS NOT NULL),
      'Passed',
      'Unpassed'
    ) AS status
  FROM
    wholeChecklist
  LIMIT $rows_per_page
  OFFSET $offset
";


// Execute the query
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<table>"; // Start the table
    echo "<tr>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Pre-requisite</th>
        <th>Credit Unit<br>Lecture</th>
        <th>Credit Unit<br>Lab</th>
        <th>Contact Hours<br>Lecture</th>
        <th>Contact Hours<br>Lab</th>
        <th>Grade</th>
        <th>Instructor Name</th>
        <th>Semester</th>
        <th>Year Level</th>
        <th>Status</th>
      </tr>"; // Table headers

    // Loop through the results and create rows in the table
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>" . htmlspecialchars($row["course_code"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["course_title"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["pre_requisite"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["credit_unit_lecture"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["credit_unit_lab"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["contact_hours_lecture"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["contact_hours_lab"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["grade"] ?? 'N/A') . "</td>
        <td>" . htmlspecialchars($row["instructor_name"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["semester"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["year_level"] ?? '') . "</td>
        <td>" . htmlspecialchars($row["status"] ?? '') . "</td>
      </tr>"; // Table rows
}


    echo "</table>"; // Close the table

    // Pagination logic
    echo "<div class='pagination'>";

    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "'>Previous</a>"; // Previous page link
    }

    for ($i = 1; $i <= $total_pages; $i++) { // Loop for individual page numbers
        if ($i == $page) {
            echo "<strong>$i</strong>"; // Highlight the current page
        } else {
            echo "<a href='?page=$i'>$i</a>"; // Link to specific pages
        }
    }

    if ($page < $total_pages) { // If not on the last page
        echo "<a href='?page=" . ($page + 1) . "'>Next</a>"; // Next page link
    }

    echo "</div>"; // Close the pagination div

} else {
    echo "No data found in wholeChecklist."; // If no data is available
}
// Back button
echo "<br>";
echo "<a href='index.php' class='back-button'>Back to Home</a>"; // Back to the main page

$connection->close(); // Close the database connection
?>

    </div>
</div> <!-- Close the container -->
</body>
</html>
