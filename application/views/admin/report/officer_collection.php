<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="viewofficercollectionForm"> 
				 	<div class="row">
				 		<div class="col-md-12">
					 		<div class="col-md-4">
								<label for="cust" class="control-label col-md-4"> Officer Name</label>
			                    <div class="col-md-8">
			                    	<select class="js-example-basic-single form-control" id="officer_id" name="officer_id" required>
			                    		<option value="0">Select Officer</option>
			                    		<?php 
			                    			$names=$this->db->query("select id,emp_name,emp_phone from  tbl_emplyee where status='a'")->result();
			                    			foreach ($names as $value) {
			                    				$cust_id=$value->id;
			                    			 ?>
			                    		<option value="<?php echo $value->id ?>"><?php echo $value->emp_name .' - '.$value->emp_phone ?></option>
			                    	<?php } ?>
			                    		
			                    	</select>
		                        	
		                         </div>
							</div>

							<div class="col-md-7">
								<div class="row">
									<div class="col-md-6">
										<div>
											<label for="cust" class="control-label col-md-4">Date From</label>
						                    <div class="col-md-8">
												<input type="date" name="dateFrom" id="dateFrom" class="form-control" value="<?php echo date('Y-m-d') ?>">		                        	
					                         </div>
										</div>
									</div>
									<div class="col-md-6">
										<div>
											<label for="cust" class="control-label col-md-4">Date To</label>
						                    <div class="col-md-8">
						                    	<input type="date" name="dateTo" id="dateTo" class="form-control" value="<?php echo date('Y-m-d') ?>">
					                         </div>
										</div>
									</div>
								</div>
							</div>
					
				 		</div>
				 		<div class="col-md-1">
				 			<div>
							<input type="hidden" name="action" id="action" value="officercollection">
							<input class="btn btn-info" type="submit" name="submit" id="submit" value="Search">
						</div> 
				 		</div>
					 
					</div>
				
						
					<hr>
					
					 </form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div id="showofficercollection"></div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		  //report customer due list
	   $(document).on('submit','#viewofficercollectionForm',function(e){
	      e.preventDefault();
	      var action=$('#action','#viewofficercollectionForm').val();
	      var officer_id=$('#officer_id','#viewofficercollectionForm').val();
	      var coll_month=$('#coll_month','#viewofficercollectionForm').val();

	      if (officer_id==0) {
	        alert('Choose officer name !');
	      }
	      else if(coll_month==0){
	        alert('Choose collection month name !');
	      }
	      else{
	        $.ajax({
	          url:'<?php echo base_url("officer-coll-report") ?>',
	          method:'post',
	          data:new FormData(this),
	          contentType:false,
	          processData:false,
	          success:function(data){
	           // alert(data)
	            $('#showofficercollection').html(data);
	          }
	        })
	      }
	   })
    });
	
</script>