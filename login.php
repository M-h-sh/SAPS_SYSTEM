<?php
session_start();

// Validate login (replace with actual authentication logic)
if ($_POST['username'] == 'admin@email.com' && $_POST['password'] == 'admin') {
    $_SESSION['username'] = $_POST['username'];
    header("Location: dashboard.php");
} else {
    header("Location: index.php?error=1");
}
?>
