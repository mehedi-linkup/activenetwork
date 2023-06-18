<style>
.consumption-box {
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
.consumption-table {
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
            <form id="consumptionForm" method="post" ref="consumptionForm" @submit.prevent="save">
                <div class="col-md-9">
                    <div class="consumption-box row">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Assign To </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <select class="form-control" v-if="employees.length == 0"></select>
                                    <v-select v-bind:options="employees" v-model="employee" label="display_text" v-if="employees.length > 0"></v-select>
                                </div>
                                <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'employee' ?>" target="_blanck" style="position: relative;left: -27px;height: 25px;" class="btn btn-info"><span style="position: absolute;top: -5px;left: 30%;font-size: 20px;">+</span></a></div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Mobile </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="mobile" name="mobile" id="mobile" class="form-control" style="margin-bottom: 3px;" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Designation </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="text" v-model="designation" name="designation" id="designation" class="form-control" style="margin-bottom: 3px;" readonly>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Area </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <select class="form-control" v-if="areas.length == 0"></select>
                                    <v-select v-bind:options="areas" v-model="area" label="name" v-if="areas.length > 0"></v-select>
                                </div>
                                <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'employee' ?>" target="_blanck" style="position: relative;left: -27px;height: 25px;" class="btn btn-info"><span style="position: absolute;top: -5px;left: 30%;font-size: 20px;">+</span></a></div>
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
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3" style="padding: 0px;">Assign Qty </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="number" v-model="consumption.quantity" name="quantity" id="quantity" class="form-control" style="margin-bottom: 3px;" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-3 col-sm-3 col-lg-3">Available </label>
                                <div class="col-md-9 col-sm-9 col-lg-9">
                                    <input type="number" v-model="stock" name="stock" id="stock" class="form-control" style="margin-bottom: 3px;" min="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-8 col-sm-8 col-lg-8"> </label>

                                <div class="col-md-4 col-sm-4 col-lg-4">
                                    <button type="button" @click="addToCart" class="btn btn-primary btn-block">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="consumption-table row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </thead>
                                <tbody v-if="addtocart.length">
                                    <tr v-for="(cart, ind) in addtocart" :key="ind">
                                        <td>{{ ind + 1 }}</td>
                                        <td>{{ cart.product_name }}</td>
                                        <td>{{ cart.category }}</td>
                                        <td class="text-right">{{ cart.quantity }}</td>
                                        <td class="text-center">
                                            <span @click="removeCart" style="cursor:pointer">
                                                <i class="fa fa-trash-o text-danger"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center">Note</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <textarea v-model="consumption.note" name="note" id="note" rows="2" class="form-control" style="height: 50px !important;"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="invoice-section">
                        <div class="row">
                            <label for="invoice" class="col-md-3">Invoice</label>
                            <div class="col-md-9">
                                <input type="text" v-model="invoice_id" id="invoice_id" name="invoice_id" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label for="invoice" class="col-md-3">Date</label>
                            <div class="col-md-9">
                                <input type="date" id="date" name="date" class="form-control" v-model="consumption.assign_date">
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
        consumption: {
            assign_date: new Date().toISOString().substr(0, 10),
            employee_id: null,
            area_id: null,
            product_id: null,
            quantity: 0,
            note: ''
        },

        mobile: '',
        designation: '',
        stock: 0,
        invoice_id: '',
        products: [],
        product: null,
        employees: [],
        employee: null,
        areas: [],
        area: null,
        addtocart: [],
    },

    watch: {
        product(product) {
            if(product == null) return
            this.consumption.product_id = product.id;
            this.product = product;
            axios.post('get-product-stock', { id : product.id})
            .then(res => {
                let a = res.data[0];
                this.stock = a.stock
                // console.log(a.stock)
            })
        },

        employee(employee) {
            if(employee == null) return
            this.consumption.employee_id = employee.id
            this.mobile = employee.emp_phone
            this.designation = employee.designation
        },

        area(area) {
            if(area == null) return
            this.consumption.area_id = area.id
            // console.log(this.consumption.area_id);
        }
    },

    created() {
        this.getProducts();
        this.getEmployess();
        this.getArea();
        axios.get('generate-code').then(res => {
            this.invoice_id = res.data;
        })
    },

    methods: {
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

        async getArea() {
            await axios.get('get_area').then(res => {
                this.areas = res.data;
            })
        },

        addToCart() {
            if(this.consumption.product_id == null) {
                alert("Select product");
				return;
            }

            if(this.consumption.quantity == 0) {
               alert("Choose quantity");
				return;
            }

            if( this.stock <= 0) {
                alert("Product stock is not available! Plase purchase first");
                return;
            }
            
            if(this.stock < parseFloat(this.consumption.quantity)) {
                alert('Stock quantity is too large !')
                return;
            }

            let cartInd = this.addtocart.findIndex(i => i.product_id == this.consumption.product_id);
            if(cartInd > -1){
                alert("product existed in cart");
                return;
            }

            let product = {
                product_id: this.product.id,
                product_name: this.product.product_name,
                category: this.product.category_name,
                quantity: this.consumption.quantity,
            }

            this.addtocart.push({...product});
            this.resetCart();
        },

        async save() {

            if(this.addtocart.length  == 0) {
                alert("Cart is empty ! Plase add to cart.");
				return;
            }

            if(this.consumption.employee_id == null) {
                alert("Select employee");
                return;
            }

            if(this.consumption.area_id == null) {
                alert("Select Area");
                return;
            }

            await axios.post('save-consumption', { ...this.consumption, cart: this.addtocart })
            .then(async res => {
                let r = res.data;
                if(r.success){
                    let conf = confirm('Consumption success, Do you want to view invoice?');
                    if(conf){
                        window.open('/consumption-invoice/'+r.consumptionId, '_blank');
                        await new Promise(r => setTimeout(r, 1000));
                        window.location = '/consumption';
                    } else {
                        window.location = '/consumption';
                    }
                }
                else{
                    alert(r.message);
                }
            })
        },
        removeCart(ind) {
            this.addtocart.splice(ind, 1);
        },

        resetCart() {
            this.consumption.quantity = '';
            this.product = '';
        },

        resetForm() {
            this.$refs.consumptionForm.reset();
            this.addtocart = [];
            this.consumption.assign_date = new Date().toISOString().substr(0, 10);
        }
    }
})
</script>