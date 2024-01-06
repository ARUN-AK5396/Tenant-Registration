<?php
    session_start();
    session_destroy();
    header("Location: ../index.html"); // Redirect to the login page
    exit();
?>