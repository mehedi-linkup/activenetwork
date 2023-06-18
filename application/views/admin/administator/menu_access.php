<div class="container">
  	<div class="row">
    	<div class="well" style="min-height: 500px">
    		<div class="col-md-10">
    			<?php 
    				$accessString = explode(',', $checkdata->menuaccess);
    				function check($getValue,$data){
    					$i =0;
    				foreach ($data as $value) {
    					if($value==$getValue){
    						return 'checked';
    						break;
    					}

    				 	$i++;
    				}
    			}
                 ?>
    			<form class="" method="post" id="useraccessFrom">
					<div class="row">
						<div class="col-md-12">
							<input type="checkbox" id="all_select" > <label>All Selected</label>
						</div>
					</div>
    				<div class="row">
	    				<div class="col-md-2">
	    					<h4>Administator</h4>
	    					<div>
	    						<input type="checkbox"  name="menuaccess[]" id="menuaccess" value="create-admin" <?php echo  check('create-admin',$accessString);  ?>> <label>Create User</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="employee" <?php echo  check('employee',$accessString) ?>> <label>Add Employee</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="company-profile" <?php echo  check('company-profile',$accessString) ?>> <label>Company Profile</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="customer" <?php echo  check('customer',$accessString) ?>> <label>Add Customer</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="supplier" <?php echo  check('supplier',$accessString) ?>> <label>Supplier Entry</label>
	    					</div>
	    				</div>
	    				<div class="col-md-2">
	    					<h4>Setting</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="area" <?php echo  check('area',$accessString) ?>> <label>Add Area</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="month" <?php echo  check('month',$accessString) ?>> <label>Add Month</label>
	    					</div>
	    					<!-- <div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="expense-type" <?php echo  check('expense-type',$accessString) ?>> <label>Add Expense Type</label>
	    					</div> -->
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="account" <?php echo  check('account',$accessString) ?>> <label>Add Account</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="speed" <?php echo  check('speed',$accessString) ?>> <label>Add Speed</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="category" <?php echo  check('category',$accessString) ?>> <label>Category Entry</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="unit" <?php echo  check('unit',$accessString) ?>> <label>Unit Entry</label>
	    					</div>
	    				</div>
	    				<div class="col-md-3">
	    					<h4>Collection</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="collection-setting" <?php echo  check('collection-setting',$accessString) ?>> <label>Bill Generate</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="collection-entry" <?php echo  check('collection-entry',$accessString) ?>> <label>Collection Entry</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="bill-generate" <?php echo  check('bill-generate',$accessString) ?>> <label>New Customer Bill</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="advance-payment" <?php echo  check('advance-payment',$accessString) ?>> <label>Advance Payment</label>
	    					</div>
	    				</div>
	    				<div class="col-md-2">
	    					<h4>Services</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="customer-payment" <?php echo  check('customer-payment',$accessString) ?>> <label>Service Payment</label>
	    					</div>
							<h4>Expense</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="salary" <?php echo  check('salary',$accessString) ?>> <label>Add Salary</label>
	    					</div>
	    					<!-- <div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="expense" <?php echo  check('expense',$accessString) ?>> <label>Add Expense</label>
	    					</div> -->
	    				</div>
	    				<div class="col-md-3">
	    					<h4>Transaction</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="transaction" <?php echo  check('transaction',$accessString) ?>> <label>Cash Transaction</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="cash-view" <?php echo  check('cash-view',$accessString) ?>> <label>Cash View</label>
	    					</div>
	    				</div>
	    			</div>
	    			<div class="row">
	    				<div class="col-md-3">
	    					<h4>Store Module</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="product" <?php echo  check('product',$accessString) ?>> <label>Metarial</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="purchase" <?php echo  check('purchase',$accessString) ?>> <label>Purchase</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="consumption" <?php echo  check('consumption',$accessString) ?>> <label>Consumption</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="stock" <?php echo  check('stock',$accessString) ?>> <label>Stock Record</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="supplier-payment" <?php echo  check('supplier-payment',$accessString) ?>> <label>Supplier Payment</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="purchase-record" <?php echo  check('purchase-record',$accessString) ?>> <label>Purchase Record</label>
	    					</div>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="consumption-record" <?php echo  check('consumption-record',$accessString) ?>> <label>Consumption Record</label>
	    					</div>
	    					
	    				</div>
	    				<div class="col-md-3">
	    					<h4>User Complaint</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="complaint" <?php echo  check('complaint',$accessString) ?>> <label>Add Complaint</label>
	    					</div>
	    					<h4>Dashboard Access</h4>
	    					<div>
	    						<input type="checkbox" name="menuaccess[]" id="menuaccess" value="dashboard" <?php echo  check('dashboard',$accessString) ?>> <label>Dashboard</label>
	    					</div>
	    				</div>
	    				<div class="col-md-6">
	    					<h4>Report</h4>
	    					<div class="row">
		    					<div class="col-md-6">
		    					    <!-- <div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="registration" <?php echo  check('registration',$accessString) ?>> <label>Registration</label>
		    						</div> -->
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="payment-invoices" <?php echo  check('payment-invoices',$accessString) ?>> <label>Collection Invoice</label>
		    						</div>
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="customer-report" <?php echo  check('customer-report',$accessString) ?>> <label>Customer List</label>
		    						</div>
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="due-list" <?php echo  check('due-list',$accessString) ?>> <label>Due Customer List</label>
		    						</div>
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="due-bill" <?php echo  check('due-bill',$accessString) ?>> <label>Single Customer Due</label>
		    						</div>

		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="cash-collection" <?php echo  check('cash-collection',$accessString) ?>> <label>Cash Statement</label>
		    						</div>
		    						
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="customer-ledger" <?php echo  check('customer-ledger',$accessString) ?>> <label>Customer Ledger</label>
		    						</div>
		    						
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="payment-list" <?php echo  check('payment-list',$accessString) ?>> <label>Payment List</label>
		    						</div>
		    						<!-- <div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="payment-bill" <?php //echo  check('payment-bill',$accessString) ?>> <label>Customer Payment</label>
		    						</div> -->
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="service-payment" <?php echo  check('service-payment',$accessString) ?>> <label>Service Payment</label>
		    						</div>
		    					</div>
		    					<div class="col-md-6">
		    						<!-- <div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="registration_record" <?php echo  check('registration_record',$accessString) ?>> <label>Registration Record</label>
		    						</div> -->
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="advance-list" <?php echo  check('advance-list',$accessString) ?>> <label>Advance Payment</label>
		    						</div>
		    					    <div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="areawise-customer" <?php echo  check('areawise-customer',$accessString) ?>> <label>Area Wise Customer</label>
		    						</div>
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="areawise-due" <?php echo  check('areawise-due',$accessString) ?>> <label>Areawise Due</label>
		    						</div>
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="areawise-payment" <?php echo  check('areawise-payment',$accessString) ?>> <label>Areawise Payment</label>
		    						</div>

		    						<!-- <div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="expense-report" <?php echo  check('expense-report',$accessString) ?>> <label>Expense Statement</label>
		    						</div> -->
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="user-complaint" <?php echo  check('user-complaint',$accessString) ?>> <label>User Complaint</label>
		    						</div>
		    						<div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="officer-collection" <?php echo  check('officer-collection',$accessString) ?>> <label>Officer Collection</label>
		    						</div>
		    						<!-- <div>
		    							<input type="checkbox" name="menuaccess[]" id="menuaccess" value="all-transaction-report" <?php echo  check('all-transaction-report',$accessString) ?>> <label>Month Record</label>
		    						</div> -->
		    					</div>
		    				</div>	
	    				</div>
	    			</div>
	    			<div class="row">
	    				<br>
	    				<div class="col-md-4 col-md-offset-4">
	    					
	    					<div>
	    						<input type="hidden" name="action" id="action" value="menuaccess">
	    						<input type="hidden" name="user_id" id="user_id" value="<?php echo $admin_id ?>">
	    						<input type="submit" name="submit" value="User Access" class="btn btn-info btn-block">
	    					</div>
	    				</div>
	    			</div>
    			</form>
    
    		</div>
		</div>    	
	</div>    	
</div>    	
<script>
	$(document).ready(function(){
		$(document).on('submit','#useraccessFrom',function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo base_url("user-access") ?>',
				method:'post',
				data:new FormData(this),
      			contentType:false,
      			processData:false,
      			success:function(data){
      				if (data.trim()=='update') {
      					alert('User Access Successfully');
      					window.location.href='<?php echo base_url("create-admin") ?>';
      				}
      			}
			})
		})

		$('#all_select').change(function() {
			if ($(this)[0].checked) {
				$('input:checkbox').prop('checked', true);
			} else {
				$('input:checkbox').prop('checked', false);
			}
		})
	})
</script>