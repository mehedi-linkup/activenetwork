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
.table {
    margin-bottom: 5px !important;
}
.table tbody td {
    padding: 3px !important;
}
.table thead th {
    padding: 3px !important;
    text-align: center;
}
</style>
<div class="content-section" id="app">
    <div class="container">
        <div class="row">
            <form  method="post" @submit.prevent="srarchPurchaseRecord">
                <div class="col-md-12">
                    <div class="purchase-box row">
                        <div class="col-md-3">
                            <label for="type" class="col-md-2">Type</label>
                            <div class="col-md-10">
                                <v-select v-bind:options="types" v-model="type" @input="onChangeType"></v-select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="searchType == 'By Supplier'" style="padding: 0px;">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Supplier </label>
                            <div class="col-md-9 col-sm-9 col-lg-9">
                                <select class="form-control" v-if="suppliers.length == 0"></select>
                                <v-select v-bind:options="suppliers" v-model="supplier" label="display_text" v-if="suppliers.length > 0"></v-select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="searchType == 'By Employee'" style="padding: 0px;">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3"><span style="font-size: 14px;">Employee</span> </label>
                            <div class="col-md-9 col-sm-9 col-lg-9">
                                <select class="form-control" v-if="employees.length == 0"></select>
                                <v-select v-bind:options="employees" v-model="employee" label="display_text" v-if="employees.length > 0"></v-select>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding: 0px;">
                            <div class="col-md-2" style="padding: 0px;">From</div>
                            <div class="col-md-4" style="padding: 0px;">
                                <input type="date" v-model="purchaseRecord.dateFrom" class="form-control" style="width: 140px !important; margin-left: -15px; padding:0px">
                            </div>
                            <div class="col-md-2">To</div>
                            <div class="col-md-4" style="padding: 0px;">
                                <input type="date" v-model="purchaseRecord.dateTo" class="form-control" style="width: 140px !important; margin-left: -15px; padding:0px">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <input type="submit" id="submit" value="Search" class="btn btn-info btn-sm btn-block">
                        </div>
                        <br>
                    </div>
                    
                    <div class="purchase-table row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Sl</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Sup. Name</th>
                                    <th>Sub Total</th>
                                    <th>Vat</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, ind) in records" :key="ind">
                                        <td class="text-center">{{ ind + 1 }}</td>
                                        <td class="text-center">{{ record.invoice_id }}</td>
                                        <td class="text-center">{{ record.purchase_date }}</td>
                                        <td class="text-center">{{ record.name }}</td>
                                        <td class="text-right">{{ record.sub_total }}</td>
                                        <td class="text-right">{{ record.vat }}</td>
                                        <td class="text-right">{{ record.discount }}</td>
                                        <td class="text-right">{{ record.total }}</td>
                                        <td class="text-right">{{ record.paid }}</td>
                                        <td class="text-right">{{ record.due }}</td>
                                        <td class="text-center">
                                            <a :href="`<?php echo base_url() . 'purchase-invoice/' ?>${record.id}`" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i></a>
                                        </td>
                                    </tr>
                                    <tr v-if="records.length == 0">
                                        <td colspan="11" class="text-center">No purchase records </td>
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
        purchaseRecord: {
            dateFrom: new Date().toISOString().substr(0, 10),
            dateTo: new Date().toISOString().substr(0, 10),
            supplier_id: null,
            employee_id: null,
        },
        records: [],
        suppliers: [],
        supplier: null,
        employees: [],
        employee: null,
        type: null,
        types: ['All', 'By Supplier', 'By Employee']
    },

    watch: {
        type(type) {
            if(type == null) return
            this.searchType = type
        },
        supplier(supplier){
            if (supplier == null) return
            this.purchaseRecord.supplier_id = supplier.id;        
        },

        employee(employee) {
            if(employee == null) return
            this.purchaseRecord.employee_id = employee.id
        }
    },

    created() {
        this.getSupplier();
        this.getEmployess();
    },

    methods: {
        async getSupplier() {
            await axios.get('get-suppliers')
            .then(res => {
               this.suppliers = res.data
            })
        },

        async getEmployess() {
            await axios.get('get-employees')
            .then(res => {
                this.employees = res.data;
            })
        },

        async srarchPurchaseRecord() {
            if(this.searchType == null) {
                alert('Select search type')
                return;
            }
            await axios.post('purchase-report', { ...this.purchaseRecord})
            .then(res => {
                // console.log(res.data)
                this.records = res.data
            })

        },

        onChangeType() {
            this.supplier = null;
            this.employee = null;
            this.purchaseRecord.supplier_id = null;
            this.purchaseRecord.employee_id = null;
        }
    }
})
</script>