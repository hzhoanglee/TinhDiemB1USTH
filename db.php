<?php
$servername = "localhost";
$username = "sts";
$password = "sts";
$dbname = "sts";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}