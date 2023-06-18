<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				<form class="form-inline" id="complaintForm"> 
				 	<div class="row">
				 		<div class="col-md-10">
					 		<div class="form-group col-md-4">
								
								<label for="cust" class="control-label col-md-3">Type</label>
			                   
			                    <div class="col-md-9">
		                        	<select id="complaintType" name="complaintType" class="form-control js-example-basic-single">
		                        		<option value="0">Choose complains type</option>
		                        		<option value="p">Pending</option>
		                        		<option value="c">Completed</option>
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
							<input type="hidden" name="action" id="action" value="complaintreport">
							<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
						</div> 
				 		</div>
				 		</div>
				 		
					 </form> 
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 15px"><a href="<?php echo base_url('complaint-print') ?>" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				 <table class="table table-bordered">
						<div id="delete" class="text-success"></div>
						<thead>
							<th>Serial</th>
							<th>Customer Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Area</th>
							<th>Officer Name</th>
							<th>Date</th>
							<th>Complaint</th>
						</thead>
						<tbody id="showcomplaint">
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(document).on('submit','#complaintForm',function(e){
			e.preventDefault();
			var complaintType=$('#complaintType','#complaintForm').val();
			var form_date=$('#form_date','#complaintForm').val();
			var to_date=$('#to_date','#complaintForm').val();
			if(complaintType ==0){
				alert("Please choose complains type");
			}
			else if (form_date=='') {
				alert("Select search form date");

			}
			else if(to_date==''){
				alert("Select search to date");
			}
			else{
				$.ajax({
					url:'<?php echo base_url("complaint-report") ?>',
					method:'post',
					data:new FormData(this),
	        		contentType:false,
	        		processData:false,
					success:function(data){
						$('#showcomplaint').html(data);
					}
				})
			}
		})
	})
</script>