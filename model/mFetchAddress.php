<?php
class Model{
    private $server ="localhost";
    private $username ="root";
    private $password ="";
    private $db ="HPship";
    private $conn;
    
    public function __construct(){

        try {
            $this->conn= new mysqli($this->server, $this->username, $this->password, $this->db);
            $this->conn->set_charset("utf8");

        } catch (Exception $e){
            echo "db error" .$e->getMessage();
        }
    } 

    public function fetch_lvl1(){
        $data=null;
        $query="SELECT * FROM provinces";
        if($sql= $this->conn->query($query)){
            while($row= mysqli_fetch_assoc($sql)){
                 $data[]=$row;
            }
        }
        return $data;
    }

    public function fetch_lvl2($lvl1_id){
        $data = null;
        $query = "SELECT *
                    FROM districts
                    WHERE province_code = '$lvl1_id'
                    ORDER BY
                    CASE
                        WHEN full_name REGEXP '^Quận ([0-9]|1[0-2])$' THEN
                        CAST(SUBSTRING(full_name, 7) AS UNSIGNED)  
                        ELSE
                        1000 
                    END,
                    full_name ASC;
                    ";
        if( $sql= $this->conn->query($query)){
            while($row = mysqli_fetch_assoc($sql)){
                $data[] = $row;

            }
        }
        return $data;
    }

    public function fetch_lvl3($lvl2_id){
        $data = null ; 
        $query = "SELECT *
                    FROM wards
                    WHERE district_code = '$lvl2_id'
                    ORDER BY
                    CASE
                        WHEN full_name REGEXP '^Quận ([0-9]|1[0-2])$' THEN
                        CAST(SUBSTRING(full_name, 7) AS UNSIGNED)  
                        ELSE
                        1000 
                    END,
                    full_name ASC;" ;
        if ($sql = $this->conn->query($query)){
            while($row = mysqli_fetch_assoc($sql)){
                $data[]=$row;
            }
        }
        return $data; 
    }

    
    // Phương thức mới cho lvl1_1
    public function fetch_lvl1_1(){
        $data=null;
        // Viết truy vấn tương ứng cho cấp độ lvl1_1
        $query="SELECT * FROM provinces";
        if($sql= $this->conn->query($query)){
            while($row= mysqli_fetch_assoc($sql)){
                 $data[]=$row;
            }
        }
        return $data;
    }

    // Phương thức mới cho lvl2_1
    public function fetch_lvl2_1($lvl1_1_id){
        $data = null;

        // Viết truy vấn tương ứng cho cấp độ lvl2_1, sử dụng $lvl1_1_id nếu cần
        $query = "SELECT *
                    FROM districts
                    WHERE province_code = '$lvl1_1_id'
                    ORDER BY
                    CASE
                        WHEN full_name REGEXP '^Quận ([0-9]|1[0-2])$' THEN
                        CAST(SUBSTRING(full_name, 7) AS UNSIGNED)  
                        ELSE
                        1000 
                    END,
                    full_name ASC;";
        if( $sql= $this->conn->query($query)){
            while($row = mysqli_fetch_assoc($sql)){
                $data[] = $row;

            }
        }
        return $data;
    }

    // Phương thức mới cho lvl3_1
    public function fetch_lvl3_1($lvl2_1_id){ 
        $data = null ; 
        // Viết truy vấn tương ứng cho cấp độ lvl3_1, sử dụng $lvl2_1_id nếu cần
        $query = "SELECT *
                    FROM wards
                    WHERE district_code = '$lvl2_1_id'
                    ORDER BY
                    CASE
                        WHEN full_name REGEXP '^Quận ([0-9]|1[0-2])$' THEN
                        CAST(SUBSTRING(full_name, 7) AS UNSIGNED)  
                        ELSE
                        1000 
                    END,
                    full_name ASC;" ;        if ($sql = $this->conn->query($query)){
            while($row = mysqli_fetch_assoc($sql)){
                $data[]=$row;
            }
        }
        return $data; 
    }
}
?>
