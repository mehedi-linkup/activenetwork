<style>
    .container {
        width: 80%;
        margin: 0px auto;
    }
    .custom-row {
        width: 100%;
        display: block;
    }

    .print-btn a{
        background: #CFD8DC;
        display: inline-block;
        padding: 3px 13px;
        border-radius: 5px;
        color: #000 !important;
    }
    .print-btn a:hover {
        background: #B0BEC5;
    }
    .invoice-title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 15px;
        padding: 5px;
        border-top: 1px dotted #454545;
        border-bottom: 1px dotted #454545;
    }
    .col-xs-12 {
        width: 100%;
    }
    .col-xs-10 {
        width: 80%;
        float: left;
    }
    .col-xs-9 {
        width: 70%;
        float: left;
    }
    .col-xs-7 {
        width: 60%;
        float: left;
    }
    .col-xs-6 {
        width: 50%;
        float: left;
    }
    .col-xs-5 {
        width: 40%;
        float: left;
    }
    .col-xs-4 {
        width: 35%;
        float: left;
    }
    .col-xs-3 {
        width: 30%;
        float: left;
    }
    .col-xs-2 {
        width: 20%;
        float: left;
    }
    .b-text {
        font-weight: 500;
        font-size: 15px;
    }
    .normal-text {
        font-size: 14px;
        margin: 0px;
    }
    .invoice-details {
        width: 100%;
        border-collapse: collapse;
        border:1px solid #ccc;
    }
    .invoice-details thead {
        font-weight: 500;
        text-align:center;
    }
    .invoice-details tbody td{
        padding: 0px 5px;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .line {
        border-bottom: 1px solid #ccc;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .paid-text {
        padding:30px 0px;
    }
    .mt-60 {
        margin-top: 60px;
    }
    .mr-20 {
        margin-right: 20px;
    }
    .ml-20 {
        margin-left: 20px;
    }
    .ft-fiext {
        position: fixed;
        bottom: 0;
    }
    .cls {
        clear: both;
    }
</style>
<?php $info = $this->db->query("select * from tbl_profile")->row();?>
<div id="app">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="custom-row">
                <div class="col-xs-12">
                    <span class="print-btn"><a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a></span>
                </div>
            </div>
            <div id="invoiceContent">
                <div class="custom-row">
                    <div class="invoice-title">
                        Purchase Invoice
                    </div>
                </div>
                <div class="custom-row">
                    <div class="col-xs-7">
                        <strong class="b-text">Supplier Id:</strong> <span class="normal-text"><?php echo $purchase->code?></span><br>
                        <strong class="b-text">Supplier  Name:</strong> <span class="normal-text"><?php echo $purchase->name?></span><br>
                        <strong class="b-text">Supplier  Address:</strong> <span class="normal-text"><?php echo $purchase->address ?></span><br>
                        <strong class="b-text">Supplier  Mobile:</strong> <span class="normal-text"><?php echo $purchase->mobile?></span>
                    </div>
                    <div class="col-xs-5 text-right">
                        <strong class="b-text">Purchase by:</strong> <span class="normal-text"><?php echo $purchase->full_name?></span><br>
                        <strong class="b-text">Invoice No:</strong> <span class="normal-text"><?php echo $purchase->invoice_id ?></span><br>
                        <strong class="b-text">Purchase Date:</strong> <span class="normal-text">{{ '<?php echo $purchase->added_date ?>' | formatDateTime('DD-MM-YYYY h:mm a') }}</span>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="custom-row">
                    <div class="line">&nbsp;</div>
                </div>
                <div class="custom-row">
                    <div class="col-xs-12">
                        <table class="invoice-details" border="1px solid #ccc;">
                            <thead>
                                <tr>
                                    <td>Sl.</td>
                                    <td colspan="2">Description</td>
                                    <td>Quantity</td>
                                    <td>Pur. Rate</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $j = 1;
                                    foreach($products as $product){
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $j++ ?></td>
                                    <td colspan="2"><?php echo $product->code . ' , ' . $product->product_name?></td>
                                    <td class="text-right"><?php echo $product->quantity?></td>
                                    <td class="text-right" width="20%"><?php echo $product->purchase_rate ?></td>
                                    <td class="text-right" width="20%"><?php echo $product->purchase_total?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="col-xs-9">
                        <div class="paid-text">
                            <strong class="b-text">Paid in Words:</strong> <span class="normal-text">{{ convertNumberToWords(<?php echo $purchase->paid?>) }}</span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <table width="100%">
                            <tr>
                                <td width="40%" class="b-text">Sub Total :</td>
                                <td class="text-right"><?php echo $purchase->sub_total?></td>
                            </tr>
                            <tr>
                                <td width="40%" class="b-text">Vat :</td>
                                <td class="text-right"><?php echo $purchase->vat?></td>
                            </tr>
                            <tr>
                                <td width="45%" class="b-text">Discount :</td>
                                <td class="text-right"><?php echo $purchase->discount?></td>
                            </tr>
                            <tr>
                                <td width="45%" class="b-text">Others Cost :</td>
                                <td class="text-right"><?php echo $purchase->others?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border-bottom: 1px solid rgb(204, 204, 204);"></td>
                            </tr>
                            <tr>
                                <td width="45%" class="b-text">Total Amount:</td>
                                <td class="text-right"><?php echo $purchase->total?></td>
                            </tr>
                            <tr>
                                <td width="45%" class="b-text">Paid Amount:</td>
                                <td class="text-right"><?php echo $purchase->paid?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border-bottom: 1px solid rgb(204, 204, 204);"></td>
                            </tr>
                            <tr>
                                <td width="45%" class="b-text">Due Amount:</td>
                                <td class="text-right"><?php echo $purchase->due?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="col-xs-12">
                        <p style="margin-top: 25px"><strong>Note : </strong> <?php echo $purchase->note?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/backend/js/vue.js')?>"></script>
<script src="<?php echo base_url('assets/backend/js/axios.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    const app = new Vue({
        el: '#app',
        data: {

        },
        
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },

        created() {
            this.setStyle();
        },

        methods: {
            convertNumberToWords(amountToWord) {
                var words = new Array();
                words[0] = '';
                words[1] = 'One';
                words[2] = 'Two';
                words[3] = 'Three';
                words[4] = 'Four';
                words[5] = 'Five';
                words[6] = 'Six';
                words[7] = 'Seven';
                words[8] = 'Eight';
                words[9] = 'Nine';
                words[10] = 'Ten';
                words[11] = 'Eleven';
                words[12] = 'Twelve';
                words[13] = 'Thirteen';
                words[14] = 'Fourteen';
                words[15] = 'Fifteen';
                words[16] = 'Sixteen';
                words[17] = 'Seventeen';
                words[18] = 'Eighteen';
                words[19] = 'Nineteen';
                words[20] = 'Twenty';
                words[30] = 'Thirty';
                words[40] = 'Forty';
                words[50] = 'Fifty';
                words[60] = 'Sixty';
                words[70] = 'Seventy';
                words[80] = 'Eighty';
                words[90] = 'Ninety';
                let amount = amountToWord == null ? '0.00' : amountToWord.toString();
                var atemp = amount.split(".");
                var number = atemp[0].split(",").join("");
                var n_length = number.length;
                var words_string = "";
                if (n_length <= 9) {
                    var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                    var received_n_array = new Array();
                    for (var i = 0; i < n_length; i++) {
                        received_n_array[i] = number.substr(i, 1);
                    }
                    for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                        n_array[i] = received_n_array[j];
                    }
                    for (var i = 0, j = 1; i < 9; i++, j++) {
                        if (i == 0 || i == 2 || i == 4 || i == 7) {
                            if (n_array[i] == 1) {
                                n_array[j] = 10 + parseInt(n_array[j]);
                                n_array[i] = 0;
                            }
                        }
                    }
                    let value = "";
                    for (var i = 0; i < 9; i++) {
                        if (i == 0 || i == 2 || i == 4 || i == 7) {
                            value = n_array[i] * 10;
                        } else {
                            value = n_array[i];
                        }
                        if (value != 0) {
                            words_string += words[value] + " ";
                        }
                        if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Crores ";
                        }
                        if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Lakhs ";
                        }
                        if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Thousand ";
                        }
                        if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                            words_string += "Hundred and ";
                        } else if (i == 6 && value != 0) {
                            words_string += "Hundred ";
                        }
                    }
                    words_string = words_string.split("  ").join(" ");
                }
                return words_string + ' only';
            },

            setStyle(){
                this.style = document.createElement('style');
                this.style.innerHTML = `
                    .custom-row {
                        width: 100%;
                        display: block;
                    }
                    .print-btn a{
                        background: #CFD8DC;
                        display: inline-block;
                        padding: 3px 13px;
                        border-radius: 5px;
                        color: #000 !important;
                    }
                    .print-btn a:hover {
                        background: #B0BEC5;
                    }
                    .invoice-title {
                        text-align: center;
                        font-weight: bold;
                        font-size: 15px;
                        margin-bottom: 15px;
                        padding: 5px;
                        border-top: 1px dotted #454545;
                        border-bottom: 1px dotted #454545;
                    }
                    .col-xs-12 {
                        width: 100%;
                    }
                    .col-xs-10 {
                        width: 80%;
                        float: left;
                    }
                    .col-xs-9 {
                        width: 70%;
                        float: left;
                    }
                    .col-xs-7 {
                        width: 60%;
                        float: left;
                    }
                    .col-xs-6 {
                        width: 50%;
                        float: left;
                    }
                    .col-xs-5 {
                        width: 40%;
                        float: left;
                    }
                    .col-xs-4 {
                        width: 35%;
                        float: left;
                    }
                    .col-xs-3 {
                        width: 30%;
                        float: left;
                    }
                    .col-xs-2 {
                        width: 20%;
                        float: left;
                    }
                    .b-text {
                        font-weight: 500;
                        font-size: 15px;
                    }
                    .normal-text {
                        font-size: 14px;
                        margin: 0px;
                    }
                    .invoice-details {
                        width: 100%;
                        border-collapse: collapse;
                        border:1px solid #ccc;
                    }
                    .invoice-details thead {
                        font-weight: 500;
                        text-align:center;
                    }
                    .invoice-details tbody td{
                        padding: 0px 5px;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .text-right {
                        text-align: right;
                    }
                    .line {
                        border-bottom: 1px solid #ccc;
                        margin-top: 15px;
                        margin-bottom: 15px;
                    }
                    .paid-text {
                        padding:30px 0px;
                    }
                    .mt-60 {
                        margin-top: 60px;
                    }
                    .mr-20 {
                        margin-right: 20px;
                    }
                    .ml-20 {
                        margin-left: 20px;
                    }
                    .ft-fiext {
                        position: fixed;
                        bottom: 0;
                    }
                    .cls {
                        clear: both;
                    }
                `;
                document.head.appendChild(this.style);
            },

            async print(){
                let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
                let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
                let ImagePath ='<?php echo base_url(). "assets/backend/images/". $info->com_logo ?>';
                let companyName = '<?php echo $info->com_name?>';
                let address = '<?php echo $info->com_address?>';
                let contactUs = '<?php echo $info->com_phone?>';
                let email = '<?php echo $info->com_email?>';
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Investigation Payment Slip</title>
                        <style>
                        </style>
                    </head>
                    <body>
                        <div>
                            <div class="container">
                                <table style="width:100%;">
                                    <thead>
                                        <tr>
                                            <td>
                                                <div class="custom-row">
                                                    <div class="col-xs-2">
                                                        <img src="`+ImagePath+`" alt="Logo" style="height:90px; width:90%;object-fit: contain;" />
                                                    </div>
                                                    <div class="col-xs-10">
                                                        <strong style="font-size:18px;">${companyName}</strong><br>
                                                        <p style="white-space:pre-line;margin:0px">Address : ${address}</p>
                                                        <p style="margin:0px">Mobile : ${contactUs}</p>
                                                        <p style="margin:0px">E-mail : ${email}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="custom-row">
                                                    <div class="col-xs-12">
                                                        ${invoiceContent}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <div style="width:100%;height:50px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div style="position:fixed;left:0;bottom:10px;width:100%;">
                                    <div class="custom-row">
                                        <div class="col-xs-6">
                                            <p class="mt-60">
                                                <span style="text-decoration:overline;font-weight:500;font-size:14px">Received By(Supplie)</span>
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="mt-60">
                                                <p class="text-right">
                                                    <span style="text-decoration:overline;font-weight:500;font-size:14px">Authorized Signature</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        
                    </body>
                    </html>
                `);
                
                let invoiceStyle = printWindow.document.createElement('style');
                invoiceStyle.innerHTML = this.style.innerHTML;
                printWindow.document.head.appendChild(invoiceStyle);
                printWindow.moveTo(0, 0);
                
                printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            }
        }
    })
</script>