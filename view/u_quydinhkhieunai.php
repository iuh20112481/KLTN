<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
      document.addEventListener('copy', function(e) {
        e.preventDefault(); // Chặn sao chép
      });

      document.addEventListener('cut', function(e) {
        e.preventDefault(); // Chặn cắt
      });

      document.addEventListener('contextmenu', function(e) {
        e.preventDefault(); // Chặn nhấp chuột phải
      });
    </script>
    <style>
        /* Custom FONT */
        @font-face {
        font-family: 'Samsung One 400';
        src: url('../WEBSITE_EXHIBITION/font/SamsungOne-400.ttf') format('woff2'),
            url('../WEBSITE_EXHIBITION/font/SamsungOne-400.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
        }

        @font-face {
            font-family: 'Samsung One 700';
            src: url('../font/SamsungOne-700.ttf') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'Samsung Sharp Sans Bold';
            src: url('../font/SamsungSharpSans-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'SamsungSharpSans-Bold_SMCPS';
            src: url('../font/iCiel-SamsungSharpSans-Bold_SMCPS.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        h1{
            font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif;
        }
        p, ul{
            font-family: 'Samsung One 400', Arial, sans-serif;
        }
        h2{
            font-family: 'Samsung Sharp Sans Bold', Arial, sans-serif;
        }
        h3{
            font-family: 'Samsung One 700', Arial, sans-serif;}
        ul {
        list-style-type: circle; /* Định dạng kiểu dấu chấm */
        padding-left: 20px; /* Thêm khoảng cách bên trái */
        }
        ul li {
        line-height: 1.6; /* Giãn dòng giữa các mục trong danh sách */
        margin-bottom: 10px; /* Khoảng cách giữa các mục */
        }

        body {
            height: 100vh;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f9f9f9;
            user-select: none;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .heading-page {
            padding: 20px 0 20px;
            text-align: center;
            position: relative; 
        }

        .heading-page h1 {
            font-size: 2em;
            font-weight: bold;
        }

        .heading-page h1:after {
            content: "";
            position: absolute;
            left: 10%;
            bottom: 25px; 
            right: 10%;
            height: 3px;
            background: #00467f; /* Màu đường kẻ */
        }

        .content-page {
            padding: 20px 40px; /* Thêm padding */
            margin-bottom: 50px;
            background-color: #fff; /* Nền trắng */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Bóng đổ nhẹ */
            border-radius: 10px; /* Bo góc */ 
            width: 60%;
        }

        .content-page p {
            line-height: 1.6; /* Dễ đọc hơn */
        }

        .content-page h2 {
            font-size: 1.5em;
            font-weight: bold;
            color: #00467f; /* Màu tiêu đề */
        }

        .content-page h3 {
            font-size: 1.3em;
            color: #0066cc; /* Màu khác cho phân cấp thấp hơn */
        }

        .content-page ul {
            list-style-type: circle;
            padding-left: 20px; /* Khoảng cách bên trái */
            margin-bottom: 20px;
        }

        .content-page ul li {
            margin-bottom: 10px; /* Khoảng cách giữa các mục */
            padding-left: 10px; /* Để các mục không quá sát */
        }

        .content-page hr {
            border: none;
            border-top: 1px solid #ddd; /* Đường kẻ phân cách */
            margin: 20px 0; /* Khoảng cách trên và dưới */
        }

    </style>
</head>
<body>

        <div class="heading-page">
            <h1>QUY ĐINH VỀ KHIẾU NẠI CỦA HPship</h1>
        </div>
        <div class="content-page add-height-img">
        <h2>
            <strong>
                I. QUY ĐỊNH VỀ KHIẾU NẠI
            </strong>
        </h2>
        <h3>
            <strong>
                1. Thời hiệu khiếu nại:
            </strong>
        </h3>
        <p>
            Việc khiếu nại quy định tại Điều này phải được lập thành văn bản. Thời hiệu khiếu nại được quy định như sau:
        </p>
        <strong>Thời hiệu khiếu nại đối với dịch vụ chuyển phát Bưu gửi bằng xe máy:</strong> 
        <ul type="circle">
            <li>
            06 (sáu) tháng, kể từ ngày kết thúc Thời gian Toàn trình của Bưu gửi đối với khiếu nại về việc mất Bưu gửi, chuyển phát Bưu gửi chậm so với Thời gian Toàn trình đã công bố.
            </li>
            <li>01 (một) tháng, kể từ ngày Bưu gửi được phát cho người nhận đối với khiếu nại về việc Bưu gửi bị suy suyển, hư hỏng, về giá cước và các nội dung khác có liên quan trực tiếp đến Bưu gửi.
            </li>
        </ul>
        <strong>Thời hiệu khiếu nại đối với dịch vụ bằng xe tải:</strong> 
        <ul type="circle">
            <li>
            01 (một) tháng, kể từ ngày kết thúc Thời gian Toàn trình của Hàng hóa đối với khiếu nại về việc mất Hàng hóa, giao Hàng hóa chậm so với thời gian toàn trình tại bảng giá;
            </li>
            <li>
            48 (bốn mươi tám) giờ, kể từ ngày Hàng hóa được phát cho người nhận đối với khiếu nại về việc Hàng hóa bị suy suyển, hư hỏng, về giá cước và các nội dung khác có liên quan trực tiếp đến Hàng hóa
            </li>
        </ul>
        <h3>
            <strong>
                2. Các kênh tiếp nhận khiếu nại:
            </strong>
        </h3>
        <p>
        a. Tất cả các vấn đề liên quan đến giao hàng, xử lý sự cố phát sinh, phải được thông báo đến Bộ phận Chăm sóc khách hàng (“CSKH”) qua một trong các kênh liên hệ sau:
        </p>
        <ul type="circle">
            <li>Hotline: <strong>1900 636677</strong></li>
            <li>Email: cskh@HPship.vn</li>
            <li>Website hoặc App quản lý đơn hàng</li>
        </ul>
        <p>
        b. Thời gian làm việc:
        </p>
        <ul type="circle">
            <li>Thứ hai – Chủ nhật: 08h30 – 21h00</li>
            <li>Ngày lễ: 09h00 – 17h00</li>
        </ul>
        <h3>
            <strong>
            3. Các thông tin Khách hàng cung cấp cho CSKH:
            </strong>
        </h3>
        <ul type="circle">
            <li>Mã đơn hàng</li>
            <li>Phiếu gửi hàng hóa</li>
            <li>Tình trạng hàng hóa đính kèm hình ảnh (nếu có)</li>
            <li>Biên bản làm việc hoặc đồng kiểm hàng hóa (nếu có)</li>
            <li>Các thông tin khác về đơn hàng (nếu có).</li>
        </ul>
        <h3>
            <strong>
            4. Điều kiện để được giải quyết khiếu nại:
            </strong>
        </h3>
        <p>
        Người khiếu nại phải là Khách hàng trực tiếp sử dụng Dịch vụ của HPship hoặc Bên thứ ba được Khách hàng chỉ định (có Giấy ủy quyền được xác nhận bởi cơ quan có thẩm quyền). Khách hàng phải thực hiện khiếu nại theo đúng quy định tại Mục I này.
        </p>
        <hr>
        <h2>
            <strong>
            II. QUY TRÌNH GIẢI QUYẾT KHIẾU NẠI
            </strong>
        </h2>
        <h3>
            <strong>
            1. Thời hạn giải quyết khiếu nại:
            </strong>
        </h3>
        <p>
            a. Tất cả các vấn đề liên quan đến giao hàng, xử lý sự cố phát sinh, Khách hàng thông báo đến tổng đài chăm sóc khách hàng của Công ty qua các kênh liên hệ sau: (i) số hotline 1900 636677; (ii) Website hoặc App quản lý đơn hàng; (iii) gửi thông tin đến địa chỉ email: cskh@HPship.vn 
        </p>
        <p>
            b. Tất cả các khiếu nại sẽ được CSKH của Công ty tiếp nhận và xử lý trong vòng 02 (hai) ngày làm việc kể từ ngày nhận được khiếu nại. Đối với trường hợp phức tạp, thời gian tối đa giải quyết khiếu nại là không quá 02 (hai) tháng kể từ ngày nhận được khiếu nại theo quy định pháp luật.
        </p>
        <h3>
            <strong>
            2. Các bước xử lý khiếu nại: 
            </strong>
        </h3>
        <p>
            Quy trình giải quyết sự cố, khiếu nại được thực hiện căn cứ vào nguồn gốc lỗi phát sinh:
        </p>
        <p>
            <strong>
            a. Trường hợp sự cố xảy ra có nguồn gốc từ Khách hàng:  
            </strong>
        </p>
        <p>
            Hàng bị hư, móp, méo, đổ, rách, không đúng quy cách, phẩm chất, chất lượng, số lượng, hạn sử dụng như cam kết với Người nhận mà bao bì, tem niêm phong vẫn còn nguyên vẹn hoặc Sự cố được phát hiện trong quá trình nhân viên HPship chứng kiến việc Người nhận kiểm tra Bưu gửi.
        </p>
        <ul type="circle">
        <li>Bước 1: Lập Biên bản ghi nhận sự cố</li>
        <p>
        Khi phát sinh sự cố, nhân viên HPship chụp hình, giữ nguyên trạng thái và tiến hành lập biên bản với Người nhận. Nội dung biên bản xảy ra sự cố thể hiện rõ: (i) Thông tin về Bưu gửi, Người gửi, Người nhận; (ii) Địa điểm, ngày, tháng, năm chấp nhận/phát Bưu gửi; (iii) Mô tả chi tiết thực trạng Bưu gửi (“Biên bản”).Nhân viên HPship sẽ bao bọc, niêm phong Bưu gửi và ký xác nhận với tư cách là người chứng kiến. Điều phối các địa điểm kinh doanh cập nhật tình trạng đơn hàng trên Hệ thống.
        </p>
        <li>Bước 2: Chuyển thông tin sự cố cho CSKH</li>
        <p>
            Ngay khi lập xong Biên bản, nhân viên HPship liên hệ ngay CSKH của HPship qua tổng đài 1900 636677, thông báo mã đơn hàng, tình trạng đơn hàng, và thực trạng hàng hóa. Nhân viên HPship giữ và gửi Bưu gửi có niêm phong cùng Biên bản về các điểm giao dịch của HPship.
        </p>
        <li>Bước 3: Bộ phận CSKH thông báo trực tiếp tới Khách hàng</li>
        <p>
            Căn cứ thông tin nhân viên HPship phản ánh, CSKH gọi điện thoại hoặc gửi email trực tiếp cho Khách hàng thông báo về sự cố và thời hạn dự kiến Bưu gửi hoàn trả lại cho Khách hàng.
        </p>
        <li>Bước 4: HPship hoàn trả Bưu gửi cho Khách hàng</li>
        <p>
            Bưu gửi có sự cố còn niêm phong từ các điểm kinh doanh của HPship được hoàn trả lại cho Khách hàng trong Thời gian Toàn trình như cam kết. 
        </p>
        <p>
            <strong>
            b. Trường hợp sự cố xảy ra có nguồn gốc từ HPship như:
            </strong>
        </p>
        <p>
        Bưu gửi bị mất, cướp, thất lạc, hư, móp, đổ, rách, tráo đổi so với Bưu gửi được chấp nhận mà bao bì, tem niêm phong không còn nguyên vẹn hoặc lỗi do nhân viên HPship gây ra trong quá trình luân chuyển, trong thời gian chuyển giao Bưu gửi cho Người nhận.
        </p>
        <ul>
            <li>
                Bước 1: Lập Biên bản ghi nhận sự cố
            </li>
            <p>
                Ngay khi sự cố xảy ra, nhân viên HPship đang xử lý Bưu gửi tiến hành chụp hình, lập Biên bản ghi nhận đầy đủ thông tin liên quan đến Bưu gửi. Biên bản phải có đủ chữ ký của nhân viên đó và người quản lý trực tiếp hoặc người chứng kiến thứ 3. Bưu gửi được gói trong bao bì và niêm phong nguyên trạng. Chứng từ, Biên bản được gửi cho CSKH và Khách hàng một (01) bản.
            </p>
            <li>
                Bước 2: Chuyển thông tin cho CSKH
            </li>
            <p>
                CSKH cập nhật thông tin do nhân viên HPship gửi qua hoặc tiếp nhận trực tiếp từ khiếu nại của Khách hàng thông qua tổng đài.
            </p>
            <li>
                Bước 3: Bộ phận CSKH thông báo trực tiếp tới Khách hàng
            </li>
            <p>
                Căn cứ thông tin nhận được, CSKH gọi điện thoại hoặc gửi email trực tiếp cho Khách hàng thông báo sự cố, đồng thời yêu cầu Khách hàng cung cấp Thông tin chứng minh giá trị bưu gửi được quy định tại Chính sách bồi thường.
            </p>
            <li>
                Bước 4: HPship thẩm định và phản hồi cho khách hàng kết quả đền bù
            </li>
            <p>
                Sau khi nhận được đầy đủ thông tin từ khách hàng, HPship sẽ phản hồi kết quả xử lý theo thời hạn quy định tại Mục 1.2.Trường hợp khách hàng đã cung cấp đầy đủ thông tin chứng minh giá trị sản phẩm và đủ điều kiện nhận đền bù, CSKH sẽ thông báo xác nhận giá trị đền bù và thời gian HPship tiến hành chuyển khoản đền bù cho Khách hàng theo thỏa thuận hoặc email xử lý khiếu nại với Khách hàng.
            </p>
            <li>
                Bước 5: HPship thực hiện đền bù, bồi thường thiệt hại theo cam kết
            </li>
            <p>
                HPship tiến hành thực hiện đền bù bằng chuyển khoản vào tài khoản khách hàng trong vòng thời hạn không quá 15 (mười lăm) ngày làm việc, tính từ lúc HPship gửi thông báo kết quả đền bù tại Bước 4.
            </p>
        </ul>



        
        </div>
</body>
</html>