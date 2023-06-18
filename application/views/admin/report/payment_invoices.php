<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<form id="paymentInvoiceForm" method="post">
						<div class="row">
							<div class="col-md-10">
								<label class="col-md-4">Payment Invoice</label>
								<div class="col-md-8">
									<select id="paymentInvoice" name="paymentInvoice" class="form-control js-example-basic-single">
										<option value="0">Select Invoice</option>
										<?php if(isset($paymentList)){ foreach($paymentList as $value){ ?>
										<option value="<?php echo $value->id ?>"><?php echo $value->coll_invoice ?></option>
										<?php }} ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<!-- <input type="submit" name="submit" id="submit" value="View" class="btn btn-info"> -->
							</div>
						</div>
					</form>
				</div>
			</div>	
			<div class="row">
				<div id="result"></div>
			</div>
		</div>
	</div>
</div>
<style type="text/css" media="print">
 #order-print{
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#order-print td, #order-print th {
  border: 1px solid #ddd;
  padding: 8px;
}
hr.bg{
   border-top: 1px solid #ddd;
}
</style>
<script>
	$(document).on('change','#paymentInvoiceForm',function(){
		//e.preventDefault();
		var action='Invoice';
		var paymentInvoice=$('#paymentInvoice','#paymentInvoiceForm').val();
		if (paymentInvoice==0) {
			alert('Choose payment invoice  !!');
		}else{
			$.ajax({
				url:'<?php echo base_url("invoice-data") ?>',
				method:'post',
				data:{action:action,paymentInvoice:paymentInvoice},
				success:function(data){
					//alert(data);
					$("#result").html(data);
				}
			})
		}
	})
</script>