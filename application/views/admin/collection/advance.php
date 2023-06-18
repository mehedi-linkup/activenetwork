<div class="container">
	<div class="row">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Customer Advance Payment</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-md-10">
							<form method="post" id="advancepaymentForm"> 
								<div class="col-md-6 col-md-offset-3">
									<div class="row">
										<label for="cust_id" class="col-md-4">Select Customer</label>
										<div class="col-md-8">
											<select id="cust_id" name="cust_id" class="form-control js-example-basic-single" required>
												<option value="0">Choose Customer</option>
												<?php 
													$result=$this->db->query("select id,cust_id,cust_name from  tbl_customer where status='a'")->result();
													if (!empty($result)) {
														foreach($result as $value){?>
															<option value="<?php echo $value->id ?>"><?php echo $value->cust_id.' - '.$value->cust_name ?></option>
													<?php	}}?>
											</select>
										</div>
									</div>
									<div class="row" style="padding: 5px 0px">
										<label for="amount" class="col-md-4">Amount</label>
										<div class="col-md-8">
											<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" required>
										</div>
									</div>
									<div class="row">
										<label for="date" class="col-md-4">Payment Date</label>
										<div class="col-md-8">
											<input type="date" name="create_date" id="create_date" placeholder="" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
										</div>
	
									</div>
									<div class="row" style="padding-top: 5px">
										<label for="" class="col-md-4"></label>
										<div class="col-md-8">
											<input type="hidden" name="action" id="action" value="create">
											<input type="submit" name="submit" id="submit" value="Save" class="btn btn-block btn-success">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$(document).on('submit','#advancepaymentForm',function(e){
		e.preventDefault();
		var cust_id=$('#cust_id','#advancepaymentForm').val();
		var amount=$('#amount','#advancepaymentForm').val();
		var create_date=$('#create_date','#advancepaymentForm').val();
		if(cust_id ==0){
			alert("Please choose customer ");
		}
		else if(amount == ''){
			alert('Please fill up amount !!');
		}
		else if(create_date ==''){
			alert('Please fill up date');
		}
		else{
			$.ajax({
				url:'<?php echo base_url("payment-save") ?>',
				method:'post',
				data:new FormData(this),
		        contentType:false,
		        processData:false,
		        success:function(data){
		         if (data.trim()=='success') {
		         	alert("Payment successfully");
		         	location.reload();
		         }
		        }
			})
		}
	})
})
</script>