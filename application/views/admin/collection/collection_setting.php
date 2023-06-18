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
		text-align: center;
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
				<h4 class="widget-title">Customer Bill Generate</h4>
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
					<div class="col-md-12 col-sm-12 col-lg-12">
						<form @submit.prevent="billGenerate">
							<div class="row">
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 col-md-offset-2" style="padding: 0;">
									<div class="form-group">
										<label for="cust_name" class="control-label col-md-4">Bill Month </label>
										<div class="col-md-8" style="padding: 0;">
											<v-select v-bind:options="months" v-model="month" label="month_name" v-if="months.length > 0"></v-select>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<div class="form-group">
										<label for="emp_name" class="control-label col-md-3" style="padding: 0;">Date </label>
										<div class="col-md-9">
											<input type="date" v-model="bill.date" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-1 col-sm-1 col-lg-1" style="padding: 0;">
									<input type="submit" name="submit" id="submit" value="Generate" class="btn btn-info btn-sm btn-block">
								</div>
							</div>
						</form>
						<hr>
						<div style="margin-bottom: 10px;">
							<a href="" id="view" class="btn btn-info" @click.prevent="getCustomers">View Customer</a>
						</div>
					</div>

					<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
						<div class="table-responsive" style="display: none;" :style="{display: collections.length > 0 && show == false ? '' : 'none'}">
							<table class="table table-bordered">
								<thead>
									<th>SL.</th>
									<th>Trans. Id</th>
									<th>Customer Id</th>
									<th>Customer Name</th>
									<th>Phone</th>
									<th>Month</th>
									<th>Ger. Date</th>
									<th>Bill Amount</th>
								</thead>
								<tbody>
									<tr v-for="(customer, ind) in collections">
										<td>{{ ind + 1 }}</td>
										<td>{{ customer.coll_code }}</td>
										<td>{{ customer.cust_id }}</td>
										<td>{{ customer.cust_name }}</td>
										<td>{{ customer.cust_phone }}</td>
										<td>{{ customer.month_name }}</td>
										<td>{{ customer.coll_date }}</td>
										<td>{{ customer.coll_amount }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-md-12 col-sm-12 col-lg-12">
						<div class="table-responsive" style="display: none;" :style="{display: customers.length > 0 && show ? '' : 'none'}">
							<table class="table table-bordered">
								<thead>
									<th>SL.</th>
									<th>Customer Id</th>
									<th>Customer Name</th>
									<th>Phone</th>
									<th>Area</th>
									<th>Address</th>
									<th>Dish Bill</th>
									<th>Wifi Bill</th>
								</thead>
								<tbody>
									<tr v-for="(customer, ind) in customers">
										<td>{{ ind + 1 }}</td>
										<td>{{ customer.cust_id }}</td>
										<td>{{ customer.cust_name }}</td>
										<td>{{ customer.cust_phone }}</td>
										<td>{{ customer.area_name }}</td>
										<td>{{ customer.cust_address }}</td>
										<td>{{ customer.dish_total }}</td>
										<td>{{ customer.wifi_total }}</td>
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

<link rel="stylesheet" href="<?php echo base_url('assets/backend/css/v-select.css')?>">
<script src="<?php echo base_url('assets/backend/js/vue.js')?>"></script>
<script src="<?php echo base_url('assets/backend/js/axios.js')?>"></script>
<script src="<?php echo base_url('assets/backend/js/v-select.js')?>"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	const app = new Vue({
		el: '#app',
		data: {
			months: [],
			month: null,
			bill: {
				monthId: null,
				date: new Date().toISOString().substr(0, 10)
			},
			collections: [],
			customers: [],
			show: false
		},
		watch: {
			month(month) {
				if(month == undefined) return;
				this.bill.monthId = month.id;
				this.getBillGenerate();
			}
		},	
		async created() {
			await this.getMonths();
		},
		methods: {
			async getMonths() {
				await axios.get('/get_months')
				.then(res => {
					this.months = res.data;
				})
			},
			async billGenerate() {
				if(this.bill.monthId == null) {
					alert('Select bill generate month');
					return;
				}

				await axios.post('/save-setting', this.bill)
				.then(res => {
					if(res.data.success) {
						alert(res.data.message);
						this.getBillGenerate();
					} else {
						alert(res.data.message);
					}
				})
				.catch(err => {
					alert(err.response.data.message);
				})
			},
			getBillGenerate() {
				axios.post('/get_collections', {monthId: this.bill.monthId})
				.then(res => {
					this.collections = res.data;
					this.show = false;
				})
			},
			getCustomers() {
				axios.get('/get-customers')
				.then(res => {
					this.customers = res.data;
					this.show = true;
				})
			}
		}
	})
</script>