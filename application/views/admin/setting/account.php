<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Account Entry</h4>
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
				<div class="col-md-5 col-sm-6 col-lg-6">
					<form id="accountentryForm" method="post">
						<div class="row" style="margin-bottom: 3px">
							<label for="account_name" class="col-md-4">Account Name</label>
							<div class="col-md-8">
								<input type="text" name="account_name" id="account_name" class="form-control" placeholder="Account name" required>
							</div>
						</div>
						<div class="row" style="margin-bottom: 5px">
							<label for="account_desc" class="col-md-4">Account Description</label>
							<div class="col-md-8">
								<textarea name="account_desc" id="account_desc" class="form-control" style="height: 60px!important;" placeholder="Description" ></textarea>
							</div>
						</div>
						<div class="row">
							<label for="" class="col-md-4"></label>
							<div class="col-md-8">
								<input type="hidden" name="action" id="action" value="create">
								<input type="hidden" name="action_id" id="action_id">
								<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info btn-block">
								
							</div>
							
						</div>
					</form>
				</div>
				<div class="col-md-7 col-sm-6 col-lg-6">
					<table class="table table-srtaped table-bordered">
						<thead>
							<th>Serial</th>
							<th>Account Name</th>
							<th>Account Description</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php 
								if (!empty($accountlist)) {
									$j=1;
									foreach ($accountlist as $value) {
							?>
							<tr>
								<td><?php echo $j++; ?></td>
								<td><?php echo $value->account_name ?></td>
								<td><?php echo $value->account_desc ?></td>
								<td class="text-center">
									<a href="" id="edit-account" data-id="<?php echo $value->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
										<a href="" class="" id="delete-account" data-id="<?php echo $value->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
								</td>
							</tr>
						<?php }}else{ ?>
							<tr><td colspan="4" class="text-center">No Account</td></tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	
	$(document).on('submit','#accountentryForm',function(e){
		e.preventDefault();
		
		var account_name =$('#account_name','#accountentryForm').val();
		var account_desc =$('#account_desc','#accountentryForm').val();
		
		if(account_name==''){
			alert('Account name is not empty !!');
		}
		else{
			$.ajax({
				url:'<?php echo base_url("save-account") ?>',
				method:'post',
				data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data){

	            	if (data.trim()=='success') {
	            		alert('Account entry successfully !!');
	            		location.reload();
	            	}
	            	else if(data.trim()=='update'){
	            		alert('Account Update successfully !!');
	            		location.reload();
	            	}
	           
	            }
			})
		}
	})

 // edit 
    $(document).on('click','#edit-account',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url('edit-account') ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){

          $('#account_name','#accountentryForm').val(data.account_name);
          $('#account_desc','#accountentryForm').val(data.account_desc);
         
          $('#action','#accountentryForm').val('Update');
          $('#action_id','#accountentryForm').val(id);
          $('#submit','#accountentryForm').val('Update');
          
        }
      })
    })
    //delete 
    $(document).on('click','#delete-account',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url("delete-account") ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='delete') {
             alert('Expense deleted successfully !!');
              location.reload();
            }
          }
        })
      }
    })
})    
</script>