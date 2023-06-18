<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Company Profile</h4>
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
                    <form class="form-horizontal" id="companyprofileForm" enctype="multipart/form-data">
                        <div id="output" class="text-success text-center"></div>
                        <div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>

                        <div class="col-md-6 col-md-offset-3">
                                    
                            <div>
                                <label for="com_name" class="control-label col-md-4">Company Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="com_name" id="com_name" class="form-control" placeholder="Company Name" style="margin-bottom: 5px" value="<?php echo $cominfo->com_name ?>">
                                </div>
                            </div>
                            <div>
                                <label for="email" class="control-label col-md-4">E-mail</label>
                                <div class="col-md-8">
                                    <input type="email" name="com_email" id="com_email" class="form-control" placeholder="E-mail" style="margin-bottom: 5px" value="<?php echo $cominfo->com_email ?>">
                                </div>
                            </div>
                            <div>
                                <label for="phone" class="control-label col-md-4">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" name="com_phone" id="com_phone" class="form-control" placeholder="Phone" style="margin-bottom: 5px" value="<?php echo $cominfo->com_phone ?>">
                                </div>
                            </div>
                            <div>
                                <label for="designation" class="control-label col-md-4">Address</label>
                                <div class="col-md-8">
                                    <textarea id="com_address" name="com_address" class="form-control" style="height: 60px !important;margin-bottom: 10px"><?php echo $cominfo->com_address ?></textarea>
                                </div>
                            </div>
                            <div>
                                <label for="website" class="control-label col-md-4">Website</label>
                                <div class="col-md-8">
                                    <input type="text" name="website" id="website" class="form-control" placeholder="Website" style="margin-bottom: 5px" value="<?php echo $cominfo->website ?>">
                                </div>
                            </div>
                            <div>
                                <label for="image" class="control-label col-md-4">Company Logo</label>
                                <div class="col-md-6">
                                    <input type="file" name="picture">
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo base_url().'assets/backend/images/'.$cominfo->com_logo ?>" style="height: 50px;width:60px">
                                </div>
                            </div>
                            <div>
                                <label class="control-label col-md-4"></label>
                                <div class="col-md-8">
                                    <input type="hidden" name="id" id="id" value="<?php echo $cominfo->id ?>">
                                    <input type="hidden" name="action" id="action" value="update">
                                    <input type="hidden" name="old_image" id="old_image" value="<?php echo $cominfo->com_logo ?>">
                                    <input type="submit" name="submit" value="Update" class="btn btn-info">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {
		$(document).on('submit','#companyprofileForm',function(e){
			e.preventDefault();
			
			$.ajax({
				url:'<?php echo base_url("update-profile") ?>',
				method:'post',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success: function(data){
					if (data.trim()=='update') {
						location.reload();
					}
					else{
						$('#error').html(data);
					}
				}
			})
		})
	})

</script>
