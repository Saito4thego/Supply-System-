<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'sql107.infinityfree.com';   
$user = 'if0_43413216';        
$pass = 'YOUR_PASSWORD';            
$db   = 'if0_43413216_supplier'; 

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset('utf8mb4');


function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
