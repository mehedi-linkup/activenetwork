<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Unit Entry</h4>
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
                <form class="" id="unitForm" method="post">
                    <div id="output" class="text-success text-center"></div>
                    <div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <label for="emp_name" class="control-label col-md-3 col-sm-3 col-lg-3">Unit Name </label>
                            <div class="col-md-7 col-sm-7 col-lg-7">
                                <input type="text" name="unit_name" id="unit_name" class="form-control" style="margin-bottom: 3px;margin-top:5px" required="1">
                            </div>
                            <div class="col-md-2 col-sm-2 col-lg-2">
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
                <div class="col-md-6 col-md-offset-3">
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
                                if(!empty($units)){ foreach($units as $list){?>
                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td class="text-center"><?php echo $list->unit_name; ?></td>
                                <td class="text-center">
                                    <a href="" id="unit-edit" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                                    <a href="" class="" id="unit-delete" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
$(document).on('submit','#unitForm',function(e){
	e.preventDefault();
	var action =$('#action','#unitForm').val();
	var unit_name =$('#unit_name','#unitForm').val();
	var amount =$('#amount','#unitForm').val();
	
	if(unit_name == ''){
		alert('Choose Customer name !!');
	}
	else{
		$.ajax({
			url:'<?php echo base_url("save-unit") ?>',
			method:'post',
			data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
            	if (data.trim()=='success') {
            		alert('Unit successfully !!');
            		location.reload();
                }
                
                if(data.trim() == 'update') {
                    alert('Unit updated !!');
            		location.reload();
                }
            	
            }
		})
	}
})

//edit 

$(document).on('click', '#unit-edit', function(e) {
    e.preventDefault();
    let id = $(this).attr('data-id');
    if(id != 0) {
        $.ajax({
            url: '<?php echo base_url("unit-edit")?>',
            method: 'post',
            data: {id: id},
            dataType:'json',
            success: function(data) {
                $('#unit_name', '#unitForm').val(data.unit_name);
                $('#action_id', '#unitForm').val(id);
                $('#action', '#unitForm').val('update');
                $('#submit', '#unitForm').val('Update');
            }
        })
    }
})

// delete 

$(document).on('click', '#unit-delete', function(e) {
    e.preventDefault();
    let id = $(this).attr('data-id');

    if(confirm('Are you sure to delete ?')) {
        $.ajax({
            url: '<?php echo base_url("unit-delete")?>',
            method: 'post',
            data: { id : id},
            success: function(data) {
                if(data.trim() == 'delete') {
                    alert('unit deleted !')
                    location.reload();
                }
            }
        })
    }
})
</script>

