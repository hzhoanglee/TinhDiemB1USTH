<?php
//echo json_encode($_GET);
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
    if($_SESSION["student-id"] == NULL){
        http_response_code(403);
        die('Forbidden');
    }
}
require_once('db.php');

//Defining Function
function update_diem($mon, $value, $student_id){
    global $conn;
    $sql = "UPDATE `users` SET `$mon`='$value' WHERE sid = $student_id";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

$lang = array("l_n" => "Listening & Note-taking","pre" => "Presentation","wri" => "Academic Writing","laweco" => "Law/Eco","cellbio" => "Cellular biology","gen" => "Genetics","biochem" => "Biochemistry","genmicro" => "General microbiology","genchem" => "General Chemistry I","genchem2" => "General Chemistry II","orgchem" => "Organic Chemistry","prac_chem" => "Practical chemistry","basic_pro" => "Basic programming","infor" => "Introduction to Informatics","algo" => "Introduction to Algorithms","ca" => "Computer Architecture","line" => "Linear Algebra","cal1" => "Calculus I","cal2" => "Calculus II","discrete" => "Discrete Mathematics","phys1" => "Fundamental Physics I","phys2" => "Fundamental Physics II","electro" => "Electromagnetism","prac_phys" => "Practical physics");
$heso = array("l_n"=>2, "pre"=>3, "wri"=>3, "laweco"=>2, "cellbio"=>4, "gen"=>3, "biochem"=>3, "genmicro"=>3, "genchem"=>4, "genchem2"=>4, "orgchem"=>4, "prac_chem"=>2, "basic_pro"=>4, "infor"=>3, "algo"=>3, "ca"=>3, "line"=>4, "cal1"=>4, "cal2"=>3, "discrete"=>3, "phys1"=>4, "phys2"=>4, "electro"=>4, "prac_phys"=>2);


$mon = $_GET['mon'];
$diem = $_GET['diem'];
if ($diem == 0) {$diem = NULL;}
$student_id = $_SESSION["student-id"];

//UPDATE DIEM
$sql = "UPDATE `users` SET `$mon`='$diem' WHERE sid = '$student_id'";
$result = $conn->query($sql);
$conn->close();
$response['diemtrongso'] = round($diem * $heso[$mon],1);

switch (true){
    case $diem >= 18:
        $response['diemhe4'] = 4;
        $response['diemchu'] = 'A+';
        break;
    case $diem >= 16 and $diem <18:
        $response['diemhe4'] = 3.7;
        $response['diemchu'] = 'A';
        break;
    case $diem >= 14 and $diem <16:
        $response['diemhe4'] = 3.5;
        $response['diemchu'] = 'B+';
        break;
    case $diem >= 13 and $diem <14:
        $response['diemhe4'] = 3;
        $response['diemchu'] = 'B';
        break;
    case $diem >= 12 and $diem <13:
        $response['diemhe4'] = 2.5;
        $response['diemchu'] = 'C+';
        break;
    case $diem >= 11 and $diem <12:
        $response['diemhe4'] = 2;
        $response['diemchu'] = 'C';
        break;
    case $diem >= 10 and $diem <11:
        $response['diemhe4'] = 1.5;
        $response['diemchu'] = 'D';
        break;
    default:
        $response['diemhe4'] = 0;
        $response['diemchu'] = 'F';
}

header("Content-Type: application/json");
echo (json_encode($response));