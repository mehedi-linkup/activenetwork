<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="CustomerPaymentForm"> 
				 	<div class="row">
				 		<div class="col-md-10">
				 			<div class="form-group col-md-4">
							
							<label for="cust" class="control-label col-md-3"> Customer Name</label>
		                   
		                    <div class="col-md-9">
		                    	<select class="js-example-basic-single form-control" id="cust_name" name="cust_name" >
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

						<div class="form-group col-md-4">
							
							<label for="cust" class="control-label col-md-3">Form Month</label>
		                   
		                    <div class="col-md-9">
		                    	<select class="form-control js-example-basic-single" name="form_month" id="form_month" required>
		                    		<option value="0">Select Month</option>
		                    		<?php 
		                    			$selectMonth=$this->db->query("select * from tbl_month where status='a' order by id desc")->result();
		                    			foreach($selectMonth as $month){
		                    		 ?>
		                    		 <option value="<?php echo $month->id ?>"><?php echo $month->month_name ?></option>
		                    		<?php } ?>
		                    	</select>
	                        	
	                         </div>
							
						</div>
						<div class="form-group col-md-4">
							
							<label for="cust" class="control-label col-md-3">To Month</label>
		                   
		                    <div class="col-md-9">
		                    	<select class="js-example-basic-single form-control" id="to_month" name="to_month" >
		                    		<option value="0">Select Month</option>
		                    		<?php 
		                    			$selectMonth=$this->db->query("select * from tbl_month where status='a' order by id desc")->result();
		                    			foreach($selectMonth as $month){
		                    		 ?>
		                    		 <option value="<?php echo $month->id ?>"><?php echo $month->month_name ?></option>
		                    		<?php } ?>
		                  
		                    		
		                    	</select>
	                        	
	                         </div>
							
						</div>
				 		</div>
				 		<div class="col-md-2">
				 			<div class="form-group">
							<input type="hidden" name="action" id="action" value="paymentreport">
							<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
						</div> 
				 		</div>
					 
					</div>
					<br>
					</form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="paymentlist"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		  $(document).on('submit','#CustomerPaymentForm',function(e){
	      e.preventDefault();
	      var action=$('#action','#CustomerPaymentForm').val();
	      var cust_name=$('#cust_name','#CustomerPaymentForm').val();
	      var form_month=$('#form_month','#CustomerPaymentForm').val();
	      var to_month=$('#to_month','#CustomerPaymentForm').val();

	      if (cust_name==0) {
	        alert('Choose customer name !');
	      }
	      else if(form_month==0){
	        alert('Choose Form month name !');
	      }
	      else if(form_month==0){
	        alert('Choose to month name !');
	      }
	      else{
	        $.ajax({
	          url:'<?php echo base_url("cust-payment-report") ?>',
	          method:'post',
	          data:new FormData(this),
	          contentType:false,
	          processData:false,
	          success:function(data){
	           // alert(data)
	            $('#paymentlist').html(data);
	          }
	        })
	      }
	   })
	});
</script>