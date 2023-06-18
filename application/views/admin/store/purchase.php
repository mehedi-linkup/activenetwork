<style>
.purchase-box {
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
.invoice-section {
    background: #fff;
    border: 1px solid #ddd;
    padding: 10px;
    width: 100%;
    height: 100%;
    overflow: hidden;
    font-size: 16px;
    color: #000;
    clear: both;
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
            <form id="purchaseForm" method="post" ref="purchaseForm" @submit.prevent="savePurchase">
                <div class="col-md-9">
                    <div class="purchase-box row">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Supplier </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <select class="form-control" v-if="suppliers.length == 0"></select>
									<v-select v-bind:options="suppliers" v-model="supplier" label="display_text" v-if="suppliers.length > 0"></v-select>
                                </div>
                                <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'supplier' ?>" target="_blanck" style="position: relative;left: -27px;height: 25px;" class="btn btn-info"><span style="position: absolute;top: -5px;left: 30%;font-size: 20px;">+</span></a></div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Mobile </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="mobile" name="mobile" id="mobile" class="form-control" style="margin-bottom: 3px;" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Address </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <textarea v-model="address" id="address" name="address" class="form-control" style="height:80px !important;margin-bottom:3px"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Metarial </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <select class="form-control" v-if="products.length == 0"></select>
									<v-select v-bind:options="products" v-model="product" label="display_text" v-if="products.length > 0"></v-select>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'product' ?>" target="_blanck" style="position: relative;left: -27px;height: 25px;" class="btn btn-info"><span style="position: absolute;top: -5px;left: 30%;font-size: 20px;">+</span></a></div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Pur. Rate </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="number" @input="calculateTotalAmount" v-model="purchase.purchase_rate" name="purchase_rate" id="purchase_rate" class="form-control" style="margin-bottom: 3px;" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Quantity </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="number" @input="calculateTotalAmount" v-model="purchase.quantity" name="quantity" id="quantity" class="form-control" style="margin-bottom: 3px;" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Total </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="number" v-model="purchase.total_amount" name="total" id="total" class="form-control" style="margin-bottom: 3px;" min="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-8 col-sm-8 col-lg-8"> </label>

                                <div class="col-md-4 col-sm-4 col-lg-4">
                                    <button type="button" @click="addToCart" class="btn btn-info btn-block">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="purchase-table row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Sl</th>
                                    <th>Metarial Name</th>
                                    <th>Category</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </thead>
                                <tbody v-if="addtocart.length">
                                    <tr v-for="(cart, ind) in addtocart" :key="ind">
                                        <td>{{ ind + 1 }}</td>
                                        <td>{{ cart.product_name }}</td>
                                        <td>{{ cart.category }}</td>
                                        <td class="text-right">{{ cart.purchase_rate }}</td>
                                        <td class="text-right">{{ cart.quantity }}</td>
                                        <td class="text-right">{{ cart.total }}</td>
                                        <td class="text-center">
                                            <span @click="removeCart" style="cursor:pointer">
                                                <i class="fa fa-trash-o text-danger"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">Note</td>
                                        <td colspan="4" class="text-center"> Total</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <textarea v-model="purchase.note" name="note" id="note" rows="2" class="form-control" style="height: 50px !important;"></textarea>
                                        </td>
                                        <td colspan="4" class="text-center"> <strong> {{ purchase.sub_total }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding: 0;">
                    <div class="invoice-section">
                        <!-- <div class="row">
                            <label for="invoice" class="col-md-3">Invoice</label>
                            <div class="col-md-9">
                                <input type="text" id="invoice_id" name="invoice_id" class="form-control" readonly>
                            </div>
                        </div> -->
                        <div class="row">
                            <label for="invoice" class="col-md-3">Date</label>
                            <div class="col-md-9">
                                <input type="date" id="date" name="date" class="form-control" v-model="purchase.purchase_date">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:3px">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3"><span style="font-size: 14px;">Employee</span> </label>
                            <div class="col-md-9 col-sm-9 col-lg-9">
                                <select class="form-control" v-if="employees.length == 0"></select>
								<v-select v-bind:options="employees" v-model="employee" label="display_text" v-if="employees.length > 0"></v-select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Sub</label>
                            <div class="col-md-9">
                                <input type="number" v-model="purchase.sub_total" id="sub_total" name="sub_total" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Vat</label>
                            <div class="col-md-4">
                                <input type="text" @input="calculateTotal" v-model="vatPercent" id="discount" name="discount" class="form-control"  style="width:80px !important">
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" v-model="purchase.vat" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Discount</label>
                            <div class="col-md-4">
                                <input  @input="calculateTotal" v-model="disPercent" type="text" id="discount" name="discount" class="form-control" style="width:80px !important">
                            </div>
                            <div class="col-md-5">
                                <input type="text" @input="calculateTotal"  class="form-control" v-model="disAmount" id="discount__amount">
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Others</label>
                            <div class="col-md-9">
                                <input type="number" @input="calculateTotal" id="others" name="others" class="form-control" v-model="purchase.others">
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Total</label>
                            <div class="col-md-9">
                                <input type="number" id="total" name="total" class="form-control" v-model="purchase.total" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Paid</label>
                            <div class="col-md-9">
                                <input type="number" @input="dueCalculated" id="paid" name="paid" class="form-control" v-model="purchase.paid">
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Due</label>
                            <div class="col-md-5">
                                <input type="text" id="due" name="due" class="form-control" readonly v-model="purchase.due">
                            </div>
                            <div class="col-md-4">
                                <input type="text" v-model="purchase.previous_due" class="form-control" style="width:92px !important;margin-left:-23px;margin-bottom:3px" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-md-3"></label>
                            <div class="col-md-9">
                                <input type="submit" id="submit" name="submit" value="Save" class="btn btn-info btn-block">
                            </div>
                            <!-- <div class="col-md-6">
                                <input type="reset" class="btn btn-danger btn-block" @click="resetForm">
                            </div> -->
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
        purchase: {
            purchase_date: new Date().toISOString().substr(0, 10),
            employee_id: null,
            supplier_id: null,
            product_id: null,
            purchase_rate: 0.00,
            quantity: 0,
            total_amount: 0.00,
            sub_total: 0.00,
            vat: 0.00,
            discount: 0.00,
            others: 0.00,
            total: 0.00,
            paid: 0.00,
            due: 0.00,
            previous_due: 0.00,
            note: ''
        },
        vatPercent: 0.00,
        disPercent: 0.00,
        disAmount: 0.00,

        mobile: '',
        address: '',

        suppliers: [],
        supplier: null,
        products: [],
        product: null,
        employees: [],
        employee: null,
        addtocart: [],
    },

    watch: {
        supplier(supplier){
            if (supplier == null) return
            this.purchase.supplier_id = supplier.id;
            this.mobile = supplier.mobile
            this.address = supplier.address;
            // console.log(supplier.id)
            axios.post('supplier-due', { id: supplier.id})
            .then(res => {
                let supplier = res.data[0];
                this.purchase.previous_due = supplier.due
            })
            
        },

        product(product) {
            if(product == null) return
            this.purchase.product_id = product.id;
            this.product = product;
            this.purchase.purchase_rate = product.purchase_rate;
        },

        employee(employee) {
            if(employee == null) return
            this.purchase.employee_id = employee.id
        }
    },

    created() {
        this.getSupplier();
        this.getProducts();
        this.getEmployess();
    },

    methods: {
        async getSupplier() {
            await axios.get('get-suppliers')
            .then(res => {
               this.suppliers = res.data
            })
        },

        async getProducts() {
            await axios.get('get-products')
            .then(res => {
                this.products = res.data
            })
        },

        async getEmployess() {
            await axios.get('get-employees')
            .then(res => {
                this.employees = res.data;
            })
        },

        calculateTotalAmount() {
            if(this.purchase.purchase_rate == 0) {
                alert('Purchase rate is not empty !')
                return;
            }
            this.purchase.total_amount = (parseFloat(this.purchase.purchase_rate) * parseFloat(this.purchase.quantity));
        },

        addToCart() {
            if(this.purchase.product_id == null) {
                alert("Select product");
				return;
            }

            if(this.purchase.quantity == 0) {
               alert("Choose quantity");
				return;
            }

            let cartInd = this.addtocart.findIndex(i => i.product_id == this.purchase.product_id);
				if(cartInd > -1){
                   alert("product existed in cart");
					return;
				}

            let product = {
                product_id: this.product.id,
                product_name: this.product.product_name,
                category: this.product.category_name,
                purchase_rate: this.purchase.purchase_rate,
                quantity: this.purchase.quantity,
                total: this.purchase.total_amount
            }

            this.addtocart.push({...product});
            this.calculateTotal();
            this.resetCart();
        },

        async savePurchase() {
            if(this.purchase.supplier_id == null) {
                alert("Select supplier");
				return;
            }

            if(this.addtocart.length  == 0) {
                alert("Cart is empty ! Plase add to cart.");
				return;
            }

            if(this.purchase.employee_id == null) {
                alert("Select employee");
                return;
            }

            await axios.post('save-purchase', { ...this.purchase, cart: this.addtocart })
            .then(async res => {
                let r = res.data;
                if(r.success){
                    let conf = confirm('Purchase success, Do you want to view invoice?');
                    if(conf){
                        window.open('/purchase-invoice/'+r.purchaseId, '_blank');
                        await new Promise(r => setTimeout(r, 1000));
                        window.location = '/purchase';
                    } else {
                        window.location = '/purchase';
                    }
                }
                else{
                    alert(r.message);
                }
            })

        },

        calculateTotal() {
            this.purchase.sub_total = this.addtocart.reduce((prev, curr) => { return prev + parseFloat(curr.total); }, 0);
            this.purchase.vat = ((this.purchase.sub_total * this.vatPercent) / 100).toFixed(2);

            if (event.target.id == 'discount__amount') {
                this.disPercent = ((this.disAmount / this.purchase.sub_total) * 100).toFixed(2);
                this.purchase.discount = this.disAmount;
            } else {
                this.disAmount = ((this.purchase.sub_total * this.disPercent) / 100).toFixed(2);
                this.purchase.discount = this.disAmount;
            }

            this.purchase.total = ((parseFloat(this.purchase.sub_total) + parseFloat(this.purchase.vat) + parseFloat(this.purchase.others)) - this.purchase.discount ).toFixed(2);
            this.purchase.due = parseFloat(this.purchase.total) - parseFloat(this.purchase.paid);
            
        },

        dueCalculated() {
            this.purchase.due = (parseFloat(this.purchase.total) - parseFloat(this.purchase.paid))
        },

        removeCart(ind) {
            this.addtocart.splice(ind, 1);
            this.calculateTotal();

            if(this.addtocart.lenght < 0) {
                this.purchase.sub_total = 0.00;
                this.purchase.total = 0.00;
                this.purchase.vat = 0.00;
                this.purchase.discount = 0.00;
                this.purchase.others = 0.00;
            }
        },

        resetCart() {
            this.purchase.purchase_rate = '';
            this.purchase.quantity = '';
            this.purchase.total_amount = '';
            this.product = '';
        },

        resetForm() {
            this.$refs.purchaseForm.reset();
            this.addtocart = [];
            this.purchase.purchase_date = new Date().toISOString().substr(0, 10);
        }
    }
})
</script>