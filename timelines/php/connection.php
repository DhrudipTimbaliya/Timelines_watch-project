<?php
$host = "localhost";     
$username = "root";      
$password = "";        
$database = "timelines";   

// Connection create
$con = new mysqli($host, $username, $password, $database);

// Connection check
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
