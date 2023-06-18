<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="col-md-10 col-sm-12 col-lg-12">
				<form class="" id="paymentForm">
					<div id="output" class="text-success text-center"></div>
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
					<div class="col-md-6 col-md-offset-3">

						<?php 
							$code='T';
						    $Id = $code.'00001';
					        $lastCode = $this->db->query("select coll_id from tbl_collection order by coll_id desc limit 1");
					       
					        if (isset($lastCode)) {
					        	 $lastCode = $lastCode->row()->coll_id + 1;
					        $zeros = array('0', '00', '000', '0000');
					        $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
					        }
						 ?>
						<div class="row">
		                    <label for="cust_name" class="control-label col-md-4 col-sm-4 col-lg-4">Transaction Id </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
		                    	<input type="text" name="transaction_id" id="transaction_id" class="form-control" style="margin-bottom: 3px" value="<?php echo $Id ?>" readonly>
	                        </div>
		                </div>
		                
		                <div class="row">
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4">Customer Name </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<select class="js-example-basic-single form-control" id="customer_name" name="customer_name" >
		                    		<option value="0">Select customer</option>
		                    		<?php 
		                    			$names=$this->db->query("select id,cust_name,cust_phone from tbl_customer where status='a'")->result();
		                    			foreach ($names as $value) {
		                    				$cust_id=$value->id;
		                    			 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->cust_name .' - '.$value->cust_phone ?></option>
		                    	<?php } ?>
		                    		
		                    	</select>
	                        </div>
		                </div>
		   
                        <div class="row">
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4">Payment Date </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<input type="text" name="payment_date" id="payment_date" class="form-control" value="<?php echo date('Y-m-d') ?>" style="margin-bottom: 3px;margin-top:5px" required="1">
	                        </div>
		                </div>
		                <div class="row">
		                    <label for="d" class="control-label col-md-4">Description </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	
	                        	<textarea name="description" id="description" class="form-control" placeholder="Description" style="height:60px !important" required></textarea>
	                        </div>
		                </div>
		                <div class="row">
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4">Amount </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" style="margin-bottom: 3px;margin-top: 3px" required>
	                        </div>
		                </div>
		                
		                
		                <div class="row form-group ">
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4"></label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
		                    	<input type="hidden" name="action" id="action" value="payment">
		                    	<input type="hidden" name="action_id" id="action_id">
	                        	<input type="submit" name="submit" id="submit" value="Save" class="btn btn-success btn-block">

	                        </div>
		                </div>
		                
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).on('submit','#paymentForm',function(e){
	e.preventDefault();
	var action =$('#action','#paymentForm').val();
	var customer_name =$('#customer_name','#paymentForm').val();
	var amount =$('#amount','#paymentForm').val();
	
	if(customer_name==0){
		alert('Choose Customer name !!');
	}
	else if(amount ==''){
		alert('Amount field is not empty !!');
	}
	else{
		$.ajax({
			url:'<?php echo base_url("pay-customer") ?>',
			method:'post',
			data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){

            	if (data.trim()=='payment') {
            		alert('Payment successfully !!');
            		location.reload();
            	}
            	
            }
		})
	}
})
</script>

