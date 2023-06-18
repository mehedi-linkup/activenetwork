<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<form method="post" id="advancePaymentForm">
						<div class="col-md-2 col-sm-2 col-lg-2">
							Payment Type
						</div>
						<div class="col-md-3 col-sm-3 col-lg-3">
							<select id="onchange" name="select-option" class="form-control js-example-basic-single">
								<option value="0">All</option>
								<option value="1">Customer</option>
							</select>
						</div>
						
							<div id="customer" class="col-md-3 col-sm-3 col-lg-3" style="display: none;">
								<input type="text" name="phone" class="form-control" placeholder="Enter phone">
							</div>
						
						<div class="col-md-2 col-sm-2 col-lg-2">
							<input type="hidden" name="action" value="payment">
							<input type="submit" name="submit" class="btn btn-sm btn-info" value="View">
						</div>
					</form>
				</div>
			</div>
			<br>
			<div class="row" id="result">
				<div class="col-md-12 col-sm-12 col-lg-12">
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(document).on('change','#onchange', function(e){
			e.preventDefault();
			let changeValue = $(this).val();
			if (changeValue == 1) {
				$('#customer').css("display", "block");
			}
			else{
				$('#customer').css("display", "none");
			}
		});

		$(document).on('submit','#advancePaymentForm', function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url("advance-payment-list") ?>',
				method: 'post',
				data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data){
	            	
	            	$('#result').html(data);
	            	
	            }
			})
		})
	})
</script>