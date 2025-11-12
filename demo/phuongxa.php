<?php
if (isset($_POST['lvl2_id'])) {
    $lvl2_id = $_POST['lvl2_id'];
    fetch_lvl3_data($lvl2_id);
} elseif (isset($_POST['lvl2_1_id'])) {
    $lvl2_1_id = $_POST['lvl2_1_id'];
    fetch_lvl3_1_data($lvl2_1_id);
}

function fetch_lvl3_data($lvl2_id) {
    include '../model/connect.php';
    $model = new Model();
    $rows = $model->fetch_lvl3($lvl2_id);
    echo json_encode($rows);
}

function fetch_lvl3_1_data($lvl2_1_id) {
    include '../model/connect.php';
    $model = new Model();
    $rows = $model->fetch_lvl3_1($lvl2_1_id);
    echo json_encode($rows);
}
?>
