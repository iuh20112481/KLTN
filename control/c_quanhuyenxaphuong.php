<?php
if (isset($_POST['lvl1_id'])) {
    $lvl1_id = $_POST['lvl1_id'];
    fetch_lvl2_data($lvl1_id);
} elseif (isset($_POST['lvl1_1_id'])) {
    $lvl1_1_id = $_POST['lvl1_1_id'];
    fetch_lvl2_1_data($lvl1_1_id);
} elseif (isset($_POST['lvl2_id'])) {
    $lvl2_id = $_POST['lvl2_id'];
    fetch_lvl3_data($lvl2_id);
} elseif (isset($_POST['lvl2_1_id'])) {
    $lvl2_1_id = $_POST['lvl2_1_id'];
    fetch_lvl3_1_data($lvl2_1_id);
}

function fetch_lvl2_data($lvl1_id) {
    include_once '../model/mFetchAddress.php';
    $model = new Model();
    $rows = $model->fetch_lvl2($lvl1_id);
    echo json_encode($rows);
}

function fetch_lvl2_1_data($lvl1_1_id) {
    include_once '../model/mFetchAddress.php';
    $model = new Model();
    $rows = $model->fetch_lvl2_1($lvl1_1_id);
    echo json_encode($rows);
}

function fetch_lvl3_data($lvl2_id) {
    include_once '../model/mFetchAddress.php';
    $model = new Model();
    $rows = $model->fetch_lvl3($lvl2_id);
    echo json_encode($rows);
}

function fetch_lvl3_1_data($lvl2_1_id) {
    include_once '../model/mFetchAddress.php';
    $model = new Model();
    $rows = $model->fetch_lvl3_1($lvl2_1_id);
    echo json_encode($rows);
}
?>
