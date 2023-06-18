<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Speed Entry</h4>
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
				<div class="col-md-8 col-md-offset-2">
					<form class="form-horizontal" id="speedForm">
						<div id="output" class="text-success text-center"></div>
						<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
						<div class="col-md-5">
							<div class="form-group ">
							<label for="emp_name" class="control-label col-md-4" style="padding: 0;">Speed Name</label>
							<div class="col-md-8">
								<input type="text" name="name" id="name" class="form-control" placeholder="Speed name" required>
							</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group ">
								<label for="emp_name" class="control-label col-md-4" style="padding: 0;">Amount</label>
								<div class="col-md-8">
									<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" required>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group ">
								<input type="hidden" name="action" id="action" value="create">
								<input type="hidden" name="action_id" id="action_id">
								<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info">
							</div>
						</div>

					</form>
				</div>
			</div>
        </div>
    </div>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Speed List</h4>
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
					<table class="table table-bordered" id="dataTable">
						<div id="delete" class="text-success"></div>
						<thead>
							<th>Serial</th>
							<th>Name</th>
							<th>Amount</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							$j=1;
							if(!empty($speed_list)){ foreach($speed_list as $list){?>
							<tr>
								<td><?php echo $j++; ?></td>
								<td><?php echo $list->name; ?></td>
								<td><?php echo $list->amount; ?></td>
								<td class="text-center">
									<a href="" id="edit-speed" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
									<a href="" class="" id="delete-speed" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
	// speed insert
    $(document).on('submit','#speedForm',function(e){
        e.preventDefault();
        var action=$('#action','#speedForm').val();
        
        var base_url="<?php echo base_url('save-speed') ?>";
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
                 else if(data.trim()=='update'){
                  alert('Update successfully');
                  location.reload();
                 }
                 else{
                  $('#error').html(data);
                 }
                 
              }  
           
          });
      })

  //edit speed
    $(document).on('click','#edit-speed',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url('edit-speed') ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){
          $('#name','#speedForm').val(data.name);
          $('#amount','#speedForm').val(data.amount);
          $('#action','#speedForm').val('Update');
          $('#action_id','#speedForm').val(id);
          $('#submit','#speedForm').val('Update');
        }
      })
    })

    //delete speed
    $(document).on('click','#delete-speed',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url('delete-speed') ?>',
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
</script>