<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include database connection code here
include "server.php";
$errors = array();
$success_message = "";

// Fetch suspects from the database
$suspects_query = "SELECT * FROM suspects";
$suspects_result = $conn->query($suspects_query);
$suspects = $suspects_result->fetch_all(MYSQLI_ASSOC);

// Fetch criminal offences from the database
$offences_query = "SELECT * FROM criminal_offences";
$offences_result = $conn->query($offences_query);
$offences = $offences_result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if form fields are set before accessing them
    $offence_id = isset($_POST['offence']) ? mysqli_real_escape_string($conn, $_POST['offence']) : "";
    $sentence = isset($_POST['sentence']) ? mysqli_real_escape_string($conn, $_POST['sentence']) : "";
    $location = isset($_POST['issue_location']) ? mysqli_real_escape_string($conn, $_POST['issue_location']) : "";
    $person = isset($_POST['issue_person']) ? mysqli_real_escape_string($conn, $_POST['issue_person']) : "";
    $issue_date = isset($_POST['issue_date']) ? mysqli_real_escape_string($conn, $_POST['issue_date']) : "";

    // Additional validation
    if (empty($offence_id)) {
        $errors[] = "Please select a criminal offence.";
    }

    if (!is_numeric($sentence)) {
        $errors[] = "Sentence must be a number.";
    }

    // Additional validation for date format
    if (!validateDateFormat($issue_date)) {
        $errors[] = "Invalid date format. Please use yyyy/mm/dd.";
    }

    if (empty($errors)) {
        // Insert data into the database
        $sql = "INSERT INTO criminal_records (offense_id, sentence, location, person, issue_date) 
                VALUES ('$offence_id', '$sentence', '$location', '$person', '$issue_date')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Criminal record added successfully!";
            // Redirect to the search page
            header("Location: search_criminal.php");
            exit();
        } else {
            $errors[] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function to validate date format
function validateDateFormat($date) {
    $date_regex = "/^\d{4}\/\d{2}\/\d{2}$/";
    return preg_match($date_regex, $date);
}

// Close the database connection
$conn->close();

include "html-templates/create_record.html";
?>
