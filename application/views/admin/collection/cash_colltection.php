<style>
    #customerLedger {
        background: #fff;
        padding: 10px 20px;
    }
    .btn-primary:hover {
        border: 1px solid blue !important;
        background: blue;
        color: #fff;
    }

    .account-section {
        display: flex;
        border: none;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .account-section .col1 {
        background-color: #82a253;
        color: white;
        flex: 1;
        text-align: center;
        padding: 10px;
    }
    .account-section .col2 {
        background-color: #edf3e2;
        flex: 2;
        padding: 10px;
        align-items: center;
        text-align: center;
    }
    .account-section h3 {
        margin: 10px 0;
        padding: 0;
    }
    .account-section h4 {
        margin: 0;
        margin-top: 3px;
    }
</style>
<div id="customerLedger">
    <div class="row" style="border-bottom: 1px solid #ccc;background:#fff;padding-bottom:5px;padding-top: 5px">
        <div>
            <label class="col-sm-1 col-sm-offset-3 control-label no-padding-right"> Date from </label>
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
    <div class="row" style="margin-top: 15px">
        <div class="col-md-4">
            <div class="account-section">
                <div class="col1">
                    <i class="fa fa-sign-in fa-2x"></i> <br>
                    <h4>Cash In</h4>
                </div>
                <div class="col2">
                    <h3>BDT {{ cashIn | decimal }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="account-section">
                <div class="col1">
                    <i class="fa fa-sign-out fa-2x"></i> <br>
                    <h4>Cash Out</h4>
                </div>
                <div class="col2">
                    <h3>BDT {{ cashOut | decimal }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="account-section">
                <div class="col1">
                    <i class="fa fa-money fa-2x"></i> <br>
                    <h4>Balance</h4>
                </div>
                <div class="col2">
                    <h3>BDT {{ balance | decimal }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- customer payment -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Customer Payment Collection</th>
                    </tr>
                    <tr>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Received</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: customerReceive.length > 0 ? '' : 'none'}">
                    <tr v-for="customer in customerReceive">
                        <td>{{ customer.coll_code }}</td>
                        <td>{{ customer.update_date }}</td>
                        <td>{{ customer.cust_name }}</td>
                        <td style="text-align:right;">{{ customer.coll_amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="customerReceive.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: customerReceive.length > 0 ? '' : 'none'}">{{ totalCustomerReceived | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- cash receive -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Cash Received</th>
                    </tr>
                    <tr>
                        <th>Tnx. Id</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: cashReceived.length > 0 ? '' : 'none'}">
                    <tr v-for="trans in cashReceived">
                        <td>{{ trans.tr_id }}</td>
                        <td>{{ trans.tr_date }}</td>
                        <td>{{ trans.voucher_no }}</td>
                        <td style="text-align:right;">{{ trans.tr_amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="cashReceived.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: cashReceived.length > 0 ? '' : 'none'}">{{ totalCashReceiveAmount | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- service payment -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Service Payment</th>
                    </tr>
                    <tr>
                        <th>Tnx. Id</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: servicePayment.length > 0 ? '' : 'none'}">
                    <tr v-for="customer in servicePayment">
                        <td>{{ customer.coll_code }}</td>
                        <td>{{ customer.coll_date }}</td>
                        <td>{{ customer.cust_name }}</td>
                        <td style="text-align:right;">{{ customer.coll_amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="servicePayment.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: servicePayment.length > 0 ? '' : 'none'}">{{ totalServicePayment | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-6">
            <!-- purchase -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Purchase</th>
                    </tr>
                    <tr>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">
                    <tr v-for="purchase in purchases">
                        <td>{{ purchase.invoice_id }}</td>
                        <td>{{ purchase.purchase_date }}</td>
                        <td>{{ purchase.name }}</td>
                        <td style="text-align:right;">{{ purchase.paid }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="purchases.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">{{ totalPurchase | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- supplier payment -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Supplier Payment</th>
                    </tr>
                    <tr>
                        <th>Serial</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: supplierPayment.length > 0 ? '' : 'none'}">
                    <tr v-for="(supplier, sl) in supplierPayment">
                        <td>{{ sl + 1 }}</td>
                        <td>{{ supplier.name }}</td>
                        <td>{{ supplier.payment_date }}</td>
                        <td style="text-align:right;">{{ supplier.payment_amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="supplierPayment.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: supplierPayment.length > 0 ? '' : 'none'}">{{ totalSupplierPayment | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- cash paid -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Cash Payment</th>
                    </tr>
                    <tr>
                        <th>Tnx. Id</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: cashPaid.length > 0 ? '' : 'none'}">
                    <tr v-for="trans in cashPaid">
                        <td>{{ trans.tr_id }}</td>
                        <td>{{ trans.tr_date }}</td>
                        <td>{{ trans.voucher_no }}</td>
                        <td style="text-align:right;">{{ trans.tr_amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="cashPaid.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: cashPaid.length > 0 ? '' : 'none'}">{{ totalCashPaidAmount | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- salary payment -->
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr style="background: #dee4dc;">
                        <th colspan="4">Salary Payment</th>
                    </tr>
                    <tr>
                        <th>Serial</th>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display: salaryPayment.length > 0 ? '' : 'none'}">
                    <tr v-for="(salary, sl) in salaryPayment">
                        <td>{{ sl + 1 }}</td>
                        <td>{{ salary.payment_date }}</td>
                        <td>{{ salary.emp_name }}</td>
                        <td style="text-align:right;">{{ salary.payment_amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td style="text-align:right;">
                            <span v-if="salaryPayment.length == 0">0.00</span>
                            <span style="display:none;" v-bind:style="{display: salaryPayment.length > 0 ? '' : 'none'}">{{ totalSalaryPayment | decimal }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
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
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
            customerReceive: [],
            cashReceived: [],
            cashPaid: [],
            purchases: [],
            salaryPayment: [],
            servicePayment: [],
            supplierPayment: [],
        },
        filters: {
			decimal(value) {
				return value == null ? 0.00 : parseFloat(value).toFixed(2);
			}
		},
        computed: {
            totalCustomerReceived() {
                return this.customerReceive.reduce((p, c) => {return +p + +c.coll_amount}, 0)
            },
            totalCashReceiveAmount() {
                return this.cashReceived.reduce((p, c) => {return +p + +c.tr_amount}, 0)
            },
            totalCashPaidAmount() {
                return this.cashPaid.reduce((p, c) => {return +p + +c.tr_amount}, 0)
            },
            totalServicePayment() {
                return this.servicePayment.reduce((p, c) => {return +p + +c.call_amount}, 0)
            },
            totalSalaryPayment() {
                return this.salaryPayment.reduce((p, c) => {return +p + +c.payment_amount}, 0)
            },
            totalPurchase() {
                return this.purchases.reduce((p, c) => {return +p + +c.paid}, 0)
            },
            totalSupplierPayment() {
                return this.supplierPayment.reduce((p, c) => {return +p + +c.paid}, 0)
            },
            cashIn() {
                return (+this.totalCustomerReceived + +this.totalCashReceiveAmount + +this.totalServicePayment)
            },
            cashOut() {
                return +this.totalCashPaidAmount + +this.totalPurchase + +this.totalSalaryPayment + +this.totalSupplierPayment
            },
            balance() {
                return +this.cashIn - +this.cashOut
            }
        },
        created() {
        },
        methods: {
            getReport() {
                let filter = {
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }

                axios.post('/get-collection-statement', filter)
                .then(res => {
                    this.customerReceive = res.data.customerReceive;
                    this.cashReceived = res.data.cashReceived;
                    this.cashPaid = res.data.cashPaid;
                    this.purchases = res.data.purchases;
                    this.salaryPayment = res.data.salaryPayment;
                    this.supplierPayment = res.data.supplierPayment;
                })
            },
        }
    }) 
</script>