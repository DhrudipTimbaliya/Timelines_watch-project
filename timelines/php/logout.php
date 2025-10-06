<?php
session_start();
   $_SESSION['is_logged_in'] =false;
 
          // Start session
   session_unset();          // Remove all session variables
   session_destroy();        // Destroy the session
 


 header("Location: ../index.php");
?>
