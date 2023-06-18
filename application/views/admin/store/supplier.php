<style>
    .content-section{
        background: #ddd;
        width: 100%;
        padding: 10px;
        color: #000;
        font-size: 14px;
        font-weight: 500;
    }
</style>

<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Supplier Entry</h4>
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
                <form id="supplierForm" method="post">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row">
                            <?php 
                                $code='S';
                                $Id = $code.'00001';
                                $lastCode = $this->db->query("select id from tbl_supplier order by id desc limit 1");
                            
                                if (!empty($lastCode)) {
                                    $lastCode = $lastCode->row()->id + 1;
                                    $zeros = array('0', '00', '000', '0000');
                                    $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
                                }
    
                            ?>
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Supplier Id </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="code" id="code" class="form-control" style="margin-bottom: 3px;" required="1" value="<?php echo $Id?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="name" class="control-label col-md-4 col-sm-4 col-lg-4">Supplier Name </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="name" id="name" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                            <div class="row">
                                <label for="mobile" class="control-label col-md-4 col-sm-4 col-lg-4">Mobile </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="mobile" id="mobile" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                            <div class="row">
                                <label for="email" class="control-label col-md-4 col-sm-4 col-lg-4">E-mail </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="email" id="email" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row">
                                <label for="owner_name" class="control-label col-md-4 col-sm-4 col-lg-4">Owner Name </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="owner_name" id="owner_name" class="form-control" style="margin-bottom: 3px;">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Address </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="address" id="address" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Previous Due </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="number" name="previous_due" id="previous_due" class="form-control" style="margin-bottom: 3px;">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Image </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                   <input type="file" name="image" id="image">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4"> </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                  <div id="show-image"></div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4"> </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="hidden" id="action" name="action" value="create">
                                    <input type="hidden" id="action_id" name="action_id">
                                    <input type="hidden" name="old_image" id="old_image">
                                    <input type="submit" name="submit" id="submit" class="btn btn-info btn-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Supplier List</h4>
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
                <div class="col-md-12">
                    <table class="table table-bordered" id="dataTable">
                        <div id="delete" class="text-success"></div>
                        <thead>
                            <th>Serial</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>E-mail</th>
                            <th>Owner Name</th> 
                            <th>Address</th> 
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                                $j=1;
                                if(!empty($suppliers)){ foreach($suppliers as $list){?>
                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td><?php echo $list->code; ?></td>
                                <td><?php echo $list->name; ?></td>
                                <td><?php echo $list->mobile; ?></td>
                                <td><?php echo $list->email; ?></td>
                                <td ><?php echo $list->owner_name; ?></td>
                                <td><?php echo $list->address; ?></td>
                                <td class="text-center">
                                    <a href="" id="supplier-edit" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                                    <a href="" class="" id="supplier-delete" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
$(document).on('submit', '#supplierForm', function(e) {
    e.preventDefault();

    $.ajax({
        url: '<?php echo  base_url("save-supplier")?>',
        method: 'post',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data){
            if (data.trim()=='insert') {
                alert('Supplier successfully !!');
                location.reload();
            }
            
            if(data.trim() == 'update') {
                alert('Supplier updated !!');
                location.reload();
            }
            
        }
    })
})

$(document).on('click', '#supplier-edit', function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    let img_url = '<?php echo base_url("assets/backend/images/")?>';
    if(id != 0) {
        $.ajax({
            url: '<?php echo base_url("edit-supplier")?>',
            method: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(data) {
                // alert(data);
                $('#code', '#supplierForm').val(data.code);
                $('#name', '#supplierForm').val(data.name);
                $('#mobile', '#supplierForm').val(data.mobile);
                $('#email', '#supplierForm').val(data.email);
                $('#owner_name', '#supplierForm').val(data.owner_name);
                $('#address', '#supplierForm').val(data.address);
                $('#previous_due', '#supplierForm').val(data.previous_due);
                $('#old_image','#supplierForm').val(data.image);
                $('#show-image').html('<img src="'+img_url+data.image+'" style="height:40px;width:40px;margin-bottom:1px"/>');
                $('#action', '#supplierForm').val('update'); 
                $('#action_id', '#supplierForm').val(id); 
                $('#submit', '#supplierForm').val('Update'); 
            }
        })
    }
})

$(document).on('click', '#supplier-delete', function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    if(confirm('Are you sure to delete ?')) {
        $.ajax({
            url: "<?php echo base_url('delete-supplier')?>",
            method: 'post',
            data: {id: id},
            success: function(data) {
                alert('Deleted successfully !');
                location.reload();
            }
        })
    }
})
</script>