<style>
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
	/* table start */
	.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
		padding: 3px !important;
	}
	
    .table tbody > tr > td {
		padding: 1px 5px !important;
		text-align: center;
	}
	/* table end */
	
	hr {
		margin-top: 20px;
		margin-bottom: 20px;
		border: 0;
		border-top: 1px solid #d3d7df;
	}
</style>
<div class="container" id="app">
	<div class="row">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">New Customer Bill Generate</h4>
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
					<div class="row">
						<form @submit.prevent="billGenerate">
							<div class="col-md-4 col-md-offset-2">
								<div class="form-group">
									<label for="cust" class="control-label col-md-2" style="padding: 0;">Customer </label>
									<div class="col-md-10" style="padding: 0px 0px 0px 5px;">
										<select class="form-control" v-if="customers.length == 0"></select>
										<v-select v-bind:options="customers" v-model="customer" label="display_text" v-if="customers.length > 0"></v-select>
									</div>
								</div>
							</div>
							<div class="col-md-3" style="padding: 0;">
								<div class="form-group">
									<label for="month" class="col-md-2" style="padding: 0;">Month</label>
									<div class="col-md-9" style="padding: 0;">
										<v-select v-bind:options="months" v-model="month" label="month_name" v-if="months.length > 0"></v-select>
									</div>
								</div>        
							</div>
							<div class="col-md-1" style="padding: 0;">
								<input type="submit" value="Save" class="btn btn-info btn-block btn-sm">
							</div>
						</form>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="table-responsive" style="display: none;"  :style="{display: collections.length > 0 ? '': 'none'}">
								<table class="table table-bordered">
									<div id="delete" class="text-success"></div>
									<thead>
										<th class="text-center">SL.</th>
										<th class="text-center">Customer Id</th>
										<th class="text-center">Customer Name</th>
										<th class="text-center">Phone</th>
										<th class="text-center">Generate Month</th>
										<th class="text-center">Dish Bill</th>
										<th class="text-center">Wifi Bill</th>
										<th class="text-center">Total Bill</th>
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
											<td>{{ collection.total }}</td>
										</tr>	
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
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
			bill: {
				customerId: null,
				monthId: null,
			},
			customers: [],
			customer: null,
			months: [],
			month: null,
			collections: []
		},
		watch: {
			customer(customer) {
				if(customer == undefined) return;
				this.bill.customerId = customer.id

				this.getCollection();
			},
			month(month) {
				if(month == undefined) return;
				this.bill.monthId = month.id;

				this.getCollection();
			}
		},
		async created() {
			await this.getCustomers();
			await this.getMonths();
		},
		methods: {
			async getCustomers() {
				await axios.post('get-customers')
				.then(res => {
					this.customers = res.data;
				})
			},
			async getMonths() {
				await axios.get('/get_months')
				.then(res => {
					this.months = res.data;
				})
			},
			async billGenerate() {
				if(this.bill.customerId == null) {
					alert('Select customer first');
					return;
				}
				if(this.bill.monthId == null) {
					alert('Select month');
					return;
				}

				await axios.post('/single-bill', this.bill)
				.then(res => {
					if(res.data.success) {
						alert(res.data.message);
						this.getCollection();
					} else {
						alert(res.data.message);
					}
				})
				.catch(err => {
					alert(err.response.data.message);
					return;
				})
			},
			getCollection() {
				if(this.bill.customerId == null) {
					alert('Select customer first');
					this.month = null;
					return;
				}
				if(this.bill.monthId == null) {
					alert('Select month');
					return;
				}

				let data = {
					customerId: this.bill.customerId,
					monthId: this.bill.monthId
				}
				axios.post('/get_collections', data)
				.then(res => {
					this.collections = res.data.map((item, total) => {
						item.total = +item.dish_bill + +item.wifi_bill;
						return item;
					});
				})
			}
		}
	})
</script>
