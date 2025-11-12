<?php
// PHP code to fetch administrative_region_id
$pdo = new PDO("mysql:host=localhost;dbname=HPship", "root", "");
$pdo->exec("set names utf8");
$province_code = $_POST['code'];

$query = "SELECT administrative_region_id FROM provinces WHERE code = :code";
$statement = $pdo->prepare($query);
$statement->execute([':code' => $province_code]);

if ($statement->rowCount() > 0) {
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['administrative_region_id' => $result['administrative_region_id']]);
} else {
    echo json_encode(['administrative_region_id' => 'undefined']); 
}

?>