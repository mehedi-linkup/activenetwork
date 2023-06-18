<style>
	@media  print {
		.table {
			border: 1px solid #ccc !important;
		}
	}
</style>
<div class="container" id="app">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				<form @submit.prevent="getPaymentCollections"> 
				 	<div class="row">
						<div class="col-md-2" style="padding:  0px;">
							<label for="type" class="col-md-3" style="padding: 0px;">Type</label>
							<div class="col-md-9" style="padding: 0px;">
								<select class="form-control" v-model="searchType" style="padding: 0px 10px;" @change="changeOnSearchType">
									<option value="">All</option>
									<option value="area">By Area</option>
									<option value="customer">By Customer</option>
								</select>
							</div>
						</div>
						<div class="col-md-3" style="display: none;padding:0px" :style="{display: searchType == 'area' && areas.length > 0 ? '' : 'none'}">
							<div class="form-group">
								<label for="area" class="control-label col-md-2" style="padding: 0px;text-align:center">Area</label>
								<div class="col-md-10" style="padding: 0;">
									<v-select v-bind:options="areas" v-model="area" label="name"></v-select>
								</div>
							</div>
						</div>
						<div class="col-md-4" style="display: none;padding:0px" :style="{display: searchType == 'customer' && customers.length > 0 ? '' : 'none'}">
							<div class="form-group">
								<label for="customers" class="control-label col-md-2" style="padding: 0px;text-align:center">Customer</label>
								<div class="col-md-10" style="padding: 0;">
									<v-select v-bind:options="customers" v-model="customer" label="display_text"></v-select>
								</div>
							</div>
						</div>

				 		<div class="col-md-5">
							<div class="form-group col-md-6" style="padding: 0px;">
								<label for="cust" class="control-label col-md-2">Form</label>
								<div class="col-md-10">
									<input type="date" id="dateFrom" class="form-control" v-model="dateFrom" required>
								</div>
							</div>
							<div class="form-group col-md-6" style="padding: 0px;">
								<label for="cust" class="control-label col-md-2">To</label>
								<div class="col-md-10">
									<input type="date" class="form-control" id="dateTo" v-model="dateTo" required>
								</div>
							</div>
				 		</div>
				 		<div class="col-md-1" style="padding: 0px;">
				 			<div class="form-group">
								<input class="btn btn-info btn-sm btn-block" type="submit" name="submit" id="submit" value="Search">
							</div> 
				 		</div>
					</div>
					<hr>
				</form> 
			</div>
			
		</div>
		<div class="row" style="display: none;" :style="{display: payments.length > 0 ? '' : 'none'}">
			<div class="col-md-12">
				<div style="margin-bottom: 15px">
					<a href="" style="color:#000;font-size: 16px;" v-on:click.prevent="print"><i class="fa fa-print"></i> print</a>
				</div>

				<div id="invoiceContent">
					<table class="table table-bordered">
						<thead>
							<th class="text-center">Sl.</th>
							<th class="text-center">Customer Id</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Phone</th>
							<th class="text-center">Area</th>
							<th class="text-center">Dish Payment</th>
							<th class="text-center">Wifi Payment</th>
							<th class="text-center">Discount</th>
							<th class="text-center">Total Payment</th>
						</thead>
						<tbody>
							<tr v-for="(paid, ind) in payments">
								<td>{{ ind + 1 }}</td>
								<td>{{ paid.cust_code }}</td>
								<td>{{ paid.cust_name }}</td>
								<td>{{ paid.cust_phone }}</td>
								<td>{{ paid.name }}</td>
								<td>{{ paid.dish_bill }}</td>
								<td>{{ paid.wifi_bill }}</td>
								<td>{{ paid.discount }}</td>
								<td>{{ paid.total }}</td>
							</tr>
							<tr>
								<td colspan="8" style="text-align: right;">Total Amount</td>
								<td style="text-align: right;">{{ payments.reduce((p, c) => {return +p + +c.total}, 0).toFixed(2) }}</td>
							</tr>
						</tbody>
					</table>
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
			searchType: '',
			dateFrom: new Date().toISOString().substr(0, 10),
			dateTo: new Date().toISOString().substr(0, 10),
			payments: [],
			areas: [],
			area: null,
			customers: [],
			customer: null,
		},
		created() {
			this.setStyle();
		},
		methods: {
			changeOnSearchType() {
				if(this.searchType == 'area') {
					this.getArea();
				} else if(this.searchType == 'customer') {
					this.getCustomers();
				}
			},
			getCustomers() {
				axios.get('/get-customers')
				.then(res => {
					this.customers = res.data;
				})
			},
			getArea() {
				axios.get('/get_area')
				.then(res => {
					this.areas = res.data;
				})
			},
			async getPaymentCollections() {
				if(this.searchType != 'area') {
					this.area = null;
				}
				if(this.searchType != 'customer') {
					this.customer = null;
				}
				if(this.searchType != 'officer') {
					this.user = null;
				}

				let filter = {
					dateFrom: this.dateFrom,
					dateTo: this.dateTo,
					areaId: this.area == null ? null : this.area.id,
					customerId: this.customer == null ? null : this.customer.id,
					userId: this.user == null ? null : this.user.id
				}
				await axios.post('/pay-all-cust', filter)
				.then(res => {
					this.payments = res.data;
				})
				.catch(err => {
					alert(err.response.data.message);
				})
			},

            async print(){
				let printContent = `
                    <div class="container">
                        <h4 style="text-align:center">Customer Payment List</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#invoiceContent').innerHTML}
							</div>
						</div>
                    </div>
                `;

                let printWindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);

                printWindow.document.body.innerHTML += printContent;
                printWindow.focus();
                await new Promise(r => setTimeout(r, 1000));
                printWindow.print();
                printWindow.close();
            }
		}
	})
</script>