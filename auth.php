<?php
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
} else {
    header('Location: index.php');
}
$student_id = $_POST['student-id'];
require_once ('db.php');

$sql = "SELECT * FROM users WHERE sid = '$student_id'";
$result = $conn->query($sql)->fetch_assoc();

$_SESSION["student-id"] = $result["sid"];
$_SESSION["name"] = $result["name"];
$_SESSION["khoa"] = $result["khoa"];
$conn->close();
header('Location: index.php');