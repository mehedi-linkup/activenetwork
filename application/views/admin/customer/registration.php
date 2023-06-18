<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="row">
				<form action="<?php echo base_url('store_registration') ?>" method="post" enctype="multipart/form-data">
				<?php
				if ($this->session->flashdata('errors')){
					echo '<div class="alert alert-danger">';
					echo $this->session->flashdata('errors');
					echo "</div>";
				}


				?>
					<div class="col-md-6">
						<div>
		                    <label for="formSlNo" class="control-label col-md-4 col-sm-4">Form Number : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="formSlNo" id="formSlNo" class="form-control" value="<?php echo $formSlNo ?>" style="margin-bottom: 3px"  required readonly>
	                        </div>
						</div>
						<div>
		                    <label for="formSlNo" class="control-label col-md-4 col-sm-4">Name : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="name" id="name" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
		                    <label for="formSlNo" class="control-label col-md-4 col-sm-4">Phone : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="phone" id="phone" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Nid : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="nid" id="nid" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Father Name : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="father_name" id="father_name" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">House Name : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="house_name" id="house_name" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Holding No : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="holding_no" id="holding_no" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">House No : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="house_no" id="house_no" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4">Area :</label>
		                    <div class="col-md-7 col-sm-7">
	                        	<select id="area_id" name="area_id" class="form-control js-example-basic-single" style="margin-bottom: 3px" required>
	                        		<option>Select Area</option>
	                        		<?php 
	                        			$area=$this->db->query("select * from tbl_area where status ='a'")->result();
	                        			foreach ($area as  $value) {
	                        		 ?>
	                        		 <option value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>
	                        		<?php } ?>
	                        	</select>
	                        	<div style="margin:3px 0px;"></div>
	                        </div>
	                        <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'area' ?>" target="_blanck" style="position: relative;left: -15px;height: 25px;" id="area" class="btn btn-info"><span style="position: absolute;top: -5px;left: 25%;font-size: 20px;">+</span></a></div>
		                </div>
						<div>
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4">Officer :</label>
		                    <div class="col-md-7 col-sm-7">
	                        	<select id="officer_id" name="officer_id" class="form-control js-example-basic-single" style="margin-bottom: 3px" required>
	                        		<option>Select Officer</option>
	                        		<?php 
	                        			$emplyees=$this->db->query("select id,emp_name from tbl_emplyee where status ='a'")->result();
	                        			foreach ($emplyees as  $emp) {
	                        		 ?>
	                        		 <option value="<?php echo $emp->id ?>"><?php echo $emp->emp_name; ?></option>
	                        		<?php } ?>
	                        	</select>
	                        </div>
	                        <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'employee' ?>" target="_blanck" style="position: relative;left: -15px;height: 25px;" id="employee" class="btn btn-info"><span style="position: absolute;top: -5px;left: 25%;font-size: 20px;">+</span></a></div>
		                </div>
						<div>
		                    <label for="emp_name" class="control-label col-md-4 col-sm-4">Month Fee :</label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="number" name="cust_bill" id="cust_bill" class="form-control" placeholder="Customer Bill" style="margin-bottom: 3px;margin-top: 3px" required>
	                        </div>
		                </div>
		                 <div>
		                    <label for="quantity" class="control-label col-md-4 col-sm-4">Quantity :</label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Service Quantity" style="margin-bottom: 3px;margin-top: 3px" required>
	                        </div>
		                </div>
		                 <div>
		                    <label for="total_amount" class="control-label col-md-4 col-sm-4">Total Amount :</label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="total_amount" id="total_amount" class="form-control" placeholder="Total Amount" style="margin-bottom: 3px;margin-top: 3px" required readonly>
	                        </div>
		                </div>
						
					</div>
					<div class="col-md-6">
						<h3 style="margin-left: 10px;margin-top: -3px;">Present Address</h3>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Present Address : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="present_address" id="present_address" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Post Office : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="pre_post" id="pre_post" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Thana : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="pre_thana" id="pre_thana" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">District : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="pre_district" id="pre_district" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<h3 style="margin-left: 10px">Permanent Address</h3>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Permanent Address : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="parament_address" id="parament_address" class="form-control" style="margin-bottom: 3px"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Post Office : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="par_post" id="par_post" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Thana : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="par_thana" id="par_thana" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">District : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="par_district" id="par_district" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Connection Date : </label>
							<div class="col-md-8 col-sm-8">
								<input type="date" name="connection_date" id="connection_date" class="form-control" style="margin-bottom: 3px"  value="<?php echo date('Y-m-d')?>" required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Connection Fee : </label>
							<div class="col-md-8 col-sm-8">
								<input type="number" name="connection_fee" id="connection_fee" class="form-control" style="margin-bottom: 3px"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Image: </label>
							<div class="col-md-8 col-sm-8">
								<input type="file" name="image">
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-sm btn-primary" style="margin-right: 16px;">Save Now</button>
						</div>
					</div>
				</form>
			</div>	
			<div class="row">
				<div id="result"></div>
			</div>
		</div>
	</div>
</div>
<script>
//total amount 
	$(document).on("keyup change",'#quantity',function(e){
    	 e.preventDefault();
    	var month_fee=$('#cust_bill').val();
    	var quantity=$('#quantity').val();
    	
    	if (month_fee =='') {
    		alert('Please field up month fee');
    	}
    	else{
    		var total_amount=(month_fee*quantity);
    		$('#total_amount').val(total_amount);
    		//alert(total_amount)
    	}
    })
</script>
<style type="text/css" media="print">
 #order-print{
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#order-print td, #order-print th {
  border: 1px solid #ddd;
  padding: 8px;
}
hr.bg{
   border-top: 1px solid #ddd;
}
</style>
