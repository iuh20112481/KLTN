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
            <h1>ĐIỀU KHOẢN SỬ DỤNG</h1>
        </div>
        <div class="content-page add-height-img">
        <p style="text-align:center">Bằng việc chấp nhận sử dụng Dịch vụ của Công ty Cổ phần Dịch vụ Giao Hàng Nhanh, Khách hàng hiểu và đồng ý với chính sách về Quyền và nghĩa vụ được nêu dưới đây.</p>
        <h2><strong>I. THUẬT NGỮ</strong></h2>
        <p><strong>
            “HPship” có nghĩa là Công ty Cổ phần Dịch vụ giao hàng toàn quốc Quick Shipping.
        </strong>
        </p>
        <p>
            <strong>“Khách hàng”</strong> 
            có nghĩa là cá nhân hoặc tổ chức sử dụng Dịch vụ của HPship.
        </p>
        <p>
            <strong>“Bưu gửi”</strong> 
            có nghĩa là thư, gói, kiện hàng hóa được GNH chấp nhận, vận chuyển 
            và phát hợp pháp trong hệ thống bưu cục của HPship.
        </p>
        <p>
            <strong>“Đơn hàng”</strong>
            có nghĩa là yêu cầu thực hiện Dịch vụ được Khách hàng thiết lập 
            qua Hệ thống hoặc được viết tay dưới dạng Phiếu gửi/Phiếu yêu cầu Dịch vụ 
            có đầy đủ thông tin về Bưu gửi.
        </p>
        <p>
            <strong>“Dịch vụ”</strong>
            có nghĩa là dịch vụ liên quan việc giao nhận Bưu gửi, bao gồm: 
            chấp nhận, vận chuyển và phát Bưu gửi bằng các phương thức khác nhau từ 
            địa điểm do Khách hàng chỉ định đến địa điểm của người nhận.
        </p>
        <p>
        <strong>“Hệ thống”</strong>
            có nghĩa là phần mềm ứng dụng được cài đặt trên thiết bị di động 
            hoặc website mà HPship thiết lập cho việc sử dụng Dịch vụ của Khách hàng, 
            bao gồm tạo, quản lý, theo dõi tiến độ của Đơn hàng; thanh toán cước 
            Dịch vụ; kiểm soát, đối chiếu dữ liệu về Bưu gửi và cước Dịch vụ.
        </p>
        <hr>
        <h2>
        <strong>
            II. QUYỀN VÀ NGHĨA VỤ CỦA KHÁCH HÀNG
        </strong>
        </h2>
        <h3>
            <strong>
                1. Quyền của Khách hàng
            </strong>
        </h3>
        <ul type="circle">
            <li>
                Được HPship cung cấp đầy đủ thông tin liên quan đến toàn bộ quy trình 
                cung ứng Dịch vụ.
            </li>
            <li>Được HPship đảm bảo bí mật thông tin, an toàn đối với Bưu gửi trong 
                toàn quá trình giao hàng theo qui định của pháp luật.
            </li>
            <li>Được HPship giải quyết khiếu nại, được giải quyết thỏa đáng về Dịch vụ 
                cung ứng đã sử dụng.
            </li>
            <li>Được HPship bồi thường thiệt hại tùy theo thực tế từng trường hợp.
            </li>
        </ul>
        <h3>
            <strong>
                2. Nghĩa vụ của khách hàng
            </strong>
        </h3>
        <ul type="circle">
            <li>Thực hiện việc đối soát cước phí Dịch vụ đảm bảo đúng thời hạn.
            </li>
            <li>Không gửi Bưu gửi chưa được lưu thông trên thị trường, hàng cấm, hàng hạn chế vận chuyển/kinh doanh hoặc hàng kinh doanh có điều kiện nhưng không cung cấp được giấy phép.
            </li>
            <li>Khách hàng có nghĩa vụ mở hàng và phối hợp với HPship trong việc đồng kiểm cũng như niêm phong hàng hóa khi gửi hàng.
            <br>
            Chịu trách nhiệm trước HPship và trước pháp luật về nội dung Bưu gửi, hóa đơn, chứng từ nguồn gốc xuất xứ của Bưu gửi và chứng từ đính kèm.
            </li>
            <li>Chịu trách nhiệm làm việc, giải quyết với Cơ quan có thẩm quyền khi Bưu gửi tạm giữ hoặc tịch thu.
            </li>
            <li>Cung cấp đầy đủ hóa đơn, chứng từ của Bưu gửi cho HPship khi gửi Bưu gửi.
            </li>
            <li>HPship sẽ được miễn trừ trách nhiệm bồi thường trong trường hợp Bưu gửi bị tạm giữ hoặc tịch thu bởi cơ quan có thẩm quyền do Bưu gửi không có hóa đơn, chứng từ hợp pháp đính kèm.
            </li>
            <li>Đóng gói Bưu gửi theo đúng từng quy cách, kích thước và tính chất của từng mặt hàng, đặc biệt đối với Bửu gửi là các mặt hàng dễ vỡ.
            </li>
            <li>Cung cấp đầy đủ chỉ dẫn liên quan đến Bưu gửi; thông tin liên quan đến Người gửi, Người nhận trên Bưu gửi.
            </li>
            <li>Bồi thường thiệt hại thực tế cho HPship và bên thứ 3 có liên quan khi thiệt hại xảy ra có nguồn gốc từ Khách hàng/Người gửi theo quy định của pháp luật.
            </li>
            <li>Chịu trách nhiệm về mọi thông tin liên quan đến Người nhận mà Khách hàng giao cho HPship. Trường hợp xảy ra sai sót về thông tin Người nhận hoặc Bưu gửi không đúng yêu cầu của Người nhận thì Khách hàng có trách nhiệm tự giải quyết với Người nhận, đồng thời Khách hàng vẫn phải thanh toán Cước phí Dịch vụ đối với Đơn hàng trên dựa trên lộ trình đã thực hiện.
            </li>
            <li>Bằng chi phí của mình, chịu trách nhiệm giải quyết các vấn đề liên quan đến
            (i) tranh chấp về quyền sở hữu Bưu gửi, nguồn gốc Bưu gửi với bên thứ ba bất kỳ; hoặc (ii) khiếu nại của Người nhận về việc hàng hóa bị lỗi, không đúng yêu cầu.</li>
        </ul>
        </div>
</body>
</html>