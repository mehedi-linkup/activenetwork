<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="CustomerListForm" method="post"> 
				 	<div class="row">
						 <div class="col-md-3">
							<label for="type" class="col-md-3">Type</label>
							<div class="col-md-9">
								<select name="type" id="type" class="form-control js-example-basic-single">
									<option value="0">All</option>
									<option value="1">Dish Active</option>
									<option value="2">Dish Inactive</option>
									<option value="3">Wifi Active</option>
									<option value="4">Wifi Inactive</option>
								</select>
							</div>
						 </div>
						 <div class="col-md-4">
							 <label for="cust" class="control-label col-md-4">Form Date</label>
							 <div class="col-md-7">
								 <input type="date" name="form_date" id="form_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo date('Y-m-d') ?>">
							  </div>
						 </div>
						 <div class="col-md-4">
							 <label for="cust" class="control-label col-md-4">To Date</label>
							 <div class="col-md-7">
								 <input type="date" name="to_date" id="to_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo date('Y-m-d') ?>">
							  </div>
						 </div>
						 <div class="col-md-1">
							  <div class="form-group">
								 <input type="hidden" name="action" id="action" value="customerlist">
								 <input class="btn btn-info" type="submit" name="submit" id="submit" value="Search">
							 </div> 
						  </div>
					</div>
					
				</form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 15px"><a href="<?php echo base_url('customer-print') ?>" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th>Sl</th>
							<th>Cust. Id</th>
							<th>Cust. Name</th>
							<th>Father Name</th>
							<th>Phone Number</th>
							<th>Dish Qty</th>
							<th>Wifi Qty</th>
							<th>Dish Total</th>
							<th>Wifi Total</th>
							<th>Area</th>
							<th>Address</th>
							<th>Conn. Date</th>
							<th>Recon. Date</th>
							<th>Inact. Date</th>
						</thead>
						<tbody id="allcustomerlist">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

  		$(document).on('submit','#CustomerListForm',function(e){
	      e.preventDefault();
	      var action=$('#action','#CustomerListForm').val();
	      var form_date=$('#form_date','#CustomerListForm').val();
	      var to_date=$('#to_date','#CustomerListForm').val();

	      if (form_date =='') {
	        alert("Choose form  search date");
	      }
	      else if(to_date ==''){
	        alert("Choose to search date");
	      }
	      else{
	      $.ajax({
	        url:'<?php echo base_url("all-customer") ?>',
	        method:'post',
	        data:new FormData(this),
	        contentType:false,
	        processData:false,
	        success:function(data){
	        	//alert(data);
	          $('#allcustomerlist').html(data);
	        }
	      });
	    }
	   })

	});
	 
</script>