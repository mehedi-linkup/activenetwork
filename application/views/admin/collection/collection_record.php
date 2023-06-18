<style type="text/css">
	.showtext {
		display: none;
	}
    .table tbody > tr > td{
    	padding:1px 5px !important;
	}
</style>
<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<form method="post" id="collectionRecordForm"> 
				<div class="col-md-2">
					<div class="row">
						<label class="col-md-3">Type</label>
						<div class="col-md-9">
							<select name="type" id="searchType" class="form-control js-example-basic-single">
								<option value="0">All</option>
								<option value="1">By Customer</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4 showtext">
					<div class="row">
						<label class="col-md-3">Customer</label>
						<div class="col-md-9">
							<select name="customer_id" id="customer_id" class="form-control js-example-basic-single">
								<option value="0">Select Customer</option>
								<?php 
		                    		$names=$this->db->query("select id,cust_id,cust_name,cust_phone from tbl_customer where status='a'")->result();
		                    			foreach ($names as $value) {
		                    				$cust_id=$value->id;
		                    			 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->cust_id.'-'.$value->cust_name .' - '.$value->cust_phone ?></option>
		                    	<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<label class="col-md-2">From</label>
								<div class="col-md-10">
									<input type="date" name="dateFrom" id="dateFrom" value="<?php echo date('Y-m-d') ?>" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<label class="col-md-2">To</label>
								<div class="col-md-10">
									<input type="date" name="dateTo" id="dateTo" value="<?php echo date('Y-m-d') ?>" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1">
					<input type="submit" name="submit" value="Search" class="btn btn-info btn-sm">
				</div>
			</form>
			<div class="row" style="margin-top: 40px !important">
				<table class="table table-hover table-bordered">
					<thead>
						<th>Serial</th>
						<th>Transaction Id</th>
						<th>Customer Name</th>
						<th>Date</th>
						<th>Month</th>
						<th>Officer</th>
						<th>Amount</th>
						<th>Action</th>
					</thead>
					<tbody id="result">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){

	$(document).on('change', '#searchType', function(){
		var type = $(this).val();
		if(type == 0) {
			$(".showtext").css("display", "none");
		}
		else {
			$(".showtext").css("display", "block");
		}
	})

	$(document).on('submit','#collectionRecordForm',function(e){
		e.preventDefault();

		var type = $('#searchType').val();
		var custId = $('#customer_id').val();
		var dateFrom = $('#dateFrom').val();
		var dateTo = $('#dateTo').val();


		if(type == 0) {
			custId = 0;
		}

				
		$.ajax({
			url:'<?php echo base_url("collection-records")?>',
			method:'post',
			data: {cust_id: custId, dateFrom:dateFrom, dateTo: dateTo },
	        success:function(data){

	        	$('#result').html(data);
	        }
		})
	})
})
</script>