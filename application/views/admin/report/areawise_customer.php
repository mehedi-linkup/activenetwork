<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="row">
				<div class="col-md-10">
					<form id="areawisecustomerForm" method="post">
						<div class="col-md-10">
							<div class="col-md-6">
								<label for="type" class="col-md-5">Select Type</label>
								<div class="col-md-7">
									<select id="type" name="type" class="form-control js-example-basic-single" required>
										<option value="0">Choose Type</option>
										<option value="1">With Due</option>
										<option value="2">Without Due</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<label for="area" class="col-md-4">Select Area</label>
								<div class="col-md-8">
									<select id="area" name="area" class="form-control js-example-basic-single" required>
										<option value="0">Choose Area</option>
										<?php 
											$result=$this->db->query("select * from tbl_area where status='a'")->result();
											foreach($result as $value){?>
												<option value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<input type="hidden" name="action" id="action" value="areawisecustomer">
							<input type="submit" name="submit" value="View Customer" class="btn btn-info">
						</div>
					</form>
				</div>
			</div>
			<hr>
			<div class="row" id="areacustomerlist">
				
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$(document).on('submit','#areawisecustomerForm',function(e){
		e.preventDefault();
		var action=$('#action','#areawisecustomerForm').val();
		var type=$('#type','#areawisecustomerForm').val();
		var area=$('#area','#areawisecustomerForm').val();
		if (type==0) {
			alert("Please choose type !");
		}
		else if (area==0) {
			alert("Please choose area !");
		}
		else{ 
			$.ajax({
				url:'<?php echo base_url("area-cust-list") ?>',
				method:'post',
				data:{action:action,type:type,area:area},
				success:function(data){
					$('#areacustomerlist').html(data);
				}
			})
		}
	})
})
</script>