<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
</head>
<style>

    page {
        background: white;
        display: block;
        margin: 0 auto;

    }

    page[size="A4"] {
        width: 21cm;
        height: 26.7cm;
    }

    page[size="A4"][layout="portrait"] {
        width: 29.7cm;
        height: 21cm;
    }

    page[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }

    page[size="A3"][layout="portrait"] {
        width: 42cm;
        height: 29.7cm;
    }

    page[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }

    page[size="A5"][layout="portrait"] {
        width: 21cm;
        height: 14.8cm;
    }

    @media print {
        body, page {
            margin: 0;
            box-shadow: 0;
        }
    }

    .bill-order {
        text-align: center;
        text-transform: uppercase;
        font-size: 22px;
        color: #e91f6b
    }

    p {
        margin: 3px 0px;
        font-size: 12px;
    }

    h2 {
        margin: 5px
    }
    .center{
        text-align: center;
    }
</style>
<body>

<page size="A4">
     <div style="font-size:12px; font-family:verdana, sans-serif; min-height:495px; margin-top:10px">
         <div>
             <p>Công ty thành viên Simply ART</p>
             <p>Trung tâm Simply ART - Quận 1</p>
             <p>Địa chỉ</p>
         </div>
         <h2 class="bill-order">BIÊN LAI THU TIỀN</h2>
         <div class="center">
             Số: <?php echo $invoice_number;?>
         </div>
         <div>
             <p>
                 Tên học viên:
             </p>
             <p>
                 Tên phụ huynh:
             </p>
             <p>
                 Điện thoại:
             </p>
             <p>
                 Email:
             </p>
         </div>

        <table border="1"
               style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;"
               cellpadding="5" cellspacing="0">
            <thead>
            <tr style="background-color: #faebd7;">
                <th width="10%" class="packing">
                    STT
                </th>
                <th width="30%" class="packing">
                    Khoản Thu
                </th>
                <th width="30%" class="packing">
                    Mức Phí
                </th>
                <th class="packing">
                    Thanh Toán
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $total_price = 0;$count_index = 1;foreach($detail_invoice as $item){
                $flag_sale_off = false;
                if($item->price_sale > 0 && $item->price_sale < $item->price){
                    $price = $item->price_sale;
                    $flag_sale_off = true;
                }else{
                    $price = $item->price;
                }
                $total_price = $total_price + $price;
            ?>
                <tr>
                    <td style="text-align:center;">
                        <?php echo $count_index++;?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $item->course_title;?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo format_currency($price);?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo format_currency($price);?>
                    </td>

                </tr>
            <?php }?>
            <tr style="background-color: #faebd7;">
                <td style="text-align:center; color: red;" colspan="2"><b>Tổng tiền</b></td>
                <td style="text-align:center;"><?php echo format_currency($total_price);?></td>
                <td style="text-align:center;"><?php echo format_currency($total_price);?></td>
            </tr>
            </tbody>
        </table>
         <br />
         <div>
             <p>
                 Tổng tiền thanh toán: <?php echo format_currency($total_price);?>
             </p>
             <p>
                 Viết bằng chữ: <?php echo convert_money_number_to_words($total_price);?>
             </p>
         </div>
        <table style="border:0px solid #000; width:100%; font-size:13px; margin-top:10px; margin-right: 20px"
               cellpadding="5" cellspacing="0" ;>
            <tr>
                <!--<td colspan="2" style="vertical-align:top; text-align: right">
                    <i>Ngày <u> &nbsp; &nbsp; &nbsp; &nbsp; </u> tháng <u> &nbsp; &nbsp; &nbsp; &nbsp; </u> năm <u>
                            &nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u> &nbsp; &nbsp; &nbsp;</i>
                </td>-->
                <td colspan="2" style="vertical-align:top; text-align: right">
                    <i>Ngày <?php echo date('d');?> tháng <?php echo date('m');?> năm <?php echo date('Y');?></i>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                    <b>Người nộp tiền</b><br>
                    <i>(Ký, họ tên)</i>
                </td>
                <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                    <b>Người thu tiền</b><br>
                    <i>(Ký, họ tên)</i>
                </td>
            </tr>
        </table>

    </div>

    <div style="font-size:12px; font-family:verdana, sans-serif; min-height:450px; margin-top:20px">
        <div>
            <p>Công ty thành viên Simply ART</p>
            <p>Trung tâm Simply ART - Quận 1</p>
            <p>Địa chỉ</p>
        </div>
        <h2 class="bill-order">BIÊN LAI THU TIỀN</h2>
        <div class="center">
            Số: 180001
        </div>
        <div>
            <p>
                Tên học viên:
            </p>
            <p>
                Tên phụ huynh:
            </p>
            <p>
                Điện thoại:
            </p>
            <p>
                Email:
            </p>
        </div>

        <table border="1"
               style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;"
               cellpadding="5" cellspacing="0">
            <thead>
            <tr style="background-color: #faebd7;">
                <th width="10%" class="packing">
                    STT
                </th>
                <th width="30%" class="packing">
                    Khoản Thu
                </th>
                <th width="30%" class="packing">
                    Mức Phí
                </th>
                <th class="packing">
                    Thanh Toán
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $total_price = 0;$count_index = 1;foreach($detail_invoice as $item){
                $flag_sale_off = false;
                if($item->price_sale > 0 && $item->price_sale < $item->price){
                    $price = $item->price_sale;
                    $flag_sale_off = true;
                }else{
                    $price = $item->price;
                }
                $total_price = $total_price + $price;
                ?>
                <tr>
                    <td style="text-align:center;">
                        <?php echo $count_index++;?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $item->course_title;?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo format_currency($price);?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo format_currency($price);?>
                    </td>

                </tr>
            <?php }?>
            <tr style="background-color: #faebd7;">
                <td style="text-align:center; color: red;" colspan="2"><b>Tổng tiền</b></td>
                <td style="text-align:center;"><?php echo format_currency($total_price);?></td>
                <td style="text-align:center;"><?php echo format_currency($total_price);?></td>
            </tr>
            </tbody>
        </table>
        <br />
        <div>
            <p>
                Tổng tiền thanh toán: <?php echo format_currency($total_price);?>
            </p>
            <p>
                Viết bằng chữ: <?php echo convert_money_number_to_words($total_price);?>
            </p>
        </div>
        <table style="border:0px solid #000; width:100%; font-size:13px; margin-top:10px; margin-right: 20px"
               cellpadding="5" cellspacing="0" ;>
            <tr>
                <!--<td colspan="2" style="vertical-align:top; text-align: right">
                    <i>Ngày <u> &nbsp; &nbsp; &nbsp; &nbsp; </u> tháng <u> &nbsp; &nbsp; &nbsp; &nbsp; </u> năm <u>
                            &nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u> &nbsp; &nbsp; &nbsp;</i>
                </td>-->
                <td colspan="2" style="vertical-align:top; text-align: right">
                    <i>Ngày <?php echo date('d');?> tháng <?php echo date('m');?> năm <?php echo date('Y');?></i>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                    <b>Người nộp tiền</b><br>
                    <i>(Ký, họ tên)</i>
                </td>
                <td colspan="1" style="width:50%; vertical-align:top; text-align: center">
                    <b>Người thu tiền</b><br>
                    <i>(Ký, họ tên)</i>
                </td>
            </tr>
        </table>

    </div>
</page>
</body>
</html>
