<?php
if (isset($_POST['lvl2_1_id'])) {

    $lvl2_1_id = $_POST['lvl2_1_id'];

    include '../model/connect.php';

    $model = new Model();

    $rows = $model->fetch_lvl3_1($lvl2_1_id);

    echo json_encode($rows);
}
?>
