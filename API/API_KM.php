<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'HPship';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['valid' => false, 'error' => 'Database connection error']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$discountCode = isset($data['discountCode']) ? $data['discountCode'] : null;

if ($discountCode) {
    $stmt = $pdo->prepare("SELECT `soPhanTramKM` FROM `khuyenmai` WHERE `maKM` = :discountCode");
    $stmt->bindParam(':discountCode', $discountCode, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['valid' => true, 'discountPercent' => $result['soPhanTramKM']]);
    } else {
        echo json_encode(['valid' => false]);
    }
} else {
    echo json_encode(['valid' => false, 'error' => 'Invalid discount code']);
}
?>
