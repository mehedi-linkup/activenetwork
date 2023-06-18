<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Area Entry</h4>
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
					<form class="form-horizontal" id="areaForm">
						<div id="output" class="text-success text-center"></div>
						<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
						<div class="col-md-5">
					
							<div class="form-group ">
							<label for="emp_name" class="control-label col-md-4">Area Code</label>
							<div class="col-md-8">
								<input type="text" name="area_code" id="area_code" class="form-control" placeholder="Area code" required>
							</div>
							</div>
									
									
						</div>
						<div class="col-md-5">
							<div class="form-group ">
								<label for="emp_name" class="control-label col-md-4">Area Name</label>
								<div class="col-md-8">
									<input type="text" name="name" id="name" class="form-control" placeholder="Area name" required>
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
        <h4 class="widget-title">Area List</h4>
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
							<th>Code</th>
							<th>Name</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							$j=1;
							if(!empty($area_list)){ foreach($area_list as $list){?>
							<tr>
								<td><?php echo $j++; ?></td>
								<td><?php echo $list->area_code; ?></td>
								<td><?php echo $list->name; ?></td>
								<td class="text-center">
									<a href="" id="edit-area" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
									<a href="" class="" id="delete-area" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
	// area insert
$(document).on('submit','#areaForm',function(e){
        e.preventDefault();
        var action=$('#action','#areaForm').val();
        
        var base_url="<?php echo base_url('save-area') ?>";
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

  //edit area
    $(document).on('click','#edit-area',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url('edit-area') ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){
          $('#name','#areaForm').val(data.name);
          $('#area_code','#areaForm').val(data.area_code);
          $('#action','#areaForm').val('Update');
          $('#action_id','#areaForm').val(id);
          $('#submit','#areaForm').val('Update');
        }
      })
    })
    //delete area
    $(document).on('click','#delete-area',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url('delete-area') ?>',
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