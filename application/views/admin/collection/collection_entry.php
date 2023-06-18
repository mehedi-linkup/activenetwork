<style type="text/css">
	.opening {
		margin: 17px 0px;
		padding: 4px 0px;
		position: relative;
		left: -10px;
		width: 153px;
		text-align: center;
	}
	.advance {
		margin: 17px 0px;
		padding: 4px 10px;
		border: 1px solid green;
		position: relative;
		left: -10px;
		top:-14px;
		width: 150px;
		text-align: center;
	}
	.display-amount{
		text-align: left;
		padding: 4px 10px;
		border: 1px solid #ddd;
		margin-top: 3px;
		margin-bottom: 3px;
		border-radius: 5px;
	}
	
	/* table start */
	.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
		padding: 3px !important;
	}
	
    .table tbody > tr > td {
		padding: 1px 5px !important;
		text-align: center;
	}
	/* table end */

	/* v select start */
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
	#branchDropdown .vs__actions button{
		display:none;
	}
	#branchDropdown .vs__actions .open-indicator{
		height:15px;
		margin-top:7px;
	}
	/* v select end */

	@media only screen and (max-width: 320px){
		.opening {
			width: 114px;
		}
		.advance {
		    float: right;
		    top: -17px;
		    left: 50%;
		    position: absolute;
		}
	}
	@media only screen and (max-width: 400px){
		.due-adv {
			margin-left: 25px;
		}
		.opening {
			width: 120px;
		}
		.advance {
		    float: right;
		    top: -17px;
		    left: 50% !important;
		    position: absolute;
		}
	}
	@media only screen and (max-width: 500px){
		.due-adv {
			margin-left: 25px;
		}
		.opening {
			width: 120px;
		}
		.advance {
		    float: right;
		    top: -17px;
		    left: 40%;
		    position: absolute;
		}
	}
	@media only screen and (max-width: 767px){
		.due-adv {
			margin-left: 25px;
		}
		.opening {
			width: 120px;
		}
		.advance {
		    float: right;
		    top: -17px;
		    left: 40%;
		    position: absolute;
		}
	}
</style>
<div id="app">
	<div class="container">
		<div class="row">
			<form ref="collectionForm" id="collectionForm" method="post" @submit.prevent="saveCollection">
				<div class="widget-box">
					<div class="widget-header">
						<h4 class="widget-title">Collection Entry</h4>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
		
							<a href="#" data-action="close">
								<i class="ace-icon fa fa-times"></i>
							</a>
						</div>
					</div>
	
					<div class="widget-body">
						<div class="widget-main">
							<div class="col-md-12">
								<div class="col-md-10 col-sm-10 col-lg-10">
									<div class="col-md-6 col-sm-6 col-lg-6">
										<div class="row">
											<label for="cust" class="control-label col-md-3 col-sm-3 col-lg-3">Customer  : </label>

											<div class="col-md-9 col-sm-9 col-lg-9">
												<select class="form-control" v-if="customers.length == 0"></select>
												<v-select v-bind:options="customers" v-model="customer" label="display_text" v-if="customers.length > 0"></v-select>
											</div>
										</div>
										<div class="row">
											<label for="cust_name" class="control-label col-md-3 col-sm-3 col-lg-3"> Name : </label>
											<div class="col-md-9 col-sm-9 col-lg-9">
												<input type="text" v-model="name" name="cust_name" id="cust_name" class="form-control" placeholder="Customer name" required readonly style="margin-top: 3px;margin-bottom:3px;">
											</div>
										</div>
										<div class="row">
											<label for="cust_name" class="control-label col-md-3 col-sm-3 col-lg-3"> Recipt No : </label>
											<div class="col-md-9 col-sm-9 col-lg-9">
												<input type="text" v-model="collection.recipt_book" class="form-control" placeholder="Recipt book no" style="margin-top: 3px;margin-bottom:3px;">
											</div>
										</div>
										<div class="row">
											<label for="cust_name" class="control-label col-md-3 col-sm-3 col-lg-3"> Note : </label>
											<div class="col-md-9 col-sm-9 col-lg-9">
												<textarea class="form-control" v-model="collection.note" style="min-height: 60px;"></textarea>
											</div>
										</div>
									</div>

									<div class="col-md-6 col-sm-6 col-lg-6">
										<div class="row">
											<label for="officer_id" class="control-label col-md-4">Officer Name :</label>
											<div class="col-md-8 col-sm-8 col-lg-8">
												<select class="form-control" v-if="employees.length == 0"></select>
												<v-select v-bind:options="employees" v-model="employee" label="display_text" v-if="employees.length > 0"></v-select>
											</div>
										</div>
										<div class="row">
											<label for="emp_name" class="control-label col-md-4">Due Amount :</label>
											<div class="col-md-8 col-sm-8 col-lg-8">
												<div class="display-amount">
													<strong>{{ totalDue }}</strong>
												</div>
											</div>
										</div>
										<div class="row">
											<label for="emp_name" class="control-label col-md-4">Paid Amount :</label>
											<div class="col-md-8 col-sm-8 col-lg-8">
												<div class="display-amount">
													<strong>{{ calculateTotalAmount }}</strong>
												</div>
											</div>
										</div>
										<div class="row">
											<label for="previous_due" class="control-label col-md-4"></label>
											<div class="col-md-5">
											
											</div>
											<div class="col-md-3">
												<input type="hidden" name="action" id="action" value="create">
												<input type="hidden" name="action_id" id="action_id">
												<input type="submit" name="submit" id="submit" value="Collection" class="btn btn-info ">
												
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="due-adv">
										<div class="opening">
											<input type="date" name="date" v-model="collection.update_date" class="form-control">
										</div>
										<div class="advance">
											<span>Advance</span><br>
											<span id="advance">{{ collection.advance }} </span>
											<input type="hidden" name="advance_pay" value="" id="advance_pay" readonly>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-10 col-sm-12 col-lg-12 col-xs-12">
									<div class="table-responsive" style="margin-top: 15px;display: none;"  :style="{display: collections.length > 0 ? '': 'none'}">
										<table class="table table-bordered">
											<div id="delete" class="text-success"></div>
											<thead>
												<th class="text-center">SL.</th>
												<th class="text-center">Customer Id</th>
												<th class="text-center">Customer Name</th>
												<th class="text-center">Phone</th>
												<th class="text-center">Due Month</th>
												<th class="text-center">Dish Bill</th>
												<th class="text-center">Wifi Bill</th>
												<th class="text-center">Discount</th>
												<th class="text-center">Sub Total</th>
												<th class="text-center">Payment</th>
											</thead>
											
											<tbody>
												<tr v-for="(collection, ind) in collections" :key="ind">
													<td>{{ ind + 1 }}</td>
													<td>{{ collection.cust_id }}</td>
													<td>{{ collection.cust_name }}</td>
													<td>{{ collection.cust_phone }}</td>
													<td>{{ collection.month_name }}</td>
													<td>{{ collection.dish_bill }}</td>
													<td>{{ collection.wifi_bill }}</td>
													<td style="width: 10%;"><input type="number" v-model="collection.discount" class="form-control" id="discount_amount" name="discount_amount" min="0"> </td>
													<td>{{ calculateTotal(collection) }}</td>
													<td><input type="checkbox" v-model="collection.isChecked"></td>
												</tr>	
											</tbody>
										</table>
									</div>
								</div>	
							</div>
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
			collection: {
				update_date: new Date().toISOString().substr(0, 10),
				officer_id: null,
				advance: '',
				customer_id: null,
				recipt_book: '',
				note: ''
			},
			name: '',
			customers: [],
			customer: null,
			employees: [],
			employee: null,
			collections: [],
		},

		computed: {
			calculateTotalAmount() {
				let total = 0;
				this.collections.forEach(item => {
					if (item.isChecked) {
						total += this.calculateTotal(item)
					}
				})
				return total;
			},
			totalDue() {
				return this.collections.reduce((p, c) => { return +p + (+c.dish_bill + +c.wifi_bill )}, 0)
			}
		},

		watch: {
			customer(customer) {
				if(customer == null) return
				this.name = customer.cust_name
				this.collection.advance = customer.advance_amount
				this.collection.customer_id = customer.id;
				axios.post('customer-choose', {id: customer.id})
				.then(res => {
					let collections = res.data
					let newCollections = []
					if (collections.length) {
						collections.forEach(item => {
							newCollections.push({
								coll_id: item.coll_id,
								coll_month: item.coll_month,
								month_name: item.month_name,
								cust_id: item.cust_id,
								cust_name: item.cust_name,
								cust_phone: item.cust_phone,
								dish_bill: item.dish_bill,
								wifi_bill: item.wifi_bill,
								discount: item.discount,
								isChecked: false,
							})	
						})
						this.collections = newCollections
					}
				})

				// get employee
				this.getEmployees(customer.area_id)
			},

			employee(employee) {
				if(employee == null) return;
				this.collection.officer_id = employee.id
			}
		},

		created() {
			this.getCustomers();
			// this.getEmployees();
		},
		
		methods: {
			async getCustomers() {
				await axios.post('get-customers')
				.then(res => {
					this.customers = res.data;
				})
			},

			getEmployees(areaId) {
				axios.post('get-employees', {areaId: areaId})
				.then(res => {
					this.employees = res.data
				})
			},

			calculateTotal(collection) {
				if (collection.discount != '') {
					let dish_bill = parseFloat(collection.dish_bill)
					let wifi_bill = parseFloat(collection.wifi_bill)
					let discount = parseFloat(collection.discount)
					return (dish_bill + wifi_bill) - discount;
				}
				return 0;
			},

			async saveCollection() {
				if (this.collection.officer_id == null) {
					alert('Select officer !');
					return;
				}

				await axios.post('save-collection', { ...this.collection, cart: this.collections})
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
				.catch(err => {
					alert(err.response.data.message)
				})
			},

			resetForm() {
				this.$refs.collectionForm.reset();
				this.customer = null;
				this.employee = null;
				this.name = '';

			}
		}
	})
</script>