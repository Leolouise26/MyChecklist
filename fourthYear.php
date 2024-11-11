<?php
require 'connection.php'; // Database connection

// SQL query to fetch Fourth Year data with a "Status" column
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$rowsPerPage = 20; // Number of rows per page
$offset = ($page - 1) * $rowsPerPage; // Offset calculation

$sql = "
  SELECT
    *,
    IF(
      CAST(grade AS DECIMAL(3, 2)) <= 3, 'Passed', 'Unpassed'
    ) AS status
  FROM
    wholeChecklist
  WHERE
    year_level = 'Fourth Year'
  LIMIT $offset, $rowsPerPage
";

$sql = "
  SELECT
    *,
    IF(
      CAST(grade AS DECIMAL(3, 2)) <= 3, 'Passed', 'Unpassed'
    ) AS status
  FROM
    wholeChecklist
  WHERE
    year_level = 'Fourth Year'
";

$result = $connection->query($sql); // Execute the query

// Check if the query execution was successful
if ($result === false) {
    echo "Error fetching Fourth Year data: " . $connection->error;
    exit; // Stop execution if there's an error
}

?>
    <style>
        @import url('fonts.css');

        body {
            font-family: Content;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, blue, yellow);
            font-size: 80%;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 50px;
            max-width: 90%;
            margin: 20px auto;
            text-align: center;
            box-shadow: 0 0 20px rgba(  0, 0, 0, 0.30);
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

        .search-bar-container {
            display: flex;
            justify-content: space-between; /* Aligns filter left and search right */
            align-items: center; /* Ensures items are vertically centered */
            padding: 10px 0;
        }

        .filter-dropdown {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: white;
            font-family: Content;
        }

        .search-bar {
            padding: 8px;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 200px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: Content;
        }
        
        .filter {
            align-items: center; /* Align items vertically */
            padding: 10px 0;
        }
        
table {
    width: 100%;
    border-collapse: collapse; /* Ensures there are no extra gaps between table cells */
    font-size: 11px; /* Consistent font size */
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
            margin-top: 1%;
        }

        .back-button:hover {
            background-color: darkblue;
        }

        #fourth-year-checklist{
            font-size: 90%;
        }

        .pagination a.active {
    color: darkblue;
    font-weight: bold;
}

    </style>
</head>
<body>
<div class="container"> <!-- Container with rounded corners -->
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
    
    <h2>Fourth Year Checklist of Courses</h2>
    <div class="search-bar-container"> <!-- Align filter left, search right -->
        <div class="filter">
            <label for="filter-dropdown">Select Year:</label>
            <select id="filter-dropdown" class="filter-dropdown" onchange="redirectToYear(this.value)">
                <option value="">Fourth Year</option>
                <option value="firstYear.php">First Year</option>
                <option value="secondYear.php">Second Year</option>
                <option value="thirdYear.php">Third Year</option>
            </select>
        </div>
        
        <div class="filter">
    <label for="sort-dropdown">Sort By:</label>
    <select id="sort-dropdown" class="filter-dropdown" onchange="applySort(this.value)">
        <option value="">Select</option>
        <option value="grade_desc">Lowest to Highest Grade</option>
        <option value="grade_asc">Highest to Lowest Grade</option>
        <option value="name_asc">A-Z Course Title</option>
        <option value="name_desc">Z-A Course Title</option>
    </select>
</div>

        <input type="text" id="search-bar" placeholder="Search..." class = "search-bar" onkeyup="applySearch()" />
    </div> <!-- End search section -->    <script>
    function redirectToYear(page) {
        if (page) {
            window.location.href = page; // Redirect to the selected page
        }
    }
    </script>
    <div id="fourth-year-checklist">
        <?php if ($result->num_rows > 0): ?> 
            <table> 
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credit Unit<br>Lecture</th>
                    <th>Credit Unit<br>Lab</th>
                    <th>Contact Hours<br>Lecture</th>
                    <th>Contact Hours<br>Lab</th>
                    <th>Grade</th>
                    <th>Instructor Name</th>
                    <th>Semester</th>
                    <th>Status</th> 
                </tr> 
                
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["course_code"]) ?></td>
                        <td><?= htmlspecialchars($row["course_title"]) ?></td>
                        <td><?= htmlspecialchars($row["credit_unit_lecture"]) ?></td>
                        <td><?= htmlspecialchars($row["credit_unit_lab"]) ?></td>
                        <td><?= htmlspecialchars($row["contact_hours_lecture"]) ?></td>
                        <td><?= htmlspecialchars($row["contact_hours_lab"]) ?></td>
                        <td><?= htmlspecialchars($row["grade"] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row["instructor_name"]) ?></td>
                        <td><?= htmlspecialchars($row["semester"]) ?></td>
                        <td><?= htmlspecialchars($row["status"]) ?></td> 
                    </tr> 
                <?php endwhile; ?>
                <!-- Include the summary row -->
                <?php include 'summary.php'; // Include the summary row ?>
            
            </table>
        <?php else: ?>
            <p><b>No matching fourth year records found.</p>
        <?php endif; ?>
    </div>
    <?php
// Calculate total number of pages
$totalRows = $result->num_rows; // Assuming $result is your query result
$totalPages = ceil($totalRows / $rowsPerPage);

// Pagination links
echo '<div class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    echo '<a href="?page=' . $i . '" class="' . $activeClass . '">' . $i . '</a>';
}
echo '</div>';
?>

    
    <script>

function applySearch() {
    var query = document.getElementById("search-bar").value.toLowerCase(); // Get the search query
    var rows = document.querySelectorAll("#fourth-year-checklist table tr"); // Get all rows

    if (query === "") { // If the search bar is empty, reload the original table
        location.reload(); // Reload the entire page
        return; // Exit the function early
    }

    var visibleCount = 0;
    var totalCourses = 0;
    var totalCreditLecture = 0;
    var totalCreditLab = 0;
    var totalContactLecture = 0;
    var totalContactLab = 0;
    var totalGrades = 0;
    var gradeCount = 0;

    rows.forEach((row, index) => {
        if (index === 0 || row.classList.contains("summary-row")) return; // Skip the header and summary rows

        var cells = row.querySelectorAll("td");
        var matches = false;

        cells.forEach(cell => {
            if ((cell.textContent || cell.innerText).toLowerCase().includes(query)) {
                matches = true;
            }
        });

        if (matches) {
            row.style.display = ""; // Show if there's a match
            visibleCount++; // Count visible rows

            // Update summary values
            totalCourses++;
            totalCreditLecture += parseFloat(cells[2].textContent); // Credit Unit Lecture
            totalCreditLab += parseFloat(cells[3].textContent); // Credit Unit Lab
            totalContactLecture += parseFloat(cells[4].textContent); // Contact Hours Lecture
            totalContactLab += parseFloat(cells[5].textContent); // Contact Hours Lab
            var grade = parseFloat(cells[6].textContent);
            if (!isNaN(grade)) {
                totalGrades += grade;
                gradeCount++;
            }
        } else {
            row.style.display = "none"; // Hide if no match
        }
    });

    var fourthYearChecklist = document.getElementById("fourth-year-checklist");

    if (visibleCount === 0) {
        // If no rows are visible, replace the content with a message
        fourthYearChecklist.innerHTML = "<p><b>No matching fourth-year records found.</b></p>";
    } else {
        // Create and append the summary row based on visible results
        var averageGrade = gradeCount > 0 ? (totalGrades / gradeCount).toFixed(2) : 'N/A';

        var summaryRow = `
            <tr class="summary-row">
                <td colspan="1"><b>Summary</b></td>
                <td><b>${totalCourses}</b></td>
                <td><b>${totalCreditLecture.toFixed(2)}</b></td>
                <td><b>${totalCreditLab.toFixed(2)}</b></td>
                <td><b>${totalContactLecture.toFixed(2)}</b></td>
                <td><b>${totalContactLab.toFixed(2)}</b></td>
                <td><b>${averageGrade}</b></td>
                <td colspan="3"></td>
            </tr>
        `;

        // Replace the existing summary row with the updated one
        var existingSummaryRow = fourthYearChecklist.querySelector(".summary-row");
        if (existingSummaryRow) {
            existingSummaryRow.innerHTML = summaryRow;
        } else {
            fourthYearChecklist.querySelector("table").insertAdjacentHTML('beforeend', summaryRow);
        }
    }
}

function applySort(sortBy) {
    var table = document.querySelector("#fourth-year-checklist table");
    var rows = Array.from(table.rows).slice(1, -1); // Exclude header row and summary row

    // Sort the rows based on the selected criteria
    switch (sortBy) {
        case "grade_desc":
            rows.sort((a, b) => {
                var gradeA = parseFloat(a.cells[6].textContent) || -Infinity;
                var gradeB = parseFloat(b.cells[6].textContent) || -Infinity;
                return gradeB - gradeA;
            });
            break;
        case "grade_asc":
            rows.sort((a, b) => {
                var gradeA = parseFloat(a.cells[6].textContent) || Infinity;
                var gradeB = parseFloat(b.cells[6].textContent) || Infinity;
                return gradeA - gradeB;
            });
            break;
        case "name_asc":
            rows.sort((a, b) => {
                var nameA = a.cells[1].textContent.trim().toUpperCase();
                var nameB = b.cells[1].textContent.trim().toUpperCase();
                return nameA.localeCompare(nameB);
            });
            break;
        case "name_desc":
            rows.sort((a, b) => {
                var nameA = a.cells[1].textContent.trim().toUpperCase();
                var nameB = b.cells[1].textContent.trim().toUpperCase();
                return nameB.localeCompare(nameA);
            });
            break;
        default:
            return;
    }

    // Remove all rows from the table except the header row
    while (table.rows.length > 1) {
        table.deleteRow(1);
    }

    // Re-append sorted rows to the table
    rows.forEach(row => table.appendChild(row));

    // Calculate and update summary after sorting
    var totalCourses = rows.length;
    var totalCreditLecture = 0;
    var totalCreditLab = 0;
    var totalContactLecture = 0;
    var totalContactLab = 0;
    var totalGrades = 0;
    var gradeCount = 0;

    rows.forEach(row => {
        totalCreditLecture += parseFloat(row.cells[2].textContent);
        totalCreditLab += parseFloat(row.cells[3].textContent);
        totalContactLecture += parseFloat(row.cells[4].textContent);
        totalContactLab += parseFloat(row.cells[5].textContent);
        var grade = parseFloat(row.cells[6].textContent);
        if (!isNaN(grade)) {
            totalGrades += grade;
            gradeCount++;
        }
    });

    var averageGrade = gradeCount > 0 ? (totalGrades / gradeCount).toFixed(2) : 'N/A';

    var summaryRow = `
        <tr class="summary-row">
            <td colspan="1"><b>Summary</b></td>
            <td><b>${totalCourses}</b></td>
            <td><b>${totalCreditLecture.toFixed(2)}</b></td>
            <td><b>${totalCreditLab.toFixed(2)}</b></td>
            <td><b>${totalContactLecture.toFixed(2)}</b></td>
            <td><b>${totalContactLab.toFixed(2)}</b></td>
            <td><b>${averageGrade}</b></td>
            <td colspan="3"></td>
        </tr>
    `;

    // Append or update summary row in the table
    table.insertAdjacentHTML('beforeend', summaryRow);
}


    </script> <!-- JavaScript code for search -->
    
    <a href="wholeChecklist.php" class="back-button">Back to Checklist</a>
    <a href="index.php" class="back-button">Back to Home</a>
</div> <!-- Close the container -->
</body>
</html>

<?php $connection->close(); // Close the database connection ?>
