<style>
.purchase-box {
    background: #fff;
    border: 1px solid #ddd;
    border-bottom: none;
    padding: 10px;
    clear: both;
    width: 100%;
    height: 100%;
    /* overflow: hidden; */
    color: #000;
    /* font-weight: bolder; */
    font-size: 16px;
}

.purchase-table {
    background: #fff;
    border: 1px solid #ddd;
    border-top:none;
    clear: both;
    width: 100%;
    height: 100%;
    overflow: hidden;
    color: #000;
    font-size: 16px; 
}
table {
    margin-bottom: 5px !important;
}
table tbody td {
    padding: 3px !important;
}
table thead th {
    padding: 3px !important;
    text-align: center !important;
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
</style>
<?php $info = $this->db->query("select * from tbl_profile")->row();?>
<div class="content-section" id="app">
    <div class="container">
        <div class="row">
            <form  method="post" @submit.prevent="stockRecord">
                <div class="col-md-12">
                    <div class="purchase-box row">
                        <div class="col-md-3">
                            <label for="type" class="col-md-2">Type</label>
                            <div class="col-md-10">
                                <v-select v-bind:options="types" v-model="type" @input="onChangeType"></v-select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="searchType == 'By Category'">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3"><span style="font-size: 14px;">Categories</span> </label>
                            <div class="col-md-9 col-sm-9 col-lg-9">
                                <select class="form-control" v-if="categories.length == 0"></select>
                                <v-select v-bind:options="categories" v-model="category" label="category_name" v-if="categories.length > 0"></v-select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="searchType == 'By Metarial'">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3"><span style="font-size: 14px;">Metarial</span> </label>
                            <div class="col-md-9 col-sm-9 col-lg-9">
                                <select class="form-control" v-if="products.length == 0"></select>
                                <v-select v-bind:options="products" v-model="product" label="display_text" v-if="products.length > 0"></v-select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <input type="submit" id="submit" value="Search" class="btn btn-info btn-block">
                        </div>
                        <br>
                    </div>
                    <div class="purchase-table row" v-if="show">
                        <div class="col-xs-12">
                            <span class="print-btn"><a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a></span>
                        </div>
                        <div class="col-md-12" id="stockContent" style="margin-top: 5px;">
                            <table class="invoice-details" border="1px solid #ccc;">
                                <thead>
                                    <th>Sl</th>
                                    <th>Code</th>
                                    <th>Metarial</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>purchase_rate</th>
                                    <th>Current Quantity</th>
                                    <th>Stock Value</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(stock, ind) in stocks" :key="ind">
                                        <td class="text-center">{{ ind + 1 }}</td>
                                        <td class="text-center">{{ stock.code }}</td>
                                        <td class="text-center">{{ stock.product_name }}</td>
                                        <td class="text-center">{{ stock.category }}</td>
                                        <td class="text-center">{{ stock.unit }}</td>
                                        <td class="text-right">{{ stock.purchase_rate }}</td>
                                        <td class="text-right">{{ stock.stockQunatity }}</td>
                                        <td class="text-right">{{ (stock.purchase_rate * stock.stockQunatity).toFixed(2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">Total Value</td>
                                        <td class="text-right">{{ subTotal.toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/v-select.css')?>">
<script src="<?php echo base_url('assets/backend/js/vue.js')?>"></script>
<script src="<?php echo base_url('assets/backend/js/axios.js')?>"></script>
<script src="<?php echo base_url('assets/backend/js/v-select.js')?>"></script>
<script>
Vue.component('v-select', VueSelect.VueSelect);
const app = new Vue({
    el: '#app',
    data: {
        searchType: null,
        stockReport: {
            category_id: null,
            product_id: null
        },
        stocks: [],
        categories: [],
        category: null,
        products: [],
        product: null,
        type: null,
        types: ['Total Stock', 'By Category', 'By Metarial'],
        show: false
    },

    watch: {
        type(type) {
            if(type == null) return
            this.searchType = type
        },

        category(category) {
            if(category == null) return
            this.stockReport.category_id = category.id
        },

        product(product) {
            if(product == null) return
            this.stockReport.product_id = product.id
        }
    },

    computed: {
        subTotal() {
           return this.stocks.reduce((p, c) => { return +p + +(c.stockQunatity) * c.purchase_rate }, 0) 
        }
    },

    created() {
        this.getCateogries();
        this.getProducts();
        this.setStyle();
    },

    methods: {
        async getCateogries() {
            await axios.get('get-categories')
            .then(res => {
                this.categories = res.data;
            })
        },

        async getProducts() {
            await axios.get('get-products')
            .then(res => {
                this.products = res.data;
            })
        },

        async stockRecord() {
            if(this.searchType == null) {
                alert('Select search type');
                return;
            }
            await axios.post('get-stock-report', { ...this.stockReport})
            .then(res => {
                // console.log(res.data)
                this.stocks = res.data
            })
            this.show = true;
        },

        onChangeType() {
            this.product = null;
            this.category = null;
            this.stockReport.category_id = null;
            this.stockReport.product_id = null;
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
                        padding: 2px 5px;
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
            let invoiceContent = document.querySelector('#stockContent').innerHTML;
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