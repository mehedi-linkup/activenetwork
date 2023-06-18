<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Month Entry</h4>
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
				<div class="col-md-6 col-md-offset-3">
					<form class="form-horizontal" id="monthForm">
						<div id="output" class="text-success text-center"></div>
						<div class="col-md-10">
							<div class="form-group">
								<label for="emp_name" class="control-label col-md-3">Month Name</label>
								<div class="col-md-7">
									<input type="text" name="month_name" id="month_name" class="form-control" placeholder="Month name" required="1">
								</div>
								<div class="col-md-2">
									<input type="hidden" name="action" id="action" value="create">
									<input type="hidden" name="action_id" id="action_id">
									<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info ">
								</div>
							</div>
						</div>
					
					</form>
				</div>
			</div>
			<div class="row">
				<hr>
				<div class="col-md-6 col-md-offset-3">
					<table class="table table-bordered" id="monthTable">
						<thead>
						<th>Serial</th>
						<th>Name</th>
						<th>Sratus</th>
						<th class="text-center">Action</th>
						</thead>
						<tbody>
						<?php 
							if (!empty($month)) {
							$j=1;
							foreach($month as $list){
							
						?>
						<tr>
							<td><?php echo $j++; ?></td>
							<td><?php echo $list->month_name; ?></td>
							<td class="text-center">
							<?php 
								$status='';
								if ($list->status=='a') {
								$status='Active';
								}else if($list->status=='i'){
								$status='Inactive';
								}
							?>
							<a href="" data-id="<?php echo $list->id ?>" id="status" class="btn btn-xs <?php echo ($list->status == 'i') ? 'btn-danger' : 'btn-info'?>"><?php echo $status ?></a>
							</td>
							<td class="text-center">
							<a href="" id="edit-month" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
									<a href="" class="" id="delete-month" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
							</td>
						</tr>
						<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){

    //add month
    $(document).on('submit','#monthForm',function(e){
        e.preventDefault();
        var action=$('#action','#monthForm').val();
        var base_url='<?php echo base_url('save-month') ?>';
          $.ajax({
              url:base_url,
              method:'post',
              data:new FormData(this),
              contentType:false,
              processData:false,
              success: function(data){
                if (data.trim()=='success') {
                  
                  alert('Save successfully');
                  location.reload();
                }
                else if (data.trim()=='updated') {
                  alert('Update successfully');
                  location.reload();
                }
                else{
                  alert(data);
                }
                
              }
          });
      
      })
    // edit month
    $(document).on('click','#edit-month',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
    
      //alert(id)
      $.ajax({
        url:'<?php echo base_url('edit-month') ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){

          $('#month_name','#monthForm').val(data.month_name);
          $('#action','#monthForm').val('Update');
          $('#action_id','#monthForm').val(id);
          $('#submit','#monthForm').val('Update');
          
        }
      })
    })
    //delete month
    $(document).on('click','#delete-month',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url('delete-month') ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='deleted') {
              alert('Deleted successfully');
              location.reload();
            }
          }
        })
      }
    })
    //month status
    $(document).on('click','#status',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to change status ?')) {
        $.ajax({
          url:'<?php echo base_url('month-status') ?>',
          method:'post',
          data:{id:id},
          success:function(data){
              alert('Status update successfully !')
              location.reload();
           
          }
        })
      }
    })

  });
  
</script>