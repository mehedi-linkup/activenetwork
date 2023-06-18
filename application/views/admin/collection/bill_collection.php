<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			
			<div class="col-md-10">
				<form class="" id="addBillcollectionForm">
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

				
				
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
					<div class="col-md-6">
						
		             	
						<div>
		                    <label for="cust_name" class="control-label col-md-4">Customer Name  </label>
		                    <div class="col-md-8">
		                    	<select name="cust_name" id="cust_name" class="form-control js-example-basic-single" required>
		                    		<option>select customer</option>
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
		                <div>
		                    <label for="cust_father_name" class="control-label col-md-4">Collection code</label>
		                    <div class="col-md-8">
	                        	<input type="text" name="coll_code" id="coll_code" class="form-control" value="<?php echo $Id  ?>" style="margin-bottom: 3px;margin-top: 3px;" readonly>
	                        </div>
		                </div> 
		                <div>
		                    <label for="cust_name" class="control-label col-md-4"> Month  </label>
		                   
		                    <div class="col-md-8">
		                    	<select class="form-control js-example-basic-single" name="coll_month" id="coll_month" required>
		                    		<option>Select Month</option>
		                    		<?php 
		                    			$selectMonth=$this->db->query("select * from tbl_month where status='a'")->result();
		                    			foreach($selectMonth as $month){
		                    		 ?>
		                    		 <option value="<?php echo $month->id ?>"><?php echo $month->month_name ?></option>
		                    		<?php } ?>
		                    	</select>
	                        	
	                        </div>
		                </div>
		                
					</div>

					<div class="col-md-6">

		                <div>
		                    <label for="emp_name" class="control-label col-md-4">Collection Date </label>
		                    <div class="col-md-8">
	                        	<input type="date" name="coll_date" id="coll_date" class="form-control"  style="margin-bottom: 3px" required>
	                        </div>
		                </div>
		                <div>
		                    <label for="emp_name" class="control-label col-md-4">Fee Amount </label>
		                    <div class="col-md-8">
	                        	<input type="text" name="coll_amount" id="coll_amount" class="form-control"  style="margin-bottom: 3px" required>
	                        </div>
		                </div>
		                <div class="form-group ">
		                    <label for="emp_name" class="control-label col-md-4"></label>
		                    <div class="col-md-8">
		                    	<input type="hidden" name="action" id="action" value="create">
		                    	<!-- <input type="hidden" name="action_id" id="action_id"> -->
	                        	<input type="submit" name="submit" id="submit" value="Add Bill" class="btn btn-info ">
	                        	<hr>
	                        </div>
		                </div>
		                
					</div>
				</form>
				
			</div>
			
		</div>
	</div>
</div>


