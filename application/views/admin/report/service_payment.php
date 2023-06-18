<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="servicereportForm"> 
				 	<div class="row">
				 		<div class="col-md-10">
				 			<div class="form-group col-md-6">
							
								<label for="cust" class="control-label col-md-4"> Customer Name</label>
			                    <div class="col-md-8">
			                    	<select class="js-example-basic-single form-control" id="cust_id" name="cust_id" >
			                    		<option value="0">Select customer</option>
			                    		<?php 
			                    			$names=$this->db->query("select id,cust_id,cust_name,cust_phone from tbl_customer where status='a'")->result();
			                    			foreach ($names as $value) {
			                    				
			                    			 ?>
			                    		<option value="<?php echo $value->id ?>"><?php echo $value->cust_id .' - '.$value->cust_name .' - '.$value->cust_phone ?></option>
			                    	<?php } ?>
			                    		
			                    	</select>
		                        	
		                         </div>
								
						    </div>
						    <div class="col-md-2">
							 			<div class="form-group">
										<input type="hidden" name="action" id="action" value="servicereport">
										<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
									</div> 
						 		</div>
				 		</div>
				 		
					 
					</div>
				
						
					<hr>
					
					 </form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-10">
				<div id="showservicereport"></div>
				
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).on('submit','#servicereportForm',function(e){
		e.preventDefault();
		var action=$('#action','#servicereportForm').val();
		var cust_id=$('#cust_id','#servicereportForm').val();
		if (cust_id==0) {
			alert('Choose customer name !!');
		}else{
			$.ajax({
				url:'<?php echo base_url("ser-report") ?>',
				method:'post',
				data:{action:action,cust_id:cust_id},
				success:function(data){
					//alert(data);
					$("#showservicereport").html(data);
				}
			})
		}
	})
</script>