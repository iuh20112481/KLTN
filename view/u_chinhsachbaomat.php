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

        h1 {
            font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif;
        }

        p,
        ul {
            font-family: 'Samsung One 400', Arial, sans-serif;
        }

        h2 {
            font-family: 'Samsung Sharp Sans Bold', Arial, sans-serif;
        }

        h3 {
            font-family: 'Samsung One 700', Arial, sans-serif;
        }

        ul {
            list-style-type: circle;
            /* Định dạng kiểu dấu chấm */
            padding-left: 20px;
            /* Thêm khoảng cách bên trái */
        }

        ul li {
            line-height: 1.6;
            /* Giãn dòng giữa các mục trong danh sách */
            margin-bottom: 10px;
            /* Khoảng cách giữa các mục */
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
            background: #00467f;
            /* Màu đường kẻ */
        }

        .content-page {
            padding: 20px 40px;
            /* Thêm padding */
            margin-bottom: 50px;
            background-color: #fff;
            /* Nền trắng */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            /* Bóng đổ nhẹ */
            border-radius: 10px;
            /* Bo góc */
            width: 60%;
        }

        .content-page p {
            line-height: 1.6;
            /* Dễ đọc hơn */
        }

        .content-page h2 {
            font-size: 1.5em;
            font-weight: bold;
            color: #00467f;
            /* Màu tiêu đề */
        }

        .content-page h3 {
            font-size: 1.3em;
            color: #0066cc;
            /* Màu khác cho phân cấp thấp hơn */
        }

        .content-page ul {
            list-style-type: circle;
            padding-left: 20px;
            /* Khoảng cách bên trái */
            margin-bottom: 20px;
        }

        .content-page ul li {
            margin-bottom: 10px;
            /* Khoảng cách giữa các mục */
            padding-left: 10px;
            /* Để các mục không quá sát */
        }

        .content-page hr {
            border: none;
            border-top: 1px solid #ddd;
            /* Đường kẻ phân cách */
            margin: 20px 0;
            /* Khoảng cách trên và dưới */
        }
    </style>
</head>

<body>

    <div class="heading-page">
        <h1>CHÍNH SÁCH BẢO MẬT</h1>
    </div>
    <div class="content-page add-height-img">
        <p style="text-align:center">Chính Sách Bảo Mật này có hiệu lực kể từ ngày 20 tháng 03 năm 2024.
            Để tham khảo phiên bản trước của Chính sách Bảo mật, vui lòng bấm vào ĐÂY.
        </p>
        <h2><strong>CHÍNH SÁCH BẢO MẬT VÀ BẢO VỆ DỮ LIỆU CÁ NHÂN</strong></h2>
        <h3>
            <strong>
                1. GIỚI THIỆU
            </strong>
        </h3>
        <p>1.1 CHÍNH SÁCH BẢO MẬT VÀ BẢO VỆ DỮ LIỆU CÁ NHÂN này (“Chính Sách”) được cập nhật nhằm tuân thủ Nghị Định 13/2023/NĐ-CP và các quy định pháp luật khác có liên quan. Chính Sách mô tả cách thức Công Ty Cổ Phần Dịch Vụ Giao Hàng TOÀN QUỐC (“HPship” hay “chúng tôi”) sử dụng Dữ Liệu Cá Nhân (được định nghĩa sau đây) của người sử dụng Các Dịch Vụ hoặc của người truy cập vào Các Nền Tảng của chúng tôi, bao gồm nhưng không giới hạn:
        <ul>
            <li>(a) Người gửi hàng: Bao gồm cả nhân viên của người gửi hoặc cá nhân gửi một lô hàng;
            </li>
            <li>(b) Người nhận lô hàng: Bất kỳ cá nhân nào nhận lô hàng;
            </li>
            <li>(c) Những người thể hiện sự quan tâm đến chúng tôi và Các Dịch Vụ của chúng tôi;
            </li>
            <li>(d) Đối tác kinh doanh: Đối tác kinh doanh, bao gồm cả nhân viên của họ;
            </li>
            <li>(e) Ứng viên tuyển dụng: Những cá nhân nộp đơn xin việc tới chúng tôi.
            </li>
            <li>(tất cả các đối tượng trên được gọi là “bạn”)
            </li>
        </ul>
        </p>
        <p>
            1.2 Thông qua quá trình bạn sử dụng Các Nền Tảng và/hoặc Các Dịch Vụ, chúng tôi sẽ thu thập, sử dụng, tiết lộ, lưu trữ và/hoặc xử lý dữ liệu, bao gồm cả Dữ Liệu Cá Nhân của bạn.
        </p>
        <p>Trong Chính Sách này, “(Các) Nền Tảng”) có nghĩa là tất cả các ứng dụng và website của HPship hay bên thứ ba có tích hợp các ứng dụng và website của HPship (bao gồm phiên bản website và phiên bản điện thoại), và “(Các) Dịch Vụ”) có nghĩa là tất cả các sản phẩm, thông tin, chức năng và dịch vụ do HPship cung cấp tại từng thời điểm trên Các Nền Tảng.
        </p>
        <hr>
        <h3>
            <strong>
                2. LOẠI DỮ LIỆU CÁ NHÂN ĐƯỢC XỬ LÝ
            </strong>
        </h3>
        <p>“Dữ Liệu Cá Nhân” có nghĩa là thông tin dưới dạng ký hiệu, chữ viết, chữ số, hình ảnh, âm thanh hoặc dạng tương tự trên môi trường điện tử gắn liền với một con người cụ thể hoặc giúp xác định một con người cụ thể. Dữ Liệu Cá Nhân bao gồm Dữ Liệu Cá Nhân Cơ Bản và Dữ Liệu Cá Nhân Nhạy Cảm.
        </p>
        <p>2.1 Dữ Liệu Cá Nhân Cơ Bản, bao gồm:
        <ul>
            <li>(a) Họ, chữ đệm và tên khai sinh, tên gọi khác (nếu có);
            </li>
            <li>(b) Ngày, tháng, năm sinh; ngày, tháng, năm chết hoặc mất tích;
            </li>
            <li>(c) Giới tính;
            </li>
            <li>(d) Nơi sinh, nơi đăng ký khai sinh, nơi thường trú, nơi tạm trú, nơi ở hiện tại, quê quán, địa chỉ liên hệ;
            </li>
            <li>(e) Quốc tịch;
            </li>
            <li>(f) Hình ảnh của bạn;
            </li>
            <li>(g) Số điện thoại, số chứng minh nhân dân, số định danh cá nhân, số hộ chiếu, số giấy phép lái xe, số biển số xe, số mã số thuế cá nhân, số bảo hiểm xã hội, số thẻ bảo hiểm y tế;
            </li>
            <li>(h) Tình trạng hôn nhân;
            </li>
            <li>(i) Thông tin về mối quan hệ gia đình (cha mẹ, con cái);
            </li>
            <li>(j) Thông tin về tài khoản số của bạn; dữ liệu cá nhân phản ánh hoạt động, lịch sử hoạt động trên không gian mạng;
            </li>
            <li>(k) Các thông tin khác gắn liền với một con người cụ thể hoặc giúp xác định một con người cụ thể không thuộc điểm trên.
            </li>
        </ul>
        </p>
        <p>2.2 Dữ Liệu Cá Nhân Nhạy Cảm là dữ liệu cá nhân gắn liền với quyền riêng tư của bạn mà khi bị xâm phạm sẽ gây ảnh hưởng trực tiếp tới quyền và lợi ích hợp pháp của bạn, bao gồm:
        <ul>
            <li>(a) Tình trạng sức khỏe, không bao gồm thông tin về nhóm máu;
            </li>
            <li>(b) Dữ liệu về tội phạm, hành vi phạm tội được thu thập, lưu trữ bởi các cơ quan thực thi pháp luật;
            </li>
            <li>(c) Dữ liệu về vị trí của bạn được xác định qua dịch vụ định vị;
            </li>
            <li>(d) Dữ liệu cá nhân khác được Nghị Định 13/2023/NĐ-CP phân loại là dữ liệu nhạy cảm.
            </li>
        </ul>
        </p>
        <hr>
        <h3>
            <strong>
                3. MỤC ĐÍCH XỬ LÝ DỮ LIỆU
            </strong>
        </h3>
        <p>HPship có thể sử dụng và Xử Lý Dữ Liệu Cá Nhân (được định nghĩa dưới đây) của bạn vì mục đích kinh doanh, vận chuyển, giao nhận hàng hóa (logistics), hoạt động thanh toán và các hoạt động khác của HPship mà có thể bao gồm nhưng không giới hạn bởi Các Mục Đích sau đây (“Các Mục Đích”):
        </p>
        <p>
            3.1 Các Mục Đích chung:

        <ul>
            <li>(a) Nhằm trả lời các câu hỏi, bình luận và phản hồi của bn;
            </li>
            <li>(b) Nhằm liên lạc với bạn về bất kỳ mục đích nào được liệt kê tại Chính Sách này;
            </li>
            <li>(c) Nhằm phục vụ mục đích quản lý nội bộ như kiểm toán, phân tích dữ liệu, lưu trữ cơ sở dữ liệu;
            </li>
            <li>(d) Nhằm phục vụ mục đích phát hiện, ngăn chặn và truy tố tội phạm;
            </li>
            <li>(e) Nhằm giải quyết tranh chấp, khiếu nại; xử lý các giao dịch/hành vi gian lận, giả mạo (nếu có) hoặc để ngăn chặn, khắc phục các hành vi vi phạm pháp luật;
            </li>
            <li>(f) Để bảo vệ và bảo mật Dữ Liệu Cá Nhân của bạn và đảm bảo an ninh cho hệ thống mạng/ hệ thống thông tin của chúng tôi;
            </li>
            <li>(g) Để duy trì sự an toàn và đảm bảo an ninh cho các Dịch Vụ của chúng tôi và nhằm giúp HPship tuân thủ các nghĩa vụ theo quy định của pháp luật;
            </li>
            <li>(h) HPship cũng sử dụng và xử lý thông tin của bạn vì các mục đích quảng cáo, tiếp thị theo hình thức gửi thư bằng đường bưu điện, điện thoại, tin nhắn (SMS), dịch vụ nhắn tin trực tuyến, bằng thư tay và/hoặc email như sau:
            </li>
            <li>(i) Nhằm sử dụng Cookies để cải thiện các quy trình, hoạt động quảng cáo, thông báo, xác minh, an toàn và tuân thủ, phân tích và quản lý nhu cầu bạn.
            </li>
        </ul>
        </p>
        <p>3.2 Ngoài các mục đích chung nêu tại Điều 3.1, nếu bạn là một khách hàng sử dụng Các Dịch Vụ, việc Xử Lý Dữ Liệu Cá Nhân với mục đích sau:
        <ul>
            <li>(a) Nhằm thực hiện các nghĩa vụ của HPship theo bất kỳ thỏa thuận nào được ký kết với bạn;
            </li>
            <li>(b) Nhằm cung cấp bất kỳ Dịch Vụ nào theo yêu cầu của bạn;
            </li>
            <li>(c) Nhằm xử lý việc cài đặt và đăng ký của bạn và cung cấp Các Dịch Vụ cho bạn;
            </li>
            <li>(d) Khi bạn yêu cầu tải xuống và sử dụng Các Nền Tảng hoặc bất kỳ ứng dụng nào của HPship, nhằm xử lý yêu cầu của bạn, cung cấp Các Nền Tảng và ứng dụng cho bạn và cho phép bạn sử dụng Các Nền Tảng và ứng dụng;
            </li>
            <li>(e) Nhằm xử lý và quản lý điểm tích lũy của bạn trong chương trình khách hàng thân thiết;
            </li>
            <li>(f) Nhằm xử lý việc tham gia của bạn vào bất kỳ sự kiện, hoạt động, nhóm trọng điểm, nghiên cứu, cuộc thi, chương trình khuyến mại, cuộc bình chọn, khảo sát hoặc sản phẩm nào;
            </li>
            <li>(g) Nhằm xử lý, quản lý hoặc xác minh việc đăng ký sử dụng của bạn đối với các Dịch Vụ của HPship và nhằm cung cấp cho bạn các lợi ích dành cho người đăng ký;
            </li>
            <li>(h) Nhằm xác nhận các đặt chỗ của bạn và xử lý các thanh toán liên quan đến bất kỳ Dịch Vụ nào mà bạn yêu cầu;
            </li>
            <li>(i) Nhằm tìm hiểu và phân tích doanh số của chúng tôi cũng như các nhu cầu và sở thích của bạn;
            </li>
            <li>(j) Nhằm phát triển, cải thiện và cung cấp các Dịch Vụ đáp ứng nhu cầu của bạn; và
            </li>
            <li>(k) Nhằm xử lý việc đổi, trả hàng hóa và bồi thường.
            </li>
        </ul>

        </p>
        <p>3.3 Ngoài các mục đích chung nêu tại Điều 3.1, nếu bạn là một đối tác kinh doanh của chúng tôi, việc Xử Lý Dữ Liệu Cá Nhân với mục đích (i) để quản lý mối quan hệ của HPship với bạn; (ii) để bạn cung cấp dịch vụ cho HPship trên cơ sở hợp đồng được ký kết giữa chúng tôi và bạn.

        </p>
        <p>3.4 Ngoài các mục đích chung nêu tại Điều 3.1, nếu bạn là một ứng viên tuyển dụng, việc Xử Lý Dữ Liệu Cá Nhân với mục đích (i) để kiểm tra tính đủ điều kiện của bạn; (ii) để tuyển dụng bạn; (iii) lưu trữ thông tin của bạn trong khu dự trữ tuyển dụng của chúng tôi.

        </p>
        <p>3.5 Bất kỳ mục đích nào khác mà đã có được chấp thuận của bạn, tuân thủ với các nghĩa vụ của chúng tôi theo pháp luật hiện hành, bao gồm việc thông báo cho bạn tại thời điểm xin chấp thuận.

        </p>
        <hr>
        <h3>
            <strong>
                4. CÁCH THỨC XỬ LÝ DỮ LIỆU
            </strong>
        </h3>
        <p>“Xử Lý Dữ Liệu Cá Nhân” là một hoặc nhiều hoạt động tác động tới Dữ Liệu Cá Nhân, như: thu thập, ghi, phân tích, xác nhận, lưu trữ, chỉnh sửa, công khai, kết hợp, truy cập, truy xuất, thu hồi, mã hóa, giải mã, sao chép, chia sẻ, truyền đưa, cung cấp, chuyển giao, xóa, hủy dữ liệu cá nhân hoặc các hành động khác có liên quan.

        </p>
        <p>4.1 Cách thức thu thập
        <ul>
            <li>(a) Các Dữ Liệu Cá Nhân có thể được thu thập khi bạn trực tiếp cung cấp cho HPship hoặc thu thập gián tiếp từ bạn thông qua các nguồn thông tin công khai, chính thống; hoặc thông qua việc nhận chia sẻ dữ liệu cần thiết từ các công ty con, đối tác mà họ thu thập được trong quá trình hợp tác với HPship để cung cấp Các Dịch Vụ cho bạn và được bạn cho phép chia sẻ, bao gồm nhưng không giới hạn:
                <ul>
                    <li>(i) Từ việc sử dụng Các Nền Tảng;
                    </li>
                    <li>(ii) Từ các mẫu đơn đăng ký hoặc đề nghị sử dụng hoặc các tài liệu tương tự khác;(iii) Các nguồn thông tin đại chúng khác như danh bạ;
                    </li>
                    <li>(iv) Từ các trang mạng xã hội của HPship mà bạn theo dõi, yêu thích hoặc là fan của các trang đó;
                    </li>
                    <li>(v) Từ các tổ chức cung cấp thông tin tín dụng, bên cung cấp bảo hiểm, hoặc tổ chức cung cấp dịch vụ tín dụng;
                    </li>
                    <li>(vi) Thông qua việc bạn liên lạc, trao đổi với HPship tại bất kỳ sự kiện hay hoạt động nào;
                    </li>
                    <li>(vii) Thông qua việc bạn tham gia các cuộc thi do HPship tổ chức;
                    </li>
                    <li>(viii) Từ các tổ chức hoặc đơn vị khác nhau thuộc HPship;
                    </li>
                    <li>(ix) Từ các tổ chức cung cấp dịch vụ cho bạn hoặc có mối quan hệ hợp đồng với bạn;
                    </li>
                    <li>(x) Từ các nhà cung cấp dịch vụ tiếp thị (marketing) hoặc đối tác tiếp thị (marketing);
                    </li>
                    <li>(xi) Từ các cookies được sử dụng trên Các Nền Tảng, website; và
                    </li>
                    <li>(xii) Trong trường hợp bạn là một nhà cung cấp dịch vụ, Dữ Liệu Cá Nhân của bạn còn có thể được thu thập từ dữ liệu hộp đen, dữ liệu GPS và khi ứng dụng HPship của bạn đang hoạt động.
                    </li>
                </ul>
            </li>
            <li>(b) Việc cung cấp Dữ liệu Cá Nhân của bạn là hoàn toàn tự nguyện. Tuy nhiên, nếu bạn không cung cấp Dữ Liệu Cá Nhân cho HPship, chúng tôi sẽ không thể xử lý Dữ liệu Cá Nhân của bạn vì Các Mục Đích (được quy định dưới đây) và có thể dẫn đến việc HPship không thể cung cấp Dịch Vụ cho bạn hoặc không thể chấp nhận thanh toán do bạn thực hiện.
            </li>
            <li>(c) Trường hợp bạn cung cấp cho HPship các Dữ Liệu Cá Nhân không thuộc về bạn (ví dụ: Dữ Liệu Cá Nhân của người nhận hàng; Dữ Liệu Cá Nhân của nhân viên...), bạn cam đoan và đảm bảo rằng Bạn đã có được sự đồng ý, được cấp phép và được cho phép cần thiết từ các cá nhân chủ của Dữ Liệu Cá Nhân đó để chia sẻ và chuyển Dữ Liệu Cá Nhân của họ cho HPship, và cho việc HPship xử lý dữ liệu theo quy định tại Chính Sách này. Bạn theo đây đồng ý không hủy ngang và vô điều kiện bồi hoàn và bảo đảm, khi có yêu cầu, cho HPship và nhân viên, người lao động, cố vấn và đại diện tương ứng của HPship không bị thiệt hại bởi bất kỳ tổn thất nào liên quan đến việc HPship xử lý Dữ Liệu Cá Nhân không thuộc về bạn theo quy định tại Chính Sách này. Trong mọi trường hợp, HPship sẽ không can thiệp vào thoả thuận của bạn với chủ sở hữu Dữ Liệu Cá Nhân nói trên và HPship được loại trừ mọi trách nhiệm và nghĩa vụ (kể cả trách nhiệm và nghĩa vụ liên đới) liên quan đến các vướng mắc, khiếu nại, yêu cầu, kiện tụng, bồi thường và tranh chấp đối với cũng như tất cả các vấn đề phát sinh từ hoặc liên quan đến việc xử lý Dữ Liệu Cá Nhân không thuộc về bạn nhưng do bạn cung cấp cho HPship.
            </li>
            <li>(d) Thu thập qua hệ thống camera
                <ul>
                    <li>(i) Tại các Địa Điểm Hoạt Động (“Địa Điểm Hoạt Động”) bao gồm nhưng không giới hạn Trụ sở HPship, Địa Điểm Kinh Doanh, Chi Nhánh, Văn Phòng Đại Diện, Bưu Cục, Kho Trung Chuyển, Kho Chuyển Tiếp thuộc quyền quản lý và vận hành của HPship, chúng tôi có thể sẽ sử dụng hệ thống camera đặt tại khu vực Địa Điểm Hoạt Động nhằm ghi âm, ghi hình theo thời gian thực với mục đích đảm bảo an toàn cơ sở vật chất và an ninh trật tự khu vực tại Địa Điểm Hoạt Động; bảo vệ quyền và lợi ích hợp pháp của của nhân viên, của chúng tôi và của bạn theo quy định pháp luật; phòng, chống, xác định và điều tra những hành vi vi phạm tại Địa Điểm Hoạt Động; và
                    </li>
                    <li>(ii) Bằng cách tiếp tục hoạt động tại Địa Điểm Hoạt Động của chúng tôi, bạn chấp nhận để chúng tôi thực hiện giám sát qua hệ thống camera và xử lý dữ liệu theo đúng mục đích đã được đề cập ở trên.
                    </li>
                </ul>
            </li>
        </ul>
        </p>
        <p>4.2 Cách thức lưu trữ

        </p>
        <p>Dữ Liệu Cá Nhân của bạn do chúng tôi lưu trữ sẽ được bảo mật bằng việc thực hiện các biện pháp hợp lý. Trong phạm vi pháp luật cho phép, chúng tôi có thể lưu trữ Dữ Liệu Cá Nhân của bạn trong khoảng thời gian cần thiết để hoàn thành đúng và đủ các mục đích Xử Lý Dữ Liệu Cá Nhân được nêu cụ thể trong Chính Sách Thông Tin. Chúng tôi có thể phải lưu trữ Dữ Liệu Cá Nhân của bạn lâu hơn dựa trên yêu cầu của pháp luật có hiệu lực tại từng thời điểm.

        </p>
        <p>4.3 Cách thức chuyển giao/chia sẻ dữ liệu
        <ul>
            <li>(a) Trong trường hợp, Dữ Liệu Cá Nhân của bạn:
                <ul>
                    <li>(i) Được chuyển giao tới, lưu trữ, sử dụng và Xử Lý Dữ Liệu Cá Nhân bởi các công ty thuộc HPship tại một quốc gia mà đó không phải quốc gia của bạn hay quốc gia mà bạn đang hiện diện khi sử dụng bất kỳ Dịch Vụ nào do HPship cung cấp (“Nước Ngoài”) và/hoặc khi các máy chủ của HPship và/hoặc bên cung cấp dịch vụ và đối tác của HPship được đặt tại Nước Ngoài;
                    </li>
                    <li>(ii) Được chuyển giao/chia sẻ đến cá nhân/tổ chức tham gia quá trình Xử Lý Dữ Liệu Cá Nhân quy định tại Điều 7 của Chính Sách này;
                    </li>
                    <li>Chúng tôi sẽ sử dụng các biện pháp bảo mật cần thiết, đảm bảo an toàn thông tin, không bị lộ, lọt dữ liệu và yêu cầu các bên tiếp nhận Dữ Liệu Cá Nhân sẽ có biện pháp bảo mật dữ liệu.
                    </li>
                </ul>
            </li>
            <li>(b) Bằng việc chấp nhận Chính Sách này, bạn hiểu và đồng ý với việc chuyển giao Dữ Liệu Cá Nhân của bạn tại các điều trên.
            </li>
        </ul>
        </p>
        <p>4.4 Cách thức phân tích

        </p>
        <p>Việc phân tích Dữ Liệu Cá Nhân được thực hiện theo các quy trình nội bộ của HPship. Chúng tôi luôn có cơ chế giám sát nghiêm ngặt từng quy trình phân tích dữ liệu, trong đó yêu cầu kiểm tra việc đáp ứng các yêu cầu của pháp luật về bảo mật dữ liệu, bảo đảm an toàn thông tin đối với hệ thống công nghệ thông tin trước khi tiến hành phân tích. Chúng tôi cũng có các quy tắc nghiêm ngặt đảm bảo rằng thông tin cá nhân được ẩn danh hoặc hủy nhận dạng ở giai đoạn thích hợp trong quá trình xử lý.

        </p>
        <p>4.5 Cách thức mã hóa

        </p>
        <p>Dữ Liệu Cá Nhân thu thập được mã hóa theo các tiêu chuẩn mã hóa phù hợp khi cần thiết trong quá trình lưu trữ hoặc chuyển giao dữ liệu, để đảm bảo các dữ liệu được bảo vệ, xác thực, toàn vẹn và không thể bị thay đổi sau khi đã được gửi đi.

        </p>
        <p>4.6 Cách thức xóa dữ liệu

        </p>
        <p>Khi bạn chấm dứt sử dụng Các Dịch Vụ của HPship và có yêu cầu hợp lệ, chúng tôi sẽ tiến hành xóa Dữ Liệu Cá Nhân với toàn bộ Dữ Liệu Cá Nhân mà bạn đã cung cấp và/hoặc chúng tôi thu thập được trong quá trình bạn sử dụng Các Dịch Vụ trừ trường hợp pháp luật có quy định khác và một số trường hợp không thể thực hiện được như sau:
        <ul>
            <li>(a) Pháp luật quy định không cho phép xóa dữ liệu hoặc yêu cầu bắt buộc phải lưu trữ dữ liệu;
            </li>
            <li>(b) Dữ Liệu Cá Nhân được xử lý bởi cơ quan nhà nước có thẩm quyền với mục đích phục vụ hoạt động của cơ quan nhà nước theo quy định pháp luật;
            </li>
            <li>(c) Dữ Liệu Cá Nhân đã được công khai theo quy định pháp luật;
            </li>
            <li>(d) Dữ Liệu Cá Nhân được xử lý nhằm phục vụ yêu cầu pháp lý, nghiên cứu khoa học, thống kê theo quy định pháp luật;
            </li>
            <li>(e) Trong trường hợp tình trạng khẩn cấp về quốc phòng, an ninh quốc gia, trật tự an toàn xã hội, thảm họa lớn, dịch bệnh nguy hiểm; khi có nguy cơ đe dọa an ninh, quốc phòng nhưng chưa đến mức ban bố tình trạng khẩn cấp; phòng, chống bạo loạn, khủng bố, phòng, chống tội phạm và vi phạm pháp luật;
            </li>
            <li>(f) Ứng phó với tình huống khẩn cấp đe dọa đến tính mạng, sức khỏe hoặc sự an toàn của bạn hoặc cá nhân khác.
            </li>
        </ul>
        </p>
        <p>4.7 Cookies

        </p>
        <ul>
            <li>(a) HPship và các bên thứ ba mà HPship hợp tác, có thể sẽ sử dụng cookies, web beacon, web tag, web script, các dữ liệu chia sẻ như HTML5 và Flash (còn có thể được gọi là “flash cookies”), công cụ định danh quảng cáo (bao gồm công cụ định danh di động như Apple’s IDFA hoặc Google Advertising ID) và các công nghệ tương tự (theo đây được gọi chung là “Cookies”) có liên quan đến việc sử dụng Các Nền Tảng của bạn. Cookies có thể chứa đựng các công cụ định danh độc nhất và trú tại, ngoài các nơi khác, máy tính hoặc thiết bị di động của bạn, trong email mà chúng tôi gửi cho bạn, và trên các trang web của chúng tôi. Cookies có thể truyền tải thông tin về bạn và việc sử dụng Dịch Vụ của bạn, chẳng hạn như loại trình duyệt web của bạn, tìm kiếm yêu thích, địa chỉ IP, dữ liệu có liên quan đến quảng cáo mà được trình chiếu cho bạn hoặc được bạn bấm vào, và ngày giờ sử dụng của bạn. Cookies có thể được lưu trữ trong từng phần cụ thể.
            </li>
            <li>(b) HPship có thể cho phép các bên thứ ba sử dụng Cookies trên Các Nền Tảng để thu thập các thông tin cùng loại vì cùng Các Mục Đích mà HPship tự thực hiện. Các bên thứ ba sẽ có thể liên kết các thông tin mà họ thu thập được với các thông tin khác mà họ đã có về bạn từ các nguồn thông tin khác. Chúng tôi không nhất thiết phải truy cập hoặc kiểm soát các Cookies mà họ sử dụng.
            </li>
            <li>(c) HPship có thể chia sẻ thông tin không cá nhân của bạn với các bên thứ ba, chẳng hạn như chỉ dẫn quảng cáo hoặc một dữ liệu giải mã từ một chỉ dẫn tài khoản (chẳng hạn như địa chỉ email), để phục vụ cho việc thể hiện các quảng cáo mục tiêu.
            </li>
            <li>(d) Trong trường hợp bạn không muốn các thông tin này của bạn được thu thập qua cookies trên trang web, bạn có thể tắt cookies bằng cách điều chỉnh cài đặt trình duyệt internet của bạn để vô hiệu hóa, khóa hoặc tắt cookies, bằng cách xóa lịch sử truy cập của bạn hoặc xóa bộ nhớ cache khỏi trình duyệt internet của bạn.
            </li>
        </ul>
        <hr>
        <h3>
            <strong>
                5. THỜI GIAN BẮT ĐẦU, THỜI GIAN KẾT THÚC XỬ LÝ DỮ LIỆU CÁ NHÂN
            </strong>
        </h3>
        <p>5.1 Dữ Liệu Cá Nhân được xử lý kể từ thời điểm chúng tôi nhận được Dữ Liệu Cá Nhân do bạn cung cấp và chúng tôi đã có cơ sở pháp lý phù hợp để xử lý dữ liệu theo quy định pháp luật.

        </p>
        <p>5.2 Trong phạm vi pháp luật cho phép, Dữ Liệu Cá Nhân sẽ được xử lý cho đến khi các mục đích xử lý dữ liệu đã được hoàn thành.

        </p>
        <p>5.3 Chúng tôi có thể phải lưu trữ Dữ Liệu Cá Nhân của bạn ngay cả khi hợp đồng giữa bạn và HPship đã chấm dứt để thực hiện các nghĩa vụ pháp lý của chúng tôi theo quy định pháp luật và/hoặc yêu cầu của cơ quan nhà nước có thẩm quyền.

        </p>
        <hr>
        <h3>
            <strong>
                6. HẬU QUẢ, THIỆT HẠI KHÔNG MONG MUỐN CÓ KHẢ NĂNG XẢY RA
            </strong>
        </h3>
        <p>6.1 Chúng tôi sử dụng nhiều công nghệ bảo mật thông tin khác nhau như: chuẩn quốc tế PCI, SSL, tường lửa, mã hóa… nhằm bảo vệ và ngăn chặn việc Dữ Liệu Cá Nhân của bạn bị truy cập, sử dụng hoặc chia sẻ ngoài ý muốn. Tuy nhiên, không một dữ liệu nào có thể được bảo mật hoàn toàn. Do vậy, chúng tôi không thể cam kết bảo mật một cách tuyệt đối Dữ Liệu Cá Nhân của bạn trong một số trường hợp như:
        <ul>
            <li>(a) Lỗi phần cứng, phần mềm trong quá trình xử lý dữ liệu làm mất dữ liệu của bạn;
            </li>
            <li>(b) Lỗ hổng bảo mật nằm ngoài khả năng kiểm soát của chúng tôi, hệ thống bị hacker tấn công gây lộ lọt dữ liệu.
            </li>

        </ul>
        </p>
        <p>6.2 Chúng tôi khuyến cáo bạn bảo mật các thông tin liên quan đến mật khẩu đăng nhập vào tài khoản của bạn, mã OTP và không chia sẻ nội dung này với bất kỳ người nào khác.

        </p>
        <p>6.3 Bạn cần biết rõ rằng bất kỳ thời điểm nào bạn tiết lộ và công khai Dữ Liệu Cá Nhân của bạn, dữ liệu đó có thể bị người khác thu thập và sử dụng bởi các mục đích nằm ngoài tầm kiểm soát của bạn và chúng tôi.

        </p>
        <p>6.4 Chúng tôi khuyến cáo bạn bảo quản thiết bị cá nhân (máy điện thoại, máy tính bảng, máy tính cá nhân…) trong quá trình sử dụng; bạn nên đăng xuất khỏi tài khoản của mình khi không có nhu cầu sử dụng.

        </p>
        <p>6.5 Trong trường hợp máy chủ lưu trữ dữ liệu bị tấn công dẫn đến bị mất, lộ, lọt Dữ Liệu Cá Nhân của bạn, HPship sẽ có trách nhiệm thông báo vụ việc cho cơ quan chức năng điều tra xử lý kịp thời và thông báo cho bạn được biết theo quy định pháp luật.

        </p>
        <p>6.6 Không gian mạng không phải là một môi trường an toàn và chúng tôi không thể đảm bảo tuyệt đối rằng Dữ Liệu Cá Nhân của bạn được chia sẻ qua không gian mạng sẽ luôn được bảo mật. Khi bạn truyền tải Dữ Liệu Cá Nhân qua không gian mạng, bạn chỉ nên sử dụng các hệ thống an toàn để truy cập trang thông tin điện tử, ứng dụng hoặc thiết bị. Bạn có trách nhiệm giữ thông tin xác thực truy cập của mình cho từng trang thông tin điện tử, ứng dụng hoặc thiết bị an toàn và bí mật.

        </p>
        <hr>
        <h3>
            <strong>
                7. TỔ CHỨC, CÁ NHÂN THAM GIA QUÁ TRÌNH XỬ LÝ DỮ LIỆU CÁ NHÂN
            </strong>
        </h3>
        <p>7.1 “Bên Kiểm Soát Dữ Liệu Cá Nhân” là tổ chức, cá nhân quyết định mục đích và phương tiện Xử Lý Dữ Liệu Cá Nhân. “Bên Kiểm Soát Và Xử Lý Dữ Liệu Cá Nhân” là tổ chức, cá nhân đồng thời quyết định mục đích, phương tiện và trực tiếp Xử Lý Dữ Liệu Cá Nhân. Tùy từng trường hợp, HPship có thể là Bên Kiểm Soát Dữ Liệu Cá Nhân hoặc Bên Kiểm Soát Và Xử Lý Dữ Liệu Cá Nhân.

        </p>
        <p>7.2 Trong phạm vi pháp luật cho phép, Dữ Liệu Cá Nhân của bạn có thể được chuyển giao, truy cập bởi hoặc tiết lộ cho bên thứ ba để phục vụ Các Mục Đích. Ngoài ra, HPship có thể hợp tác với các công ty, bên cung cấp dịch vụ hoặc cá nhân khác nhằm thực hiện các công việc cần thiết nhân danh HPship, và do vậy việc này có thể cung cấp quyền tiếp cận hoặc tiết lộ Dữ Liệu Cá Nhân của bạn cho các nhà cung cấp dịch vụ hoặc bên thứ ba đó. Bên thứ ba bao gồm, nhưng không giới hạn:
        <ul>
            <li>(a) Các đối tác của HPship, bao gồm các bên HPship cộng tác trong các sự kiện, chương trình và hoạt động nhất định;
            </li>
            <li>(b) Bên cung cấp dịch vụ quảng cáo;
            </li>
            <li>(c) Các công ty tổ chức sự kiện và nhà tài trợ sự kiện;
            </li>
            <li>(d) Các công ty nghiên cứu thị trường;
            </li>
            <li>(e) Các bên cung cấp dịch vụ, bao gồm, các nhà cung cấp dịch vụ công nghệ thông tin (CNTT) về cơ sở hạ tầng, phần mềm và công tác phát triển;
            </li>
            <li>(f) Các cố vấn chuyên môn và kiểm toán viên bên ngoài, bao gồm cố vấn pháp lý, cố vấn tài chính và chuyên gia tư vấn;
            </li>
            <li>(g) Các tổ chức khác trong HPship;
            </li>
            <li>(h) Các cơ quan nhà nước để tuân thủ các quy định của pháp luật và yêu cầu của cơ quan nhà nước.
            </li>
        </ul>
        </p>
        <p>7.3 Dữ Liệu Cá Nhân cũng có thể được chia sẻ liên quan đến giao dịch doanh nghiệp, chẳng hạn như thành lập liên doanh, bán công ty con hoặc bộ phận kinh doanh, sáp nhập, hợp nhất, hoặc bán tài sản, hoặc trong trường hợp khó có thể xảy ra là giải thể doanh nghiệp.

        </p>
        <hr>
        <h3>
            <strong>
                8. BẠN CÓ CÁC QUYỀN SAU
            </strong>
        </h3>
        <p>8.1 Bạn được biết về hoạt động Xử Lý Dữ Liệu Cá Nhân của mình, trừ trường hợp pháp luật có quy định khác.

        </p>
        <p>8.2 Bạn được quyết định sự đồng ý liên quan đến việc Xử Lý Dữ Liệu Cá Nhân của mình, trừ trường hợp pháp luật quy định khác.

        </p>
        <p>8.3 Bạn được quyền truy cập để xem, chỉnh sửa hoặc yêu cầu chỉnh sửa Dữ Liệu Cá Nhân của mình, trừ trường hợp pháp luật có quy định khác. Chúng tôi sẽ chỉnh sửa Dữ Liệu Cá Nhân khi được bạn yêu cầu hoặc theo quy định pháp luật chuyên ngành. Trường hợp không thể thực hiện, chúng tôi sẽ thông báo tới bạn theo thỏa thuận giữa chúng tôi và bạn hoặc theo quy định pháp luật tại từng thời điểm.

        </p>
        <p>8.4 Bạn được quyền xóa hoặc yêu cầu xóa Dữ Liệu Cá Nhân của mình theo quy định của Điều 4.8 của Chính Sách này.

        </p>
        <p>8.5 Bạn được quyền yêu cầu hạn chế Xử lý Dữ Liệu Cá Nhân của mình theo quy định pháp luật. Việc hạn chế xử lý dữ liệu sẽ được chúng tôi thực hiện sau khi có yêu cầu của bạn phù hợp với điều kiện kỹ thuật cho phép trừ trường hợp pháp luật có quy định khác hoặc theo thỏa thuận của các bên.

        </p>
        <p>8.6 Bạn được quyền yêu cầu chúng tôi cung cấp cho bản thân Dữ Liệu Cá Nhân của mình, việc cung cấp Dữ Liệu Cá Nhân của bạn sẽ được HPship thực hiện sau khi có yêu cầu của bạn, trừ trường hợp pháp luật có quy định khác.
        <ul>
            <li>(i) Yêu cầu của bạn chỉ được coi là hợp lệ và được chấp nhận xử lý khi có đầy đủ các thông tin cần thiết và sử dụng đúng biểu mẫu theo quy định của pháp luật về bảo vệ Dữ Liệu Cá Nhân hiện hành;
            </li>
            <li>(ii) HPship có thể tính một khoản phí hợp lý cho bạn để giải quyết và xử lý yêu cầu cung cấp dữ liệu cá nhân của bạn. Nếu chúng tôi có tính phí, chúng tôi sẽ cung cấp cho bạn ước tính lệ phí bằng văn bản tùy thuộc vào từng trường hợp cụ thể.
            </li>
        </ul>
        </p>
        <p>8.7 Bạn được quyền yêu cầu rút lại sự đồng ý đối với các mục đích xử lý mà bạn đồng ý cho phép HPship xử lý, trừ trường hợp pháp luật có quy định khác. Khi nhận được yêu cầu, HPship thông báo cho bạn về hậu quả, thiệt hại có thể xảy ra khi rút lại sự đồng ý.

        </p>
        <p>Trường hợp việc rút lại sự đồng ý của bạn ảnh hưởng tới việc thực hiện hợp đồng giữa HPship và bạn, nghĩa vụ pháp lý của HPship, tính mạng, tài sản và quyền, lợi ích hợp pháp của bạn, tổ chức, cá nhân khác, nhiệm vụ bảo vệ an ninh quốc gia, trật tự an toàn xã hội, chúng tôi có quyền hạn chế, tạm ngừng, chấm dứt, hủy bỏ một phần hoặc toàn bộ hợp đồng cung cấp Các Dịch Vụ giữa HPship và bạn. Chúng tôi không chịu bất kỳ trách nhiệm pháp lý hoặc bồi thường cho bất kỳ tổn thất nào phát sinh đối với bạn trong trường hợp này.

        </p>
        <p>8.8 Bạn được quyền phản đối HPship Xử Lý Dữ Liệu Cá Nhân của mình nhằm ngăn chặn hoặc hạn chế tiết lộ Dữ Liệu Cá Nhân hoặc lý do khác theo quy định pháp luật. Chúng tôi sẽ thực hiện yêu cầu phản đối của bạn sau khi nhận được yêu cầu, trừ trường hợp pháp luật có quy định khác.

        </p>
        <p>Trường hợp việc phản đối của bạn ảnh hưởng tới việc thực hiện hợp đồng giữa HPship và bạn, nghĩa vụ pháp lý của HPship, tính mạng, tài sản và quyền, lợi ích hợp pháp của bạn, tổ chức, cá nhân khác, nhiệm vụ bảo vệ an ninh quốc gia, trật tự an toàn xã hội, chúng tôi có quyền hạn chế, tạm ngừng, chấm dứt, hủy bỏ một phần hoặc toàn bộ hợp đồng cung cấp Các Dịch Vụ giữa HPship và bạn. Chúng tôi không chịu bất kỳ tổn thất nào phát sinh đối với bạn trong trường hợp này.

        </p>
        <p>8.9 Bạn có quyền khiếu nại, tố cáo hoặc khởi kiện theo quy định pháp luật.

        </p>
        <p>8.10 Bạn có quyền yêu cầu bồi thường đối với thiệt hại thực tế theo quy định pháp luật nếu HPship có hành vi vi phạm quy định về bảo vệ Dữ Liệu Cá Nhân của mình, trừ trường hợp các bên có thỏa thuận khác hoặc pháp luật có quy định khác.

        </p>
        <p>8.11 Bạn có quyền tự bảo vệ theo quy định pháp luật có liên quan, bao gồm nhưng không giới hạn Bộ Luật Dân Sự, hoặc yêu cầu cơ quan, tổ chức có thẩm quyền thực hiện các phương thức bảo vệ quyền dân sự như buộc chấm dứt hành vi xâm phạm, buộc xin lỗi, cải chính công khai, buộc bồi thường thiệt hại.

        </p>
        <p>8.12 Các quyền khác theo Chính Sách này và theo quy định pháp luật.

        </p>
        <hr>
        <h3>
            <strong>
                9. BẠN CÓ CÁC NGHĨA VỤ SAU
            </strong>
        </h3>
        <p>9.1 Tuân thủ các quy định pháp luật, quy định của HPship liên quan đến Xử Lý Dữ Liệu Cá Nhân của bạn.

        </p>
        <p>9.2 Cung cấp đầy đủ, trung thực, chính xác Dữ Liệu Cá Nhân, các thông tin khác theo yêu cầu của HPship khi sử dụng Dịch Vụ của HPship và khi có thay đổi về các thông tin này. Chúng tôi sẽ tiến hành bảo mật Dữ Liệu Cá Nhân của bạn căn cứ trên thông tin bạn đã cung cấp. Do đó, nếu có bất kỳ thông tin sai lệch nào, chúng tôi sẽ không chịu trách nhiệm trong trường hợp thông tin đó làm ảnh hưởng hoặc hạn chế quyền lợi của bạn. Trường hợp không thông báo, nếu có phát sinh rủi ro, tổn thất thì bạn chịu trách nhiệm về những sai sót hay hành vi lợi dụng, lừa đảo khi sử dụng Sản phẩm, hàng hóa, dịch vụ do lỗi của bạn hoặc do không cung cấp đúng, đầy đủ, chính xác, kịp thời sự thay đổi thông tin; bao gồm cả thiệt hại về tài chính, chi phí phát sinh do thông tin cung cấp sai hoặc không thống nhất.

        </p>
        <p>9.3 Phối hợp với chúng tôi, cơ quan nhà nước có thẩm quyền hoặc bên thứ ba trong trường hợp phát sinh các vấn đề ảnh hưởng đến tính bảo mật Dữ Liệu Cá Nhân của bạn.

        </p>
        <p>9.4 Tự bảo vệ Dữ Liệu Cá Nhân của bạn; yêu cầu các tổ chức, cá nhân khác có liên quan bảo vệ Dữ Liệu Cá Nhân của bạn; chủ động áp dụng các biện pháp nhằm bảo vệ Dữ Liệu Cá Nhân của bạn trong quá trình sử dụng Dịch Vụ của HPship; thông báo kịp thời cho chúng tôi khi phát hiện thấy có sai sót, nhầm lẫn về Dữ Liệu Cá Nhân hoặc nghi ngờ Dữ Liệu Cá Nhân đang bị xâm phạm.

        </p>
        <p>9.5 Tôn trọng, bảo vệ Dữ Liệu Cá Nhân của người khác.

        </p>
        <p>9.6 Tự chịu trách nhiệm đối với những thông tin, dữ liệu mà bạn tạo lập, cung cấp trên không gian mạng; tự chịu trách nhiệm trong trường hợp Dữ Liệu Cá Nhân bị rò rỉ, xâm phạm do lỗi của mình.

        </p>
        <p>9.7 Thường xuyên cập nhật các quy định, chính sách liên quan đến việc bảo vệ và Xử Lý Dữ Liệu Cá Nhân của HPship trong từng thời kỳ được thông báo tới bạn qua Nền Tảng của HPship.

        </p>
        <p>9.8 Bạn cam kết hiểu rõ tầm quan trọng của việc bảo vệ Dữ Liệu Cá Nhân của trẻ em. Theo đó, bạn đảm bảo tuân thủ các quy định pháp luật về bảo vệ Dữ Liệu Cá Nhân của trẻ em, bao gồm nhưng không giới hạn nhận được sự đồng ý/chấp thuận của trẻ em, cha, mẹ hoặc người giám hộ theo quy định pháp luật trước khi chia sẻ Dữ Liệu Cá Nhân của trẻ em cho HPship. Đồng thời, bạn cam kết miễn trừ mọi trách nhiệm của HPship đối với việc xử lý Dữ Liệu Cá Nhân của trẻ em theo Các Mục Đích được nêu tại Chính Sách này.

        </p>
        <p>9.9 Thực hiện quy định pháp luật về bảo vệ Dữ Liệu Cá Nhân và tham gia phòng, chống các hành vi vi phạm quy định về bảo vệ Dữ Liệu Cá Nhân.

        </p>
        <hr>
        <h3>
            <strong>
                10. LIÊN KẾT TRANG WEB VỚI BÊN THỨ BA
            </strong>
        </h3>
        <p>Các Nền Tảng có thể chứa các liên kết tới các trang web của các bên thứ ba. Xin vui lòng lưu ý rằng HPship không chịu trách nhiệm đối với việc thu thập, sử dụng, duy trì, chia sẻ, hoặc tiết lộ dữ liệu và thông tin của các bên thứ ba đó. Nếu bạn trực tiếp cung cấp thông tin cho những trang đó, Chính Sách và Điều Khoản của những trang đó sẽ được áp dụng và HPship không chịu trách nhiệm đối với các hoạt động xử lý thông tin hoặc các Chính Sách của những trang đó.

        </p>
        <hr>
        <h3>
            <strong>
                11. LIÊN HỆ VỚI CHÚNG TÔI
            </strong>
        </h3>
        <p>Nếu bạn muốn thực hiện các quyền của mình trong Điều 8 hoặc nếu bạn yêu cầu bất kỳ thông tin nào theo Chính Sách này, bạn có thể liên hệ với chúng tôi theo nhiều cách khác nhau:
        <ul>
            <li>Gọi cho đường dây nóng của chúng tôi: 1900636677
            </li>
            <li>Gửi thư điện tử cho chúng tôi theo địa chỉ: cskh@HPship.vn
            </li>
            <li>Hoặc liên hệ trực tiếp với chúng tôi tại: 12 Nguyễn Văn Bảo, Phường 5, Quận Gò Vấp, Thành phố Hồ Chí Minh.
            </li>
        </ul>
        </p>
        <hr>
        <h3>
            <strong>
                12. ĐỒNG Ý VÀ CHẤP THUẬN
            </strong>
        </h3>
        <p>12.1 Bằng cách liên lạc với HPship, sử dụng các Dịch Vụ của HPship, mua các sản phẩm từ HPship hoặc thông qua việc hợp tác với HPship, bạn đồng ý rằng bạn đã đọc và hiểu Chính Sách này; đồng ý và chấp thuận việc HPship sử dụng, xử lý và chuyển giao Dữ Liệu Cá Nhân của bạn theo quy định tại Chính Sách này.

        </p>
        <p>12.2 HPship có thể cập nhật Chính Sách này tại từng thời điểm. Bất kỳ thay đổi nào được chúng tôi thực hiện đối với Chính Sách này trong tương lai sẽ được phản ánh trên trang này và những thay đổi quan trọng sẽ được thông báo đến bạn. Trong trường hợp được pháp luật cho phép, việc bạn tiếp tục sử dụng Các Dịch Vụ hoặc truy cập vào Các Nền Tảng sau những điều chỉnh, cập nhật, hoặc sửa đổi của Chính Sách này (cho dù bạn đã xem xét tài liệu điều chỉnh, cập nhật hoặc sửa đổi đó hay chưa) sẽ thể hiện việc xác nhận và sự chấp thuận của bạn về những thay đổi mà chúng tôi thực hiện đối với Chính Sách này. Bạn đồng ý rằng bạn có trách nhiệm thường xuyên xem xét và kiểm tra Chính Sách để biết nếu có bất kỳ cập nhật hoặc thay đổi nào đã được thực hiện đối với Chính Sách này.

        </p>
        <p>12.3 Chính Sách này có thể được dịch ra tiếng Anh. Trong trường hợp có mâu thuẫn giữa bản tiếng Anh và tiếng Việt của Chính Sách này, bản tiếng Việt được ưu tiên áp dụng.

        </p>
    </div>
</body>

</html>