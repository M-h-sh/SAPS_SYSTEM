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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form fields
    if (empty($_POST['suspect_id']) || empty($_POST['first_name']) || empty($_POST['last_name'])) {
        $errors[] = "All fields must be filled.";
    } else {
        // Additional validation for South African ID using Luhn algorithm
        $suspect_id = $_POST['suspect_id'];
        if (!isValidSouthAfricanID($suspect_id)) {
            $errors[] = "Invalid ID number format.";
        } else {
            // Extract date of birth from the first 6 characters
            $dob = substr($suspect_id, 0, 6);

            // Check if the date of birth is in a valid format (you might want to improve this validation)
            if (!validateDateOfBirth($dob)) {
                $errors[] = "Invalid date-of-birth format in ID number.";
            }
        }
    }

    if (empty($errors)) {
        // Insert data into the database
        $suspect_id = mysqli_real_escape_string($conn, $suspect_id);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

        $sql = "INSERT INTO suspects (id_number, first_name, last_name) VALUES ('$suspect_id', '$first_name', '$last_name')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "New record added successfully!";
        } else {
            $errors[] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function to validate date of birth format (you may improve this based on your requirements)
function validateDateOfBirth($dob) {
    // Your validation logic here, for example, checking if the date is reasonable
    // This is a simplified example, you might want to use a library like Carbon for more advanced date handling

    return true;
}

// Function to check if the South African ID is valid using Luhn algorithm
function isValidSouthAfricanID($id) {
    $id = str_replace(' ', '', $id); // Remove spaces
    $sum = 0;
    $numDigits = strlen($id);
    $parity = $numDigits % 2;

    for ($i = 0; $i < $numDigits; $i++) {
        $digit = (int) $id[$i];

        if ($i % 2 == $parity) {
            $digit *= 2;

            if ($digit > 9) {
                $digit -= 9;
            }
        }

        $sum += $digit;
    }

    return $sum % 10 == 0;
}

// Close the database connection
$conn->close();
include "html-templates/record_suspect.html";
?>



