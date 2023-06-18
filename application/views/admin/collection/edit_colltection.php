<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<form class="" id="collectionForm" method="post">
			<div class="col-md-10 col-sm-10 col-lg-10">
				
				
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
					<div class="col-md-6 col-sm-6 col-lg-6">
						<div class="row">
		                    <label for="cust" class="control-label col-md-4 col-sm-4 col-lg-4">Select Customer  : </label>
		                   
		                    <div class="col-md-8 col-sm-8 col-lg-8">
		                    	<!-- <select class="js-example-basic-single form-control" id="customer" name="customer">
		                    		<option value="0">Select customer</option>
		                    	    
		                    		
		                    	</select> -->
		                    	<select class="js-example-basic-single form-control" name="state" id="customer" name="customer">
									  <?php 
		                    			$names=$this->db->query("select id,cust_id,cust_name,cust_phone from tbl_customer where status='a'")->result();
		                    			foreach ($names as $value) {
		                    				$cust_id=$value->id;
		                    			 ?>
			                    		<option value="<?php echo $value->id ?>"><?php echo $value->cust_id.'-'.$value->cust_name .' - '.$value->cust_phone ?></option>
			                    	<?php } ?>
								</select>
	                        </div>
		                </div>
						<div class="row">
		                    <label for="cust_name" class="control-label col-md-4 col-sm-4 col-lg-4">Customer Name : </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
		                    	<input type="hidden" name="cust_id" id="cust_id" value="">
		                    	<input type="text" name="cust_name" id="cust_name" class="form-control" placeholder="Customer name" required readonly style="margin-top: 3px;" value="">
	                        </div>
		                </div>
		                <div class="row">
		                    <label for="d_name" class="control-label col-md-4 col-sm-4 col-lg-4"> Discount Amount: </label>
		                    
		                    <div class="col-md-3 col-sm-3 col-lg-3">
		                    	<input type="text" name="discount" id="discount" class="form-control" placeholder="Amount"  style="margin-top: 3px;">
	                        	
	                        </div>
	                        <label for="a_name" class="control-label col-md-2 col-sm-2 col-lg-2"> Amount: </label>
	                        <div class="col-md-3 col-sm-3 col-lg-3">
		                    	<input type="text" name="net_amount" id="net_amount" class="form-control" readonly  style="margin-top: 3px;">
	                        </div>
		                </div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6">

						<div class="row">
		                    <label for="officer_id" class="control-label col-md-4">Officer Name :</label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<select id="officer_id" name="officer_id" class="form-control js-example-basic-single" style="margin-bottom: 3px">
	                        		<option value="0">Select Officer</option>
	                        		<?php 
	                        			$emplyees=$this->db->query("select id,emp_name from tbl_emplyee where status ='a'")->result();
	                        			foreach ($emplyees as  $emp) {
	                        		 ?>
	                        		 <option value="<?php echo $emp->id ?>"><?php echo $emp->emp_name; ?></option>
	                        		<?php } ?>
	                        	</select>
	                        </div>
		                </div>

		                <div class="row">
		                    <label for="emp_name" class="control-label col-md-4">Total Amount :</label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<input type="text" name="coll_amount" id="coll_amount" class="form-control" placeholder="Customer Bill" style="margin-bottom: 3px;margin-top: 3px" readonly>
	                        </div>
		                </div>

		                <div class="row">
		                    <label for="previous_due" class="control-label col-md-4">Payment Due :</label>
		                    <div class="col-md-5">
	                        	<input type="number" name="previous_due" id="previous_due" class="form-control" placeholder="Pay Amount" style="margin-bottom: 3px;margin-top: 3px" >
	                        </div>
	                        <div class="col-md-3">
		                    	<input type="hidden" name="action" id="action" value="create">
		                    	<input type="hidden" name="action_id" id="action_id">
	                        	<input type="submit" name="submit" id="submit" value="Collection" class="btn btn-info ">
	                        	<hr>
	                        </div>
		                </div>
					</div>
			</div>
			<div class="col-md-2 col-sm-2 col-lg-2">
				<div style="margin: 17px 0px;padding: 8px 2px;border: 1px solid red;position: relative;left: -10px;width: 120px;text-align: center;">
					<span>Opening Balance</span><br>
					<span id="prev-due"></span>
					<input type="hidden" name="prev_due" value="" id="prev_due" readonly>
				</div>
				<div style="margin: 17px 0px;padding: 8px 10px;border: 1px solid green;position: relative;left: -10px;top:-14px;width: 120px;text-align: center;">
					<span>Advance</span><br>
					<span id="advance"></span>
					<input type="hidden" name="advance_pay" value="" id="advance_pay" readonly>
				</div>
				
			</div>
			<div class="row">

				<div class="col-md-10 col-sm-12 col-lg-12">
					<table class="table table-bordered">
						<div id="delete" class="text-success"></div>
						<thead>
							<th>Name</th>
							<th>Phone</th>
							<th>Due Month</th>
							<th>Amount</th>
							<th>Payment</th>
						</thead>
						
						<tbody id="output">
								
							
						</tbody>
					</table>
				</div>	
			</div>
			</form>
		</div>
	</div>
</div>
<?php 

	print_r($cust_id);
 ?>

<script>
	$(discount).ready(function(){
		$(document).on('input','#previous_due',function(e){
			e.preventDefault();
			var payment=$('#previous_due','#collectionForm').val();
			var prev_due=$('#prev_due','#collectionForm').val();
			// if (payment < prev_due) {
			// 	alert('Previous collection amount is too much long');
			// }
			// else{
			// }
			var due=(parseFloat(prev_due)-parseFloat(payment));
			$('#prev-due').text(due);
		})
	})
</script>