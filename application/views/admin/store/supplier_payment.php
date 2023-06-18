<style>
.content-section {
    background: #fff;
    border: 1px solid #ddd;
    border-bottom: none;
    padding: 10px;
    clear: both;
    width: 100%;
    height: 100%;
    overflow: hidden;
    color: #000;
    /* font-weight: bolder; */
    font-size: 16px;
}
.table.dataTable th.dt-center, table.dataTable td.dt-center, table.dataTable td.dataTables_empty {
    display: none !important;
}
hr {
		margin-top: 20px;
		margin-bottom: 20px;
		border: 0;
		border-top: 1px solid #d3d7df;
	}
</style>
<div class="content-section" id="app">
    <div class="container">
        <div class="row">
            <form id="supplierPaymentForm" method="post" ref="supplierPaymentForm" @submit.prevent="saveSupplierPayment">
                <div class="col-md-12">
                    <div class="purchase-box row">
                        <div class="col-md-4 col-sm-4 col-lg-4 col-md-offset-4">
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Supplier </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <select class="form-control" v-if="suppliers.length == 0"></select>
									<v-select v-bind:options="suppliers" v-model="supplier" label="display_text" v-if="suppliers.length > 0"></v-select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Due </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="due" name="due" id="due" class="form-control" style="margin-bottom: 3px;" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Date </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="supplierPayment.payment_date" name="payment_date" id="payment_date" class="form-control" style="margin-bottom: 3px;" require>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Description </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="supplierPayment.payment_note" name="payment_note" id="payment_note" class="form-control" style="margin-bottom: 3px;">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Amount </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="supplierPayment.payment_amount" name="payment_amount" id="payment_amount" class="form-control" style="margin-bottom: 3px;" require>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3"> </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="submit" id="submit" name="submit" class="btn btn-info btn-block" value="Save">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-stripted table-bordered" id="dataTable">
                    <thead>
                        <th>SL</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(supplier, ind) in payments" :key="ind">
                            <td>{{ ind + 1 }}</td>
                            <td>{{ supplier.code }}</td>
                            <td>{{ supplier.name }}</td>
                            <td>{{ supplier.payment_date }}</td>
                            <td class="text-right">{{ supplier.payment_amount }}</td>
                            <td>{{ supplier.payment_note }}</td>
                            <td class="text-center">
                            <a href="" @click.prevent="editSupplierPayment(supplier)"><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                            <a href="" @click.prevent="deleteSupplierPayment(supplier.id)"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
                            </td>
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
    el: '#app',
    data: {
        supplierPayment: {
            id: null,
            payment_date: new Date().toISOString().substr(0, 10),
            supplier_id: null,
            payment_amount: 0.00,
            payment_note: ''
        },
        due: null,
        payments: [],
        suppliers: [],
        supplier: null,
        show: false

    },

    watch: {
        supplier(supplier){
            if (supplier == null) return
            this.supplierPayment.supplier_id = supplier.id;

            axios.post('supplier-due', { supplierId: supplier.id})
            .then(res => {
                let supplier = res.data[0];
                this.due = supplier.due
                this.show = true
            })
        },
    },

    created() {
        this.getSupplier();
        this.getSupplierPayment();
    },

    methods: {
        async getSupplier() {
            await axios.get('get-suppliers')
            .then(res => {
               this.suppliers = res.data
            })
        },

        async getSupplierPayment() {
            await axios.get('get-supplier-payment')
            .then(res => {
                this.payments = res.data
            })
        },

        
        async saveSupplierPayment() {
            let url = 'save-supplier-payment';
            if(this.supplierPayment.id != null) {
                url = 'update-supplier-payment';
            }

            if(this.supplierPayment.supplier_id == null) {
                alert("Select supplier");
				return;
            }

            if(this.supplierPayment.payment_amount == 0) {
                alert("Supplier payment amount is not empty !");
				return;
            }

            await axios.post(url, { ...this.supplierPayment})
            .then(res => {
                let r = res.data;
                if(r.success){
                    alert(r.message);
                    this.resetForm();
                    location.reload();
                }
                else{
                    alert(r.message);
                }
            })

        },

        editSupplierPayment(supplierPayment) {
            Object.keys(this.supplierPayment).forEach(key => this.supplierPayment[key] = supplierPayment[key]);
            this.supplier = this.suppliers.find(item => item.id  == supplierPayment.supplier_id)
            this.supplierPayment.supplier_id = supplierPayment.supplier_id;
        },

        deleteSupplierPayment(id) {
            if(confirm('Are you sure to deleted ?')) {
                
                axios.post('delete-supplier-payment', { id:id })
                .then(res => {
                    let r = res.data;
                    if(r.success){
                        alert(r.message);
                        location.reload()
                    }
                })
            }
        },

        resetForm() {
            this.$refs.supplierPaymentForm.reset();
            this.supplierPayment.payment_date = new Date().toISOString().substr(0, 10);
        }
    }
})
</script>