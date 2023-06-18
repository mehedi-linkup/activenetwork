<style>
    .v-select{
		margin-bottom: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
    .btn-primary:hover {
        border: 1px solid blue !important;
        background: blue;
        color: #fff;
    }
</style>
<div id="customerLedger">
    <div class="row" style="border-bottom: 1px solid #ccc;background:#fff;padding-bottom:5px;padding-top: 5px">
        <div>
            <label class="col-sm-1 col-sm-offset-1 control-label no-padding-right"> Customer </label>
            <div class="col-sm-3">
                <v-select v-bind:options="customers" v-model="selectedCustomer" label="display_text"></v-select>
            </div>
        </div>

        <div>
            <label class="col-sm-1 control-label no-padding-right"> Date from </label>
            <div class="col-sm-2">
                <input type="date" class="form-control" v-model="dateFrom">
            </div>
            <label class="col-sm-1 control-label no-padding-right text-center" style="width:30px"> To </label>
            <div class="col-sm-2">
                <input type="date" class="form-control" v-model="dateTo">
            </div>
        </div>

        <div>
            <div class="col-sm-1">
                <input type="button" class="btn btn-primary" value="Show" v-on:click="getReport" style="margin-top:0px;border:0px;height:26px;padding-top:2px;">
            </div>
        </div>
        
    </div>
    <div class="row" style="background: #fff;margin-top:15px;padding-top:15px;display: none" :style="{display: payments.length > 0 ? '' : 'none'}">
        <div class="col-md-10 col-md-offset-1">
            <a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                <i class="fa fa-print"></i> Print
            </a>

            <div class="table-responsive" id="reportTable">
                <table class="invoice-details" border="1px solid #ccc;">
                    <thead>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Bill</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </thead>
                    <tbody>
                        <tr v-for="(ledger, sl) in payments">
                            <td>{{ sl + 1 }}</td>
                            <td>{{ ledger.date }}</td>
                            <td style="text-align: left;">{{ ledger.description }}</td>
                            <td>{{ ledger.bill }}</td>
                            <td>{{ ledger.paid }}</td>
                            <td>{{ ledger.due }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                            <td><strong>{{ payments.reduce((p, c) => {return +p + +c.bill}, 0).toFixed(2) }}</strong></td>
                            <td><strong>{{ payments.reduce((p, c) => {return +p + +c.paid}, 0).toFixed(2) }}</strong></td>
                            <td><strong>{{ payments.reduce((p, c) => {return +p + +c.due}, 0).toFixed(2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
        el: '#customerLedger',
        data: {
            customers: [],
            selectedCustomer: null,
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
            payments: [],
        },
        created() {
            this.getCustomers();
            this.setStyle();
        },
        methods: {
            getCustomers() {
                axios.get('/get-customers')
                .then(res => {
                    this.customers = res.data;
                })
            },
            getReport() {
                if(this.selectedCustomer == null) {
                    alert('Select customer');
                    return;
                }

                let filter = {
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                    customerId: this.selectedCustomer.id
                }

                axios.post('/get-customer-ledger', filter)
                .then(res => {
                    this.payments = res.data;
                })
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
                let invoiceContent = document.querySelector('#reportTable').innerHTML;
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
                        <title>Customer Ledger</title>
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
                                                        <h3 style="text-align:center">Customer Ledger</h3>
                                                    </div>
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