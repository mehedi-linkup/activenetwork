<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="expreportForm"> 
				 	<div class="row">
				 		<div class="col-md-10">
				 			<div class="form-group col-md-4">
							
							<label for="cust" class="control-label col-md-3">Expense Type</label>
		                   
		                    <div class="col-md-9">
		                    	<select class="js-example-basic-single form-control" id="exp_type" name="exp_type" >
		                    		<option value="0">Choose type</option>
		                    		
		                    		<?php 
		                    			$data=$this->db->query("select * from tbl_exp_type where status='a'")->result();
		                    			foreach($data as $value){
		                    		 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->expense_name ?></option>
									<?php } ?>
		                    		
		                    	</select>
	                        	
	                         </div>
							
						</div>

						<div class="form-group col-md-4">
							
							<label for="cust" class="control-label col-md-3">Form Date</label>
		                   
		                    <div class="col-md-9">
		                    	<input type="date" name="form_date" id="form_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo date('Y-m-d') ?>">
	                        	
	                         </div>
							
						</div>
						<div class="form-group col-md-4">
							
							<label for="cust" class="control-label col-md-3">To Date</label>
		                   
		                    <div class="col-md-9">
		                    	<input type="date" name="to_date" id="to_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo date('Y-m-d') ?>">
	                        	
	                         </div>
	                        	
	                         </div>
							
						</div>
						<div class="col-md-2">
				 			<div class="form-group">
							<input type="hidden" name="action" id="action" value="expreport">
							<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
						</div> 
				 		</div>
				 		</div>
				 		
					 </form> 
					</div>
				
						
					<hr>
					
					 
			</div>
			
		
		<div class="row">
			<div class="col-md-12">
				<div id="showexplist"></div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$(document).on('submit','#expreportForm',function(e){
		e.preventDefault();
		var action=$('#action','#expreportForm').val();
		var exp_type=$('#exp_type','#expreportForm').val();
		var form_date=$('#form_date','#expreportForm').val();
		var to_date=$('#to_date','#expreportForm').val();

		if (exp_type==0) {
			alert('Choose expense type');
		}
		else if(form_date ==''){
			alert('Form date is not empty !!');
		}
		else if(to_date ==''){
			alert('To date is not empty !!');
		}
		else{
			$.ajax({
				url:'<?php echo base_url("exp-reports") ?>',
				method:'post',
				data:new FormData(this),
				contentType:false,
                processData:false,
                success:function(data){
                	//alert(data);
                	$('#showexplist').html(data);
                }
			})
		}
	})
});	
</script>