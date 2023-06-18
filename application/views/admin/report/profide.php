<div class="container">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				 <form class="form-inline" id="profidelossForm" method="post"> 
				 	<div class="row">
				 		<div class="col-md-10">
							<div class="col-md-5">
								<label for="cust" class="control-label col-md-4">Form Date</label>
			                    <div class="col-md-7">
			                    	<input type="date" name="form_date" id="form_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo date('Y-m-d') ?>">
			                    	
		                         </div>
							</div>
							<div class="col-md-5">
								<label for="cust" class="control-label col-md-4">To Date</label>
			                    <div class="col-md-7">
			                    	<input type="date" name="to_date" id="to_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo date('Y-m-d') ?>">
		                         </div>
							</div>
							<div class="col-md-2">
					 			<div class="form-group">
									<input type="hidden" name="action" id="action" value="allrecode">
									<input class="btn btn-info" type="submit" name="submit" id="submit" value="View Report">
								</div> 
				 			</div>
				 		</div>
					 
					</div>
					
					 </form> 
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<br><br>
				<!-- <div style="margin-bottom: 15px"><a href="<?php// echo base_url('due-customer-print') ?>" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div> -->
				<table class="table table-bordered">
					<thead>
						<th>TotalCollection</th>
						<th>Total Salary</th>
						<th>Office Expense</th>
						<th>Payment Amount</th>
						<th>Service Total</th>
						<th>Due Amount</th>
						<th>Total Balance</th>
					</thead>
					<tbody id="allrecodeshow">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

  		$(document).on('submit','#profidelossForm',function(e){
	      e.preventDefault();
	      var action=$('#action','#profidelossForm').val();
	      var form_date=$('#form_date','#profidelossForm').val();
	      var to_date=$('#to_date','#profidelossForm').val();

	      if (form_date =='') {
	        alert("Choose form  search date");
	      }
	      else if(to_date ==''){
	        alert("Choose to search date");
	      }
	      else{
	      $.ajax({
	        url:'<?php echo base_url("all-report") ?>',
	        method:'post',
	        data:new FormData(this),
	        contentType:false,
	        processData:false,
	        success:function(data){
	        	//alert(data);
	          $('#allrecodeshow').html(data);
	        }
	      });
	    }
	   })

	});
	 
</script>