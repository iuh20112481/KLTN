<?php
if (isset($_POST['lvl1_1_id'])) { 

    $lvl1_1_id = $_POST['lvl1_1_id'];

    include '../model/connect.php';

    $model = new Model();

    $rows = $model->fetch_lvl2_1($lvl1_1_id);
    
    echo json_encode($rows);
}
?>
