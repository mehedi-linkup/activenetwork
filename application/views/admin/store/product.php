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
        <h4 class="widget-title">Metarial  Entry</h4>
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
                <form id="productForm" method="post">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row">
                            <?php 
                                $code='P';
                                $Id = $code.'00001';
                                $lastCode = $this->db->query("select id from tbl_product order by id desc limit 1");
                            
                                if (!empty($lastCode)) {
                                    $lastCode = $lastCode->row()->id + 1;
                                    $zeros = array('0', '00', '000', '0000');
                                    $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
                                }

                            ?>
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Metarial Id </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="code" id="code" class="form-control" style="margin-bottom: 3px;" required="1" value="<?php echo $Id?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Metarial Name </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="product_name" id="product_name" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Category </label>
                                <div class="col-md-7 col-sm-7 col-lg-7">
                                    <select id="category_id" name="category_id" class="form-control js-example-basic-single" required>
                                        <option value="0">Select Cateogy</option>
                                        <?php 
                                            $categories=$this->db->query("select id,category_name from tbl_category where status ='a'")->result();
                                            foreach ($categories as  $category) {
                                            ?>
                                            <option value="<?php echo $category->id ?>"><?php echo $category->category_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'category' ?>" target="_blanck" style="position: relative;left: -27px;height: 25px;" class="btn btn-info"><span style="position: absolute;top: -5px;left: 30%;font-size: 20px;">+</span></a></div>
                            </div>
                            <div class="row" style="margin-bottom:3px">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Unit </label>
                                <div class="col-md-7 col-sm-7 col-lg-7">
                                    <select id="unit_id" name="unit_id" class="form-control js-example-basic-single" required>
                                        <option value="0">Select Unit</option>
                                        <?php 
                                            $unites=$this->db->query("select id,unit_name from tbl_unit where status ='a'")->result();
                                            foreach ($unites as  $unit) {
                                            ?>
                                            <option value="<?php echo $unit->id ?>"><?php echo $unit->unit_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'unit' ?>" target="_blanck" style="position: relative;left: -27px;height: 25px;" class="btn btn-info"><span style="position: absolute;top: -5px;left: 30%;font-size: 20px;">+</span></a></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Vat </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="vat" id="vat" class="form-control" style="margin-bottom: 3px;">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Re-order Level </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="order_level" id="order_level" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4">Purchase Rate </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="text" name="purchase_rate" id="purchase_rate" class="form-control" style="margin-bottom: 3px;" required="1">
                                </div>
                            </div>
                            <div class="row">
                                <label for="code" class="control-label col-md-4 col-sm-4 col-lg-4"> </label>
                                <div class="col-md-8 col-sm-8 col-lg-8">
                                    <input type="hidden" id="action" name="action" value="create">
                                    <input type="hidden" id="action_id" name="action_id">
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
        <h4 class="widget-title">Metarial List</h4>
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
                            <th>Metarial</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Purchase Rate</th> 
                            <th>Vat</th> 
                            <th>Re-order Level</th> 
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                                $j=1;
                                if(!empty($products)){ foreach($products as $list){?>
                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td><?php echo $list->code; ?></td>
                                <td><?php echo $list->product_name; ?></td>
                                <td><?php echo $list->category_name; ?></td>
                                <td><?php echo $list->unit_name; ?></td>
                                <td class="text-right"><?php echo $list->purchase_rate; ?></td>
                                <td class="text-right"><?php echo $list->vat; ?></td>
                                <td class="text-right"><?php echo $list->order_level; ?></td>
                                <td class="text-center">
                                    <a href="" id="product-edit" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                                    <a href="" class="" id="product-delete" data-id="<?php echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
$(document).on('submit', '#productForm', function(e) {
    e.preventDefault();
    
    let category = $('#category_id', '#productForm').val();
    let unit = $('#unit_id', '#productForm').val();

    if(category == 0) {
        alert('Select category !');
        return;
    }

    if(unit == 0) {
        alert('Select unit');
        return;
    }

    $.ajax({
        url: '<?php echo  base_url("save-product")?>',
        method: 'post',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data){
            if (data.trim()=='insert') {
                alert('Metarial successfully !!');
                location.reload();
            }
            
            if(data.trim() == 'update') {
                alert('Metarial updated !!');
                location.reload();
            }
            
        }
    })
})

$(document).on('click', '#product-edit', function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    if(id != 0) {
        $.ajax({
            url: '<?php echo base_url("edit-product")?>',
            method: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(data) {
                // alert(data);
                $('#code', '#productForm').val(data.code);
                $('#product_name', '#productForm').val(data.product_name);
                $('#vat', '#productForm').val(data.vat);
                $('#order_level', '#productForm').val(data.order_level);
                $('#purchase_rate', '#productForm').val(data.purchase_rate);

                $('#category_id').find('option:not(:selected)').removeAttr('selected');
                $('#category_id').find('option[value="'+ data.category_id +'"]').attr('selected', 'selected').trigger('change');
                $('#unit_id').find('option:not(:selected)').removeAttr('selected');
                $('#unit_id').find('option[value="'+ data.unit_id +'"]').attr('selected', 'selected').trigger('change');

                $('#action', '#productForm').val('update'); 
                $('#action_id', '#productForm').val(id); 
                $('#submit', '#productForm').val('Update'); 
            }
        })
    }
})

$(document).on('click', '#product-delete', function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    if(confirm('Are you sure to delete ?')) {
        $.ajax({
            url: "<?php echo base_url('delete-product')?>",
            method: 'post',
            data: {id: id},
            success: function(data) {
                alert(data);
            }
        })
    }
})
</script>