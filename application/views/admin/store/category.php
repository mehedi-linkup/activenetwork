<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Category Entry</h4>
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
                <form class="" id="categoryForm" method="post">
                    <div id="output" class="text-success text-center"></div>
                    <div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4">Category Name </label>
                            <div class="col-md-8 col-sm-8 col-lg-8">
                                <input type="text" name="category_name" id="category_name" class="form-control" style="margin-bottom: 3px;margin-top:5px" required="1">
                            </div>
                        </div>
                        <div class="row">
                            <label for="d" class="control-label col-md-4">Description </label>
                            <div class="col-md-8 col-sm-8 col-lg-8">
                                
                                <textarea name="description" id="description" class="form-control" placeholder="Description" style="height:60px !important; margin-bottom:3px"></textarea>
                            </div>
                        </div>
                        <div class="row form-group ">
                            <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4"></label>
                            <div class="col-md-8 col-sm-8 col-lg-8">
                                <input type="hidden" name="action" id="action" value="create">
                                <input type="hidden" name="action_id" id="action_id">
                                <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success btn-block">

                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-bordered" id="dataTable">
                    <div id="delete" class="text-success"></div>
                    <thead>
                        <th>Serial</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </thead>
                        <tbody>
                            <?php
                                $j=1;
                                if(!empty($categories)){ foreach($categories as $list){?>
                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td><?php echo $list->category_name; ?></td>
                                <td><?php echo $list->description; ?></td>
                                <td class="text-center">
                                    <a href="" id="category-edit" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                                    <a href="" class="" id="category-delete" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
$(document).on('submit','#categoryForm',function(e){
	e.preventDefault();
	var action =$('#action','#categoryForm').val();
	var customer_name =$('#customer_name','#categoryForm').val();
	var amount =$('#amount','#categoryForm').val();
	
	if(customer_name==0){
		alert('Choose Customer name !!');
	}
	else{
		$.ajax({
			url:'<?php echo base_url("save-category") ?>',
			method:'post',
			data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
            	if (data.trim()=='success') {
            		alert('Category successfully !!');
            		location.reload();
                }
                
                if(data.trim() == 'update') {
                    alert('Category updated !!');
            		location.reload();
                }
            	
            }
		})
	}
})

//edit 

$(document).on('click', '#category-edit', function(e) {
    e.preventDefault();
    let id = $(this).attr('data-id');
    if(id != 0) {
        $.ajax({
            url: '<?php echo base_url("category-edit")?>',
            method: 'post',
            data: {id: id},
            dataType:'json',
            success: function(data) {
                $('#category_name', '#categoryForm').val(data.category_name);
                $('#description', '#categoryForm').val(data.description);
                $('#action_id', '#categoryForm').val(id);
                $('#action', '#categoryForm').val('update');
                $('#submit', '#categoryForm').val('Update');
            }
        })
    }
})

// delete 

$(document).on('click', '#category-delete', function(e) {
    e.preventDefault();
    let id = $(this).attr('data-id');

    if(confirm('Are you sure to delete ?')) {
        $.ajax({
            url: '<?php echo base_url("category-delete")?>',
            method: 'post',
            data: { id : id},
            success: function(data) {
                if(data.trim() == 'delete') {
                    alert('Category deleted !')
                    location.reload();
                }
            }
        })
    }
})
</script>

