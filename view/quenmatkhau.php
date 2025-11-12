<?php
    $loi="";
    if(isset($_POST['nutguiyeucau'])==true){
        $email=$_POST['email'];
        $conn=new PDO ("mysql:host=localhost;dbname=HPship;charset=utf8","root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="SELECT * from taikhoan WHERE emailND = ? ";
        $stmt = $conn->prepare($sql); 
        $stmt->execute([$email]);
        $count= $stmt->rowCount();
        if ($count==0)
        {
            $loi= "Email bạn nhập chưa đăng ký thành viên với HPship !";
        }
        else
        {
            $matkhaumoi= substr ( md5(rand(0,999999)) , 0 ,8);
            $sql="UPDATE taikhoan set mkND=? WHERE emailND = ? ";
            $stmt = $conn->prepare($sql); 
            $stmt->execute([$matkhaumoi, $email]);
            GuiMatKhauMoi($email, $matkhaumoi);
        }
    }
?>

<?php
    function GuiMatKhauMoi($email,$matkhaumoi){
        require "../PHPMailer/src/PHPMailer.php"; 
        require "../PHPMailer/src/SMTP.php"; 
        require '../PHPMailer/src/Exception.php'; 
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->SMTPDebug = 0; //0,1,2: chế độ debug
            $mail->isSMTP();  
            $mail->CharSet  = "utf-8";
            $mail->Host = 'smtp.gmail.com';  //SMTP servers
            $mail->SMTPAuth = true; // Enable authentication
            $mail->Username = 'tuhugo02@gmail.com'; // SMTP username
            $mail->Password = 'zzxm exwu lzvr dioy';   // SMTP password
            $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
            $mail->Port = 465;  // port to connect to                
            $mail->setFrom('tuhugo02@gmail.com', 'CÔNG TY HPship' ); 
            $mail->addAddress($email); 
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = "Thư khôi phục mật khẩu";
            $noidungthu = "<p>Xin chào! Bạn nhận được thư này, do bạn hoặc ai đó yêu cầu cấp mật khẩu mới từ HPship.com</p>
            Mật khẩu của bạn là: {$matkhaumoi}
            "; 
            $mail->Body = $noidungthu;
            $mail->smtpConnect( array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            ));
            $mail->send();
            echo '
                <div class="alert alert-success text-center">
                    <strong>Vui lòng kiểm tra Email của bạn để nhận mật khẩu mới !</strong>
                    <br>
                    <p>Để đảm bảo an toàn, bạn vui lòng đổi mật khẩu sau khi đăng nhập !</p>
                    <p>Bạn có thể trở về Đăng nhập !</p>
                </div>    
            ';
        } catch (Exception $e) {
            echo 'Error: ', $mail->ErrorInfo;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container p-5 ">
        <div class="row justify-content-center ">
            <div class="col-md-6">
                <div class="card shadow" style="background-color:#eaffca;">
                    <div class="pt-3 p-3 bg-white">
                        <a id="p1-content" href="dangNhap.php" style="text-decoration:none;">Về trang chủ</a>
                    </div>
                    <div class="card-body p-5">
                        <h2 id="h2-content" class="text-center mb-4">QUÊN MẬT KHẨU</h2>
                        <?php if ($loi!=""){ ?>
                            <div class="alert alert-danger text-center"><?=$loi?></div>
                        <?php } ?>
                        <form method="post">
                            <div class="mb-3">
                                <label id="p1-content" for="email" class="form-label">Nhập Email :</label>
                                <input value="<?php if (isset($email)==true) echo $email?>" type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <br>
                            <div class="text-center">
                                <button type="submit" name="nutguiyeucau" value="nutgui" class="btn btn-warning btn-block hover shadow" style="padding: 11px 14px;;">Gửi yêu cầu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>