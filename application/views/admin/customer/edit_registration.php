<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="row">
                <form action="<?php echo base_url('update_registration') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $customer->id;?>">
					<div class="col-md-6">
						<div>
		                    <label for="formSlNo" class="control-label col-md-4 col-sm-4">Form Number : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="formSlNo" id="formSlNo" class="form-control" value="<?php echo $customer->id ?>" style="margin-bottom: 3px"  required readonly>
	                        </div>
						</div>
						<div>
		                    <label for="formSlNo" class="control-label col-md-4 col-sm-4">Name : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="name" id="name" class="form-control" style="margin-bottom: 3px"  value="<?= $customer->name ?>" required>
	                        </div>
						</div>
						<div>
		                    <label for="formSlNo" class="control-label col-md-4 col-sm-4">Phone : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="phone" id="phone" class="form-control" style="margin-bottom: 3px" value="<?= $customer->phone ?>"  required>
	                        </div>
						</div>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Nid : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="nid" id="nid" class="form-control" style="margin-bottom: 3px" value="<?= $customer->nid ?>"  required>
	                        </div>
						</div>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Father Name : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="father_name" id="father_name" class="form-control" style="margin-bottom: 3px" value="<?= $customer->father_name ?>"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">House Name : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="house_name" id="house_name" class="form-control" style="margin-bottom: 3px" value="<?= $customer->house_name ?>"  required>
							</div>
						</div>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Holding No : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="holding_no" id="holding_no" class="form-control" style="margin-bottom: 3px" value="<?= $customer->holding_no ?>"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">House No : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="house_no" id="house_no" class="form-control" style="margin-bottom: 3px" value="<?= $customer->house_no ?>"  required>
							</div>
						</div>

						<div>
							<label class="control-label col-md-4 col-sm-4">Image: </label>
							<div class="col-md-5 col-sm-5">
								<input type="file" name="image">
								<input type="hidden" name="old_image" id="old_image" value="<?php echo $customer->image;?>">
							</div>
							<div class="col-md-3 col-sm-3">
								<img src="<?php echo base_url('assets/backend/images/customer/').$customer->image?>" alt="" height="80px" width="80px">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h3 style="margin-left: 10px;margin-top: -3px;">Present Address</h3>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Present Address : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="present_address" id="present_address" class="form-control" style="margin-bottom: 3px" value="<?= $customer->present_address ?>"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">P.O : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="pre_post" id="pre_post" class="form-control" style="margin-bottom: 3px"  value="<?= $customer->pre_post ?>" required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Thana : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="pre_thana" id="pre_thana" class="form-control" style="margin-bottom: 3px" value="<?= $customer->pre_thana ?>"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">District : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="pre_district" id="pre_district" class="form-control" style="margin-bottom: 3px"  value="<?= $customer->pre_district ?>" required>
							</div>
						</div>
						<h3 style="margin-left: 10px">Parament Address</h3>
						<div>
		                    <label class="control-label col-md-4 col-sm-4">Parament Address : </label>
		                    <div class="col-md-8 col-sm-8">
	                        	<input type="text" name="parament_address" id="parament_address" class="form-control" style="margin-bottom: 3px" value="<?= $customer->parament_address ?>"  required>
	                        </div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">P.O : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="par_post" id="par_post" class="form-control" style="margin-bottom: 3px" value="<?= $customer->par_post ?>" required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Thana : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="par_thana" id="par_thana" class="form-control" style="margin-bottom: 3px" value="<?= $customer->par_thana ?>"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">District : </label>
							<div class="col-md-8 col-sm-8">
								<input type="text" name="par_district" id="par_district" class="form-control" style="margin-bottom: 3px" value="<?= $customer->par_district ?>"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Connection Date : </label>
							<div class="col-md-8 col-sm-8">
								<input type="date" name="connection_date" id="connection_date" class="form-control" style="margin-bottom: 3px" value="<?= $customer->connection_date ?>"  required>
							</div>
						</div>
						<div>
							<label class="control-label col-md-4 col-sm-4">Connection Fee : </label>
							<div class="col-md-8 col-sm-8">
								<input type="number" name="connection_fee" id="connection_fee" class="form-control" style="margin-bottom: 3px"  value="<?= $customer->connection_fee ?>" required>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-sm btn-primary" style="margin-right: 16px;">Save Now</button>
						</div>
					</div>
				</form>
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
