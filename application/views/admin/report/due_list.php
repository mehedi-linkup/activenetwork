<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="CustomerDueListForm"> 
				 	<div class="row">
				 		<div class="col-md-10">

						<div class="form-group col-md-6">
							
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
						<div class="form-group col-md-6">
							
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
							<input type="hidden" name="action" id="action" value="duelist">
							<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
						</div> 
				 		</div>
					 
					</div>
					
					 </form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 15px"><a href="<?php echo base_url('due-customer-print') ?>" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered">
					<thead>
						<th>Serial</th>
						<th>Customer Name</th>
						<th>Phone Number</th>
						<th>Adress</th>
						<th>Due Month</th>
						<th>Dish Due</th>
						<th>Wifi Due</th>
						<th>Sub Total</th>
					</thead>
					<tbody id="duelistdata">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

  		$(document).on('submit','#CustomerDueListForm',function(e){
	      e.preventDefault();
	      var action=$('#action','#CustomerDueListForm').val();
	      var form_month=$('#form_month','#CustomerDueListForm').val();
	      var to_month=$('#to_month','#CustomerDueListForm').val();

	      if (form_month ==0) {
	        alert("Choose form search month");
	      }
	      else if(to_month ==0){
	        alert("Choose to search month");
	      }
	      else{
	      $.ajax({
	        url:'<?php echo base_url("due-all-cust") ?>',
	        method:'post',
	        data:new FormData(this),
	        contentType:false,
	        processData:false,
	        success:function(data){
	          $('#duelistdata').html(data);
	        }
	      });
	    }
	   })

	});
	 
</script>