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
            <h1>CHÍNH SÁCH BỒI THƯỜNG CỦA HPship</h1>
        </div>
        <div class="content-page add-height-img">
        <p style="text-align:center">Bằng việc chấp nhận sử dụng Dịch vụ của Công ty Cổ phần Dịch vụ Giao Hàng Nhanh, Khách hàng hiểu và đồng ý với chính sách về Quyền và nghĩa vụ được nêu dưới đây.</p>
        <h2><strong>I. THUẬT NGỮ</strong></h2>
        <p><strong>
            Chính sách bồi thường này ("Chính sách bồi thường") sẽ có giá trị pháp lý ràng 
            buộc Khách hàng (được định nghĩa dưới đây).
        </strong>
        </p>
        <p>
            <strong>“HPship”</strong> 
            có nghĩa là Công ty Cổ phần Dịch vụ Giao Hàng toàn quốc Quick Shipping.
        </p>
        <p>
            <strong>“Khách hàng”</strong> 
            có nghĩa là cá nhân hoặc tổ chức sử dụng Dịch vụ của HPship.
        </p>
        <p>
            <strong>“Bưu gửi”</strong>
            có nghĩa là thư, gói, kiện hàng hóa được GNH chấp nhận, vận chuyển và phát 
            hợp pháp trong hệ thống bưu cục của HPship.
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
        II. KHAI BÁO GIÁ TRỊ HÀNG HÓA
        </strong>
        </h2>
        <p>
        Khai báo Giá trị Hàng hóa <strong>(“Khai báo Giá trị Hàng hóa”)</strong> được xác định theo quy định 
        tại Mục II này sẽ là căn cứ để tính trách nhiệm bồi thường của HPship theo quy định tại 
        Mục III dưới đây.</p>
        <p>
        Cho mục đích của Chính sách bồi thường này, Giá trị Bưu gửi sẽ được xác định là giá 
        trị được ghi/thể hiện trên hóa đơn có giá trị pháp lý mà người bán xuất cho Khách hàng 
        cho việc mua Hàng hóa đó <strong>(“Hóa đơn”)(*)</strong>, với điều kiện là mô tả về Hàng hóa được nêu 
        trên Hóa đơn phù hợp với mô tả mà Khách hàng tự ghi trên Đơn hàng.
        </p>
        <p>
        <strong>(*) Lưu ý:</strong> Hóa đơn có giá trị pháp lý là:
        <ul type="circle">
            <li>
                Hóa đơn giá trị gia tăng, nếu người bán là doanh nghiệp kê khai 
                thuế giá trị gia tăng (“GTGT”) theo phương pháp khấu trừ; hoặc
            </li>
            <li>
                Hóa đơn bán hàng, nếu người bán là doanh nghiệp kê khai thuế GTGT 
                theo phương pháp trực tiếp; hoặc
            </li>
            <li>
                Bộ hồ sơ kê khai hải quan, nếu Hàng hóa được nhập khẩu từ nước ngoài 
                vào Việt Nam.
            </li>
        </ul>
        <hr>
        <h2>
        <strong>
        III. BỒI THƯỜNG BỞI HPship
        </strong>
        </h2>
        <h3>
            3.1. Trường hợp Bưu gửi bị mất, thất lạc, hư hỏng
        </h3>
        <p>
        HPship sẽ chịu trách nhiệm bồi thường cho Khách hàng nếu Bưu gửi bị hư hỏng, 
        mất mát hoặc thất lạc xảy ra trong quá trình HPship cung ứng Dịch vụ gây ra do 
        lỗi của HPship. Trách nhiệm của HPship chỉ giới hạn trong thiệt hại và tổn thất trực 
        tiếp và thực tế gây ra cho hoặc liên quan đến Bưu gửi. Các loại thiệt hại hoặc 
        tổn thất khác (bao gồm nhưng không hạn chế bởi tổn thất lợi nhuận, thu nhập, 
        cơ hội kinh doanh) sẽ bị loại trừ.
        </p>
        <p>
            <strong>
            a. Bưu gửi là thư từ, tài liệu, ấn phẩm, giấy tờ, hóa đơn, hợp đồng và các loại văn bản khác:
            </strong>
        </p>
        <p>
            Trong trường hợp Bưu gửi bị hư hỏng, mất mát hoặc thất lạc, khoản tiền bồi thường HPship sẽ trả cho Khách hàng sẽ bằng 04 (bốn) lần Cước phí của Dịch vụ đã sử dụng.
        </p>
        <p>
            <strong>
            b. Bưu gửi là vật phẩm, hàng hóa hoặc Phiếu có giá trị quy đổi:
            </strong>
        </p>
        <p>
            <strong>
            b.1. Trường hợp Bưu gửi bị mất, thất lạc toàn bộ bưu gửi
            </strong>
        </p>
        <div class="scroll-table" bis_skin_checked="1">
            <table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse; width:100%">
            <tbody>
                <tr>
                    <td style="background-color:#fc5200; text-align:justify">
                    <span style="color:#ffffff">
                    <strong>Trường hợp</strong>
                </span>
            </td>
            <td style="background-color:#fc5200; text-align:justify">
            <span style="color:#ffffff">
            <strong>Chi tiết bồi thường</strong>
        </span>
    </td></tr><tr><td><p style="text-align: justify;">Khách hàng có khai báo giá trị hàng hóa và có đầy đủ hóa đơn</p></td><td><p style="text-align: justify;">Khoản tiền bồi thường HPship sẽ trả cho Khách hàng sẽ bằng giá trị hàng hóa mà Khách hàng đã khai báo với HPship. Trong trường hợp Khách hàng có đầy đủ hóa đơn và có khai báo giá trị hàng hóa, khoản tiền bồi thường sẽ không vượt quá 5.000.000 VND ( Năm triệu đồng)</p></td></tr><tr><td><p style="text-align: justify;">Khách hàng không khai báo giá trị hàng hóa hoặc không cung cấp đủ hóa đơn</p></td><td style="text-align:justify">Đền bù tối đa 4 lần cước phí dịch vụ</td></tr></tbody>
        </table>
        </div>
        <p>
            <strong>
            b.2. Trường hợp Bưu gửi bị hư hỏng:
            </strong>
        </p>
        <div class="scroll-table" bis_skin_checked="1"><table cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse; width:100%"><tbody><tr><td style="background-color:#fc5200; width:360px"><span style="color:#ffffff"><strong>Loại hư hỏng</strong></span></td><td style="background-color:#fc5200; width:150px"><span style="color:#ffffff"><strong>Mức bồi thường tối đa</strong></span></td><td style="background-color:#fc5200"><span style="color:#ffffff"><strong>Khoản tiền bồi thường tối đa</strong></span></td></tr><tr><td style="width:360px"><p style="text-align: justify;">Hàng hóa bên trong Bưu gửi còn nguyên, tuy nhiên bao bì sản phẩm/hàng hóa bị:</p><ul><li style="text-align: justify;">Rách, vỡ, ướt thùng, bao, hộp đựng sản phẩm</li><li style="text-align: justify;">Rách tem niêm phong của nhà sản xuất, sản phẩm còn nguyên</li></ul></td><td style="width:150px"><p style="text-align: justify;">5%</p></td><td><p style="text-align: justify;">Khoản tiền bồi thường mất hàng x % hư hỏng</p></td></tr><tr><td style="width:360px"><p style="text-align: justify;">Hàng hóa bị bể vỡ, hư hại đến 50%</p></td><td style="width:150px"><p style="text-align: justify;">50%</p></td><td><p style="text-align: justify;">Khoản tiền bồi thường mất hàng x % hư hỏng</p></td></tr><tr><td style="width:360px"><p style="text-align: justify;">Hàng hóa bị bể vỡ, hư hại trên&nbsp; 50%</p></td><td style="width:150px"><p style="text-align: justify;">100%</p></td><td><p style="text-align: justify;">Khoản tiền bồi thường mất hàng x % hư hỏng</p></td></tr></tbody></table></div>
        <h3>
            3.2. Trường hợp chậm trễ giao phát Bưu gửi
        </h3>
        <p>
            <strong>
                a. Trễ toàn trình
            </strong>
        </p>
        <p>
        Trong trường hợp Bưu gửi được phát cho Người Nhận trễ so với thời gian toàn trình 
        thì HPship sẽ không tính Cước phí Dịch vụ của Đơn hàng bị trễ đó. Trong trường hợp 
        xảy ra Sự Kiện Bất Khả Kháng, thời gian toàn trình dự kiến có thể kéo dài thêm từ 
        10 (mười) đến 15 (mười lăm) ngày kể từ ngày kết thúc Sự Kiện Bất Khả Kháng.
        (***) Để tránh hiểu lầm, "Sự kiện bất khả kháng" có nghĩa là bất kỳ sự cản trở, 
        chậm trễ hoặc ngừng hoạt động nào xảy ra do dịch bệnh, bãi công, đóng cửa, 
        tranh chấp lao động, thiên tai, chiến tranh, bạo động trong dân chúng, hỏa hoạn 
        hay các sự cố/ tai họa khác; những thay đổi trong chính sách của cơ quan có thẩm 
        quyền mà vượt quá khả năng kiểm soát hợp lý của một Bên khiến cho Bên đó không 
        thể thực hiện các nghĩa vụ được theo thỏa thuận.
        </p>
        <p>
            <strong>
                b. Không xử lý
            </strong>
        </p>
        <p>
        Trừ trường hợp do Sự kiên bất khả kháng và/hoặc do lỗi của Khách hàng, 
        nếu HPship giữ Bưu gửi mà không thực hiện giao phát cho Người nhận quá 30 
        (ba mươi) ngày tính từ ngày Bưu gửi được HPship nhận từ Khách hàng, hoặc 
        không phát trả Bưu gửi cho Khách hàng hoặc thông báo cho Khách hàng 
        lên nhận lại Bưu gửi trong thời hạn 30 (ba mươi) ngày tính từ ngày 
        giao phát không thành công, thì HPship sẽ bồi thường đơn hàng đó theo như 
        chính sách bồi thường mất hàng.
        Quy định trên không áp dụng cho trường hợp hai bên đang có tranh chấp 
        về Đơn hàng hoặc HPship trả Bưu gửi nhưng Khách hàng từ chối nhận lại Bưu 
        gửi từ 03 (ba) lần trở lên.
        </p>
        <p>
            <strong>
            c. Bồi thường đối với Bưu gửi hoàn trả không thành công
            </strong>
        </p>
        <p>
        Đối với Bưu gửi giao không thành công nhưng khi hoàn trả lại cho Khách hàng hoặc Người gửi không thành công mà bị thất thoát, hư hỏng: Đền bù 04 (bốn) lần Cước phí của Dịch vụ đã sử dụng đối với Đơn hàng đó.
        Hoàn trả Bưu gửi không thành công: được hiểu HPship là đã liên hệ khách hàng, người gửi để hoàn trả hàng trong thời gian xử lý được phép nhưng không thể liên hệ được, hoặc đã liên hệ được nhưng khách hàng, người gửi không đến nhận lại hàng theo thỏa thuận hoặc thông báo của HPship.
        </p>
        <h3>
            3.3 Các lưu ý và quy định khác về trách nhiệm bồi thường của HPship
        </h3>
        <ul type="circle">
            <li>
                HPship sẽ chỉ thanh toán khoản tiền bồi thường trực tiếp cho Khách hàng. Trong trường hợp Khách hàng ủy quyền cho người khác nhận khoản tiền bồi thường, Khách hàng cần phải cung cấp cho HPship một thư ủy quyền hợp lệ được HPship chấp nhận.
            </li>
            <li>
                Đối với Bưu gửi là Phiếu có giá trị quy đổi có thời hạn sử dụng thì Khách hàng sẽ chỉ được bồi thường nếu thời hạn sử dụng của phiếu phải còn ít nhất là 03 (ba) tháng tính từ khi HPship nhận Bưu gửi. Khách hàng thừa nhận và đồng ý rằng Khách hàng sẽ không có quyền yêu cầu bồi thường, và HPship sẽ không có trách nhiệm bồi thường, nếu phiếu có giá trị quy đổi bị mất hay hư hỏng không đạt điều kiện này.
            </li>
            <li>
                Trong mọi trường hợp mất, thất lạc hoặc hư hỏng xảy ra cho Bưu gửi, khoản tiền bồi thường sẽ không thấp hơn 04 (bốn) lần Cước phí của Dịch vụ đã sử dụng.
            </li>
            <li>
                Khách hàng thừa nhận và đồng ý rằng nếu Khách hàng từ chối hoặc không phối hợp để thực hiện đồng kiểm Bưu gửi với HPship thì trong trường hợp xảy ra mất mát, thất lạc, hư hỏng cho Bưu gửi, khoản tiền bồi thường HPship phải trả cho Khách hàng sẽ chỉ bằng 04 (bốn) lần Cước phí của Dịch vụ đã sử dụng.
            </li>
            <li>
                Khách hàng thừa nhận và đồng ý rằng trong trường hợp xảy ra mất mát, thất lạc, hư hỏng cho Bưu gửi mà Khách hàng không cung cấp được Hóa đơn chứng minh Giá trị khai báo hàng hóa theo quy định tại Mục II trên đây thì khoản tiền bồi thường HPship phải trả cho Khách hàng sẽ chỉ bằng 04 (bốn) lần Cước phí của Dịch vụ đã sử dụng.
            </li>
            <li>
                Khách hàng thừa nhận và đồng ý rằng trong mọi trường hợp, khoản tiền bồi thường trên đã bao gồm việc hoàn trả Cước phí Dịch vụ đã thanh toán cho HPship.
            </li>
            <li>
                Khách hàng từ bỏ và sẽ không thực hiện bất kỳ và mọi quyền, quyền yêu cầu, hành động chống lại HPship liên quan đến tổn thất, thiệt hại gây ra cho Bưu gửi vượt quá hạn chế trách nhiệm bồi thường của HPship như nêu tại Mục III này.
            </li>    
        </ul>
        <hr>
        <h2>
        <strong>
        IV. BỒI THƯỜNG BỞI KHÁCH HÀNG
        </strong>
        </h2>
        <p>
        Khách hàng thừa nhận và đồng ý sẽ bồi thường, bảo vệ và giữ cho HPship và cổ đông, giám đốc, người quản lý, nhân viên, nhà thầu, tư vấn của HPship (các “Bên được bồi thường của HPship”) không bị ảnh hưởng và tránh khỏi bất kỳ và mọi thiệt hại, tổn thất, chi phí và phí (bao gồm phí pháp lý), yêu cầu, trách nhiệm, khiếu kiện, lệnh, yêu cầu, hành động của cơ quan nhà nước có thẩm quyền, có thể được đưa ra chống lại hoặc phải gánh chịu bởi HPship và các Bên được bồi thường của HPship, là hậu quả của hoặc phát sinh từ hoặc có liên quan đến:
        <ul>
            <li>Thiệt hại, hư hỏng, tổn thất, mất mát, hao hụt, trách nhiệm, yêu cầu, khiếu kiện liên quan đến Bưu gửi đó gây ra bởi hành động hoặc việc không thực hiện một hành động nào của Khách hàng, bao gồm nhưng không hạn chế bởi việc cung cấp, kê khai thông tin về Bưu gửi không đúng hoặc thiếu sót; đóng gói, bao bọc Bưu gửi không đầy đủ, không phù hợp, không cẩn thận, không tuân thủ quy định, hướng dẫn về đóng gói của HPship, nhà sản xuất hay quy định của pháp luật; Thông tin Người Nhận không đúng hoặc thiếu sót; hoặc</li>
            <li>Bưu gửi thuộc trường hợp bị cấm gửi, chấp nhận, vận chuyển theo quy định của pháp luật; hoặc</li>
            <li>Khách hàng vi phạm quy định pháp luật.</li>
        </ul>
        </p>
        <hr>
        <h2>
        <strong>
        V. MIỄN TRỪ TRÁCH NHIỆM
        </strong>
        </h2>
        <p>Khách hàng thừa nhận và đồng ý HPship sẽ được miễn trừ trách nhiệm và sẽ vô can đối với bất kỳ và mọi thiệt hại, tổn thất, mất mát, hư hỏng, bồi thường, chậm trễ, yêu cầu, trách nhiệm, khiếu kiện, hành động của Khách hàng và/hoặc cơ quan nhà nước có thẩm quyền có thể được đưa ra chống lại hoặc phải gánh chịu bởi HPship và các Bên được bồi thường của HPship liên quan đến Bưu gửi được gây ra bởi, phát sinh từ, hoặc liên quan đến:</p>
        <ul>
            <li>
                Sự không tuân thủ bởi Khách hàng bất kỳ quy định của pháp luật về 
                hàng hóa cấm hoặc hạn chế lưu thông, vận chuyển và các quy định khác 
                của pháp luật bao gồm, nhưng không hạn chế bởi trường hợp Bưu gửi 
                không có hóa đơn, chứng từ nguồn gốc xuất xứ; bị kiểm tra, tạm giữ, 
                tịch thu hoặc tiêu hủy (dẫn đến bị mất mát, giảm khối lượng, giảm 
                chất lượng hay hư hỏng toàn bộ hoặc một phần) theo quyết điṇh của 
                cơ quan có thẩm quyền hoặc an ninh sân bay.
            </li>
            <li>
                Sự không tuân thủ bởi Khách hàng bất kỳ thỏa thuận nào về sử dụng 
                Dịch vụ của HPship, hoặc bất kỳ quy định, chính sách nào của HPship 
                (bao gồm, nhưng không hạn chế bởi Bưu gửi nằm ngoài phạm vi nhận 
                vận chuyển của HPship, địa chỉ giao hoặc nhận Bưu gửi không thuộc phạm vi 
                cung ứng Dịch vụ của HPship, Bưu gửi thuộc danh mục hàng hóa không được vận 
                chuyển qua đường hàng không; Khách hàng không thực hiện đúng các quy định 
                về khiếu nại, giải quyết tranh chấp theo luật định hoặc theo Chính sách 
                chăm sóc Khách hàng của HPship);
            </li>
            <li>
                Hành động hoặc không thực hiện hành động nào của Khách hàng, 
                cho dù là do lỗi cẩu thả, bất cẩn, cố ý làm sai, hoặc lừa dối 
                (bao gồm, nhưng không hạn chế bởi trường hợp việc cung cấp, kê 
                khai thông tin về Bưu gửi không đúng hoặc thiếu sót; đóng gói, 
                bao bọc Bưu gửi không đầy đủ, không phù hợp, không cẩn thận, không 
                tuân thủ quy định, hướng dẫn về đóng gói của HPship, nhà sản xuất hay 
                quy định của pháp luật; Thông tin Người Nhận không đúng hoặc thiếu 
                sót Khách hàng không có chứng từ chứng minh Bưu gửi bị mất hoặc hư 
                hỏng; Khách hàng không có chứng từ chứng minh việc sử dụng Dịch vụ, 
                Khách hàng dán sai mã đơn hàng);
            </li>
            <li>
                Hành động hoặc không thực hiện hành động của một bên thứ ba, 
                cho dù là do lỗi cẩu thả, bất cẩn, cố ý làm sai, hoặc lừa dối 
                (bao gồm, nhưng không hạn chế bởi trường hợp hàng hóa bị cướp, 
                giật; hư hỏng, mất mát gây ra bởi Người Nhận; hàng hóa không 
                đáp ứng yêu cầu, tiêu chuẩn về chất lượng, quy cách, bao gồm 
                nhưng không giới hạn trường hợp màu sắc, kích cỡ, chất liệu sản 
                phẩm không đúng với hình ảnh, thông tin được cung cấp bởi người 
                bán hàng hoặc nhà sản xuất; chuyến bay chậm trễ hoặc bị hủy; bị 
                cơ quan chức năng kiểm tra trên đường vận chuyển);
            </li>
            <li>
                Đặc tính tự nhiên, khuyết tật vốn có của hàng hóa nằm trong Bưu gửi;
            </li>
            <li>
                Suy suyển, hao mòn, hư hỏng khách quan, tự nhiên diễn ra trong quá 
                trình vận chuyển (bao gồm, nhưng không hạn chế bởi trường hợp hàng 
                hóa bị thay đổi hình dáng, màu sắc khi nhiệt độ môi trường thay đổi, 
                đặc điểm của hàng hóa gây ra tự cháy, biến chất, hao hụt, han gỉ, 
                nứt vỡ, ẩm mốc…);
            </li>
            <li>
                Khách hàng từ chối nhận lại Bưu gửi hoặc HPship không liên hệ được với 
                Khách hàng sau khi HPship đã thực hiện giao trả lại Bưu gửi ít nhất 03 
                (ba) lần. Trong trường hợp này, Khách hàng thừa nhận và đồng ý rằng 
                Khách hàng đã từ bỏ mọi quyền và quyền yêu cầu và HPship sẽ được miễn 
                trừ khỏi mọi yêu cầu, trách nhiệm, khiếu kiện liên quan đến Bưu gửi.
                Để tránh hiểu lầm, sau 06 (sáu) tháng kể từ lần trả cuối cùng nêu 
                trên, HPship sẽ được quyền sở hữu hàng hoá trong Bưu gửi đó và rằng, 
                Khách hàng cam kết không có bất kỳ khiếu nại, khiếu kiện nào về vấn 
                đề này.
            </li>
            <li>
                Trong trường hợp một phần thiệt hại, tổn thất xảy ra do Khách hàng 
                vi phạm, Khách hàng thừa nhận và đồng ý sẽ từ bỏ quyền yêu cầu đối 
                với, và HPship sẽ không có trách nhiệm bồi thường cho, phần thiệt hại, 
                tổn thất tương ứng với mức độ thiệt hại do Khách hàng gây ra.
            </li>
            <li>
                Bưu gửi đã được phát và Người nhận không có ý kiến khi nhận Bưu gửi.
            </li>
            <li>
                Các trường hợp bất khả kháng theo quy định của Luật Việt Nam.
            </li>
            <li>
                Trường hợp Khách hàng có yêu cầu bổ sung thêm thông tin ID nhân viên của 
                HPship (sau đây gọi chung là “ID Nhân Viên”) vào tài khoản đăng nhập để tạo 
                đơn hàng của Khách hàng (sau đây gọi chung là “Tài Khoản Tạo Đơn Hàng”) 
                trên Hệ thống của HPship thì Khách hàng đồng ý rằng:
                <li>
                    Khách hàng sẽ miễn trừ cho HPship toàn bộ trách nhiệm phát sinh từ 
                    hoặc liên quan đến việc khiếu kiện, khiếu nại về các hành vi được 
                    thao tác qua ID Nhân Viên liên quan đến việc tạo đơn hàng trên 
                    Hệ thống của HPship thông qua Tài Khoản Tạo Đơn Hàng – bao gồm nhưng 
                    không giới hạn các vấn đề liên quan đến việc bảo mật thông tin 
                    của Khách hàng, các thông tin liên quan đến đơn hàng, việc tạo đơn 
                    hàng ảo…
                </li>        
                <li>
                    Trường hợp phát sinh bất kỳ vấn đề hoặc hành vi vi phạm pháp luật 
                    nào phát sinh từ hoặc liên quan đến ID Nhân Viên dẫn đến ảnh hưởng 
                    trực tiếp hoặc gián tiếp đến Khách hàng và/hoặc bên thứ ba thì sẽ 
                    do nhân viên đó chịu trách nhiệm trực tiếp trước pháp luật và/hoặc 
                    bên bị thiệt hại.
                </li>
                <li>
                    Khách hàng sẽ chịu toàn bộ trách nhiệm liên quan đến các thao 
                    tác từ Tài Khoản Tạo Đơn Hàng trên Hệ thống, kể cả thao tác 
                    trực tiếp từ Khách hàng hay từ ID Nhân Viên – bao gồm nhưng không 
                    giới hạn việc tạo, quản lý, kiểm tra đơn hàng, các vấn đề về bảo 
                    mật liên quan đến đơn hàng… Để tránh hiểu lầm, HPship sẽ không chịu 
                    bất kỳ trách nhiệm nào phát sinh từ hoặc liên quan đến Tài Khoản 
                    Tạo Đơn Hàng thông qua ID Nhân Viên.
                </li>
            </li>
        </ul>
        </div>
</body>
</html>