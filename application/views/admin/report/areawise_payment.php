<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-10">
				 <form class="form-inline" id="areawisedueForm"> 
				 	<div class="row">
				 		<div class="col-md-9">

						<div class="form-group col-md-6">
							
							<label for="cust" class="control-label col-md-3">Area</label>
		                   
		                    <div class="col-md-9">
		                    	<select class="form-control js-example-basic-single" name="area_id" id="area_id" required>
		                    		<option value="0">Select Area</option>
		                    		<?php 
		                    			$selectarea=$this->db->query("select * from tbl_area where status='a' ")->result();
		                    			foreach($selectarea as $area){
		                    		 ?>
		                    		 <option value="<?php echo $area->id ?>"><?php echo $area->name ?></option>
		                    		<?php } ?>
		                    	</select>
	                        	
	                         </div>
							
						</div>
						<div class="form-group col-md-6">
							
							<label for="cust" class="control-label col-md-3">Month</label>
		                   
		                    <div class="col-md-9">
		                    	<select class="js-example-basic-single form-control" id="month_id" name="month_id" >
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
							<input type="hidden" name="action" id="action" value="areawisepaidlist">
							<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
						</div> 
				 		</div>
					 
					</div>
					
					 </form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 15px"><a href="<?php echo base_url('areawise-paid-print') ?>" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered">
					<thead>
						<th>Serial</th>
						<th>Customer Name</th>
						<th>Phone Number</th>
						<th>Adress</th>
						<th>Month</th>
						<th>Dish Payment</th>
						<th>Wifi Payment</th>
						<th>Total Payment</th>
					</thead>
					<tbody id="areawisepaidlist">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

  		$(document).on('submit','#areawisedueForm',function(e){
	      e.preventDefault();
	      var action=$('#action','#areawisedueForm').val();
	      var area_id=$('#area_id','#areawisedueForm').val();
	      var month_id=$('#month_id','#areawisedueForm').val();

	      if (area_id ==0) {
	        alert("Choose form search area");
	      }
	      else if(month_id ==0){
	        alert("Choose to search month");
	      }
	      else{
	      $.ajax({
	        url:'<?php echo base_url("areawise-cust-paid") ?>',
	        method:'post',
	        data:new FormData(this),
	        contentType:false,
	        processData:false,
	        success:function(data){
	          $('#areawisepaidlist').html(data);
	        }
	      });
	    }
	   })

	});
	 
</script>