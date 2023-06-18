<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="row">
				<div class="col-md-6">
				<form class="form-horizontal" id="expensetypeForm">
					<div id="output" class="text-success text-center"></div>
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>

					<div class="col-md-10">
		 
						<div class="form-group ">
		              <label for="expense_name" class="control-label col-md-4">Expense Name</label>
		              <div class="col-md-8">
	                        	<input type="text" name="expense_name" id="expense_name" class="form-control" placeholder="Expense type name" required="1">
	                        </div>
		              </div>
		                
		                
					</div>
          <div class="col-md-2">
            <div class="form-group ">
                        
               <input type="hidden" name="action" id="action" value="create">
               <input type="hidden" name="action_id" id="action_id">
               <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info ">
            </div>
                    
          </div>

				</form>
			</div>
			</div>
		<div class="row">
		<div class="col-md-6">
			<table class="table table-bordered" id="dataTable">
				<div id="delete" class="text-success"></div>
				<thead>
					<th>Serial</th>
					<th>Name</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php
					$j=1;
					 if(!empty($expenselist)){ foreach($expenselist as $list){?>
					<tr>
						<td><?php echo $j++; ?></td>
						<td><?php echo $list->expense_name; ?></td>
						<td class="text-center">
							<a href="" id="edit-exp-type" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
             				<a href="" class="" id="delete-exp-type" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
$(document).on('submit','#expensetypeForm',function(e){
        e.preventDefault();
        var action=$('#action','#expensetypeForm').val();
        var expense_name=$('#expense_name','#expensetypeForm').val();
        var base_url="<?php echo base_url('save-expense-type') ?>";
        if (expense_name =='') {
        	alert("Please fill up expense name !");
        }else{
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
                 
              }  
          	});
        }
          
      })

  //edit area
    $(document).on('click','#edit-exp-type',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url('edit-expense-type') ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){
          $('#expense_name','#expensetypeForm').val(data.expense_name);
          $('#action','#expensetypeForm').val('Update');
          $('#action_id','#expensetypeForm').val(id);
          $('#submit','#expensetypeForm').val('Update');
        }
      })
    })
    //delete area
    $(document).on('click','#delete-exp-type',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url("delete-expense-type") ?>',
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