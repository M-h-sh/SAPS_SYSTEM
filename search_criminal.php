<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include database connection code here
include "server.php";
$errors = array();

// Search functionality
$search_result = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_id = mysqli_real_escape_string($conn, $_POST['search_id']);

    // Validate if search_id is not empty
    if (empty($search_id)) {
        $errors[] = "Please enter an ID number or Suspect ID to search.";
    } else {
        // Perform the search in the database using JOIN for related tables
        $sql = "SELECT suspects.*, criminal_records.*, criminal_offences.offense_name
        FROM suspects
        LEFT JOIN criminal_records ON suspects.suspect_id = criminal_records.suspect_id
        LEFT JOIN criminal_offences ON criminal_records.offense_id = criminal_offences.offense_id
        WHERE suspects.suspect_id LIKE '%$search_id%' OR suspects.id_number LIKE '%$search_id%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Combine results into a structured array
                $search_result['suspect'] = $row;
                $search_result['criminal_records'][] = array(
                    'offense' => $row['offense_name'],
                    'sentence' => $row['sentence'],
                    'location' => $row['location'],
                    'person' => $row['person'],
                    'issue_date' => $row['issue_date']
                );
            }
        } else {
            $errors[] = "Criminal record not found.";
        }
    }
}

// Close the database connection
$conn->close();
include "html-templates/search.html";
?>


