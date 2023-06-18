<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Customer Entry</h4>
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
				<div class="col-md-12 col-sm-12 col-lg-12">
					<form class="" id="customerForm">
						<div id="output" class="text-success text-center"></div>
						<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<div>
								<label for="cust_id" class="control-label col-md-4 col-sm-4">Customer Id : </label>
								<div class="col-md-8 col-sm-8">
									<input type="text" name="cust_id" id="cust_id" class="form-control"  style="margin-bottom: 3px"  placeholder="Id" required>
								</div>
							</div>
							<div>
								<label for="nid" class="control-label col-md-4 col-sm-4">NID : </label>
								<div class="col-md-8 col-sm-8">
									<input type="text" name="nid" id="nid" class="form-control"  style="margin-bottom: 3px"  placeholder="Nid">
								</div>
							</div>
							<div>
								<label for="cust_name" class="control-label col-md-4 col-sm-4">Customer Name : </label>
								<div class="col-md-8 col-sm-8">
									<input type="text" name="cust_name" id="cust_name" class="form-control" placeholder="Name" style="margin-bottom: 3px" required >
								</div>
							</div>
							<div> 
								<label for="cust_father_name" class="control-label col-md-4 col-sm-4" style="padding-right: 0;">Father's/ Husband Name:</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" name="cust_father_name" id="cust_father_name" class="form-control" placeholder="Father / Husband name" style="margin-bottom: 3px">
								</div>
							</div>
							<div>
								<label for="c_name" class="control-label col-md-4 col-sm-4">Phone : </label>
								<div class="col-md-8 col-sm-8">
									<input type="text" name="cust_phone" id="cust_phone" class="form-control" placeholder="Phone" style="margin-bottom: 3px" required>
								</div>
							</div>
							<div>
								<label for="emp_name" class="control-label col-md-4 col-sm-4">E-mail :</label>
								<div class="col-md-8 col-sm-8">
									<input type="email" name="cust_email" id="cust_email" class="form-control" placeholder="E-mail" style="margin-bottom: 3px">
								</div>
							</div>
	
							<div>
								<label for="emp_name" class="control-label col-md-4 col-sm-4">Address :</label>
								<div class="col-md-8 col-sm-8">
									<textarea class="form-control" name="cust_address" id="cust_address" placeholder="Address" required style="margin-bottom: 3px;height:60px !important"></textarea>
								</div>
							</div>

							<div>
								<label for="emp_name" class="control-label col-md-4 col-sm-4">Officer :</label>
								<div class="col-md-7 col-sm-7" style="margin-bottom: 3px;">
									<select id="officer_id" name="officer_id" class="form-control js-example-basic-single" required>
										<option>Select Officer</option>
										<?php 
											$emplyees=$this->db->query("select id,emp_name from tbl_emplyee where status ='a'")->result();
											foreach ($emplyees as  $emp) {
										 ?>
										 <option value="<?php echo $emp->id ?>"><?php echo $emp->emp_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'employee' ?>" target="_blanck" style="position: relative;left: -15px;height: 25px;" id="employee" class="btn btn-info"><span style="position: absolute;top: -5px;left: 25%;font-size: 20px;">+</span></a></div>
							</div>

							<div>
								<label for="emp_name" class="control-label col-md-4 col-sm-4">Area :</label>
								<div class="col-md-7 col-sm-7">
									<select id="area_id" name="area_id" class="form-control js-example-basic-single" style="margin-bottom: 3px" required>
										<option>Select Area</option>
										
									</select>
									<div style="margin:3px 0px;"></div>
								</div>
								<div class="col-md-1 col-sm-1"><a href="<?php echo base_url().'area' ?>" target="_blanck" style="position: relative;left: -15px;height: 25px;" id="area" class="btn btn-info"><span style="position: absolute;top: -5px;left: 25%;font-size: 20px;">+</span></a></div>
							</div>
						</div>
	
						<div class="col-sm-6 col-md-6 col-lg-6">
							
							<div>
								<label for="emp_name" class="control-label col-md-4 col-sm-4">Connection Date :</label>
								<div class="col-md-8 col-sm-8">
									<input type="date" name="entry_date" id="entry_date" class="form-control" placeholder="Date" style="margin-bottom: 3px" required="1" value="<?php echo date('Y-m-d') ?>">
								</div>
							</div>
							<div>
								<label for="reconn_date" class="control-label col-md-4 col-sm-4">Re-Connection Date :</label>
								<div class="col-md-8 col-sm-8">
									<input type="date" name="reconn_date" id="reconn_date" class="form-control" placeholder="Reconnection Date" style="margin-bottom: 3px">
								</div>
							</div>
							<div>
								<label for="inactive_date" class="control-label col-md-4 col-sm-4">Inactive Date :</label>
								<div class="col-md-8 col-sm-8">
									<input type="date" name="inactive_date" id="inactive_date" class="form-control" placeholder="Inactive Date" style="margin-bottom: 3px">
								</div>
							</div>
							<div>
								<div class="col-md-4 col-sm-4"><span>Month Fee :</span></div>
								<div class="col-md-2 col-sm-2">
									<input type="checkbox" name="dish_month_fee" id="dish_month_fee"> &nbsp; Dish
								</div>
								<div class="col-md-6 col-sm-6">
									<input type="number" name="dish_amount" id="dish_amount" class="form-control" disabled style="width:100%;margin-bottom:3px">
								</div>							
							</div>
							<div>
								<div class="col-md-4 col-md-4"></div>						
								<div class="col-md-2 col-sm-2">
									<input type="checkbox" name="wifi_month_fee" id="wifi_month_fee"> &nbsp; Wifi
								</div>
															
								<div class="col-md-3 col-sm-3">
									<select name="speed_id" class="form-control" id="speed_id" style="margin-bottom:3px !important;padding:0px" disabled>
										<option>Select Speed</option>
										<?php 
											$speed=$this->db->query("select id,name,amount from tbl_speed where status ='a'")->result();
											foreach ($speed as  $sp) {
										 ?>
										 <option data-id="<?php echo $sp->amount?>" value="<?php echo $sp->id ?>"><?php echo $sp->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3 col-sm-3">
									<input type="number" name="wifi_amount" id="wifi_amount" disabled class="form-control" style="width:100%;margin-bottom:3px">
								</div>
							</div>
	
							<!-- <div>
								<div class="col-md-4 col-md-4"><span>Quantity:</span></div>
								<div class="col-md-2 col-sm-2">
									<input type="checkbox" name="dish_qty" id="dish_qty" value="dish" disabled> &nbsp; Dish
								</div>
								<div class="col-md-2 col-sm-2">
									<input type="number" name="dish_quantity" id="dish_quantity" class="form-control" disabled style="width: 80px !important;margin-left: -25px !important; margin-bottom:3px">
								</div>
								<div class="col-md-2 col-sm-2">
									<input type="checkbox" name="wifi_qty" id="wifi_qty" disabled> &nbsp; Wifi
								</div>
								<div class="col-md-2 col-sm-2">
									<input type="number" name="wifi_quantity" id="wifi_quantity" disabled class="form-control" style="width: 80px !important;margin-left: -25px !important; margin-bottom:3px">
								</div>
							</div> -->
	
							 <div>
								<label for="total_amount" class="control-label col-md-4 col-sm-4">Total Amount :</label>
								<div class="col-md-4 col-sm-4">
									<input type="number" id="dish_total" name="dish_total" class="form-control" placeholder="Dish total" require readonly style="margin-bottom:3px">
								</div>
								<div class="col-md-4 col-sm-4">
									<input type="number" id="wifi_total" name="wifi_total" class="form-control" placeholder="Wifi total" require readonly style="margin-bottom:3px">
								</div>
							</div>
							
							<div>
								<label for="connection_fee" class="control-label col-md-4 col-sm-4">Connection Fee :</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" name="connection_fee" id="connection_fee" class="form-control" placeholder="Connection Fee" style="margin-bottom: 3px;margin-top: 3px" required>
								</div>
							</div>
							<div>
								<label for="emp_name" class="control-label col-md-4 col-sm-4">Type :</label>
								<div class="col-md-4 col-sm-4">
									<div class="checkbox">
									 <input type="checkbox" id="type" checked name="type" value="active" style="margin-bottom: 5px">Dish Active
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="checkbox">
										<input type="checkbox" id="wifi_is_active" name="wifi_is_active"  value="active" style="margin-bottom: 5px">Wifi Active
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label for="emp_name" class="control-label col-md-4 col-sm-4"></label>
								<div class="col-md-8 col-sm-8">
									<input type="hidden" name="action" id="action" value="create">
									<input type="hidden" name="action_id" id="action_id">
									<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info btn-block">
								</div>
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
        <h4 class="widget-title">Customer List</h4>
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
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <table class="table table-bordered" id="dataTable">
                        <div id="delete" class="text-success"></div>
                        <thead>
                            <th>Cust. Id</th>
                            <th>Cust. Name</th>
                            <th>Phone</th>
                            <th>Address</th>			
                            <th colspan="2">Month Fee</th>
                            <th>Dish</th>
                            <th>Wifi</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php if(!empty($cust_list)){ foreach($cust_list as $list){?>
                            <tr>
                                <td><?php echo $list->cust_id; ?></td>
                                <td><?php echo $list->cust_name; ?></td>
                                <td><?php echo $list->cust_phone; ?></td>
                                <td><?php echo $list->cust_address; ?></td>
                                <td><?php echo $list->dish_total; ?></td>
                                <td><?php echo $list->wifi_total; ?></td>
                                <td class="text-center"><a href="" id="change-type" data-id="<?php echo $list->id ?>" class="btn btn-xs <?php echo ($list->type == 'Inactive') ? 'btn-danger' : 'btn-info'?>"><?php echo $list->type; ?></a></td>
                                <td class="text-center"><a href="" id="wifi-type" data-id="<?php echo $list->id ?>" class="btn btn-xs <?php
                                    if($list->wifi_is_active == 'active') {
                                        echo 'btn-info';
                                    } 
                                    else if($list->wifi_is_active == 'Inactive') {
                                        echo 'btn-danger';
                                    } 
                                    else if($list->wifi_is_active == null) {
                                        echo 'btn-default';
                                    }
                                     
                                 ?>"><?php echo $list->wifi_is_active; ?></a></td>
                                <td class="text-center">
                                    <a href="" id="edit-cust" data-id="<?php echo $list->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                                     <!-- <a href="" class="" id="delete-cust" data-id="<?php // echo $list->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a> -->
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
	$(document).ready(function() {
		// get area
		$(document).on('change', '#officer_id', function(e) {
			e.preventDefault()
			var officerId = $('#officer_id').val();
			$.ajax({
				url:'<?php echo base_url('officer-area') ?>',
				method:'post',
				data:{officerId:officerId},
				dataType: 'json',
				success:function(data){
					let opt = '<option value="">Select area</option>';
					
					if(data.length > 0) {
						data.forEach(item => {
							opt = `<option value="${item.id}">${item.name}</option>`;
						})
					}

					$('#area_id').html(opt);
				}
			})
		
		})

		// set wifi amount 

		$(document).on('change', '#speed_id', function(e) {
			e.preventDefault();
			var amount = $(this).find(':selected').data('id')
			$('#wifi_amount').val(amount)
			$('#wifi_total').val(amount);
		})

		
		// monthly fee
		$(document).on('click', '#dish_month_fee', function(){
			if ($(this).is(':checked')) {
				$('#dish_amount').prop('disabled', false)
			} else {
				$('#dish_amount').prop('disabled', true)
			}
		})
	
		$(document).on('click', '#wifi_month_fee', function() {
			if ($(this).is(':checked')) {
				$('#wifi_amount, #speed_id').prop('disabled', false)
			} else {
				$('#wifi_amount, #speed_id').prop('disabled', true)
			}
		})
	
		//monthly dish bill total
		$(document).on('input', '#dish_amount', function() {
			let amount = $('#dish_amount').val();
			$('#dish_total').val(amount);
		})
	
		//monthly wifi bill total
		$(document).on('input', '#wifi_amount', function() {
			let amount = $('#wifi_amount').val();
			$('#wifi_total').val(amount);
		})
	
		//customer insert
		$(document).on('submit','#customerForm',function(e){
			e.preventDefault();

			var base_url="<?php echo base_url('save-cust') ?>";
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
		// edit customer
		$(document).on('click','#edit-cust',function(e){
			  e.preventDefault();
			  var id= $(this).attr('data-id');
			  if (id == 0 && id == undefined) {
			  alert('Customer id is not null !')
			  return;
			  }
	
			$.ajax({
			url:'<?php echo base_url('edit-cust') ?>',
				method:'post',
				data:{id:id},
				dataType:'json',
				success: function(data){
					// console.log(data);
				$('#cust_id','#customerForm').val(data.cust_id);
				$('#nid','#customerForm').val(data.nid);
				$('#cust_name','#customerForm').val(data.cust_name);
				$('#cust_father_name','#customerForm').val(data.cust_father_name);
				$('#cust_phone','#customerForm').val(data.cust_phone);
				$('#cust_email','#customerForm').val(data.cust_email);
				$('#cust_address','#customerForm').val(data.cust_address);
				$('#officer_id','#customerForm').val(data.officer_id);
	
				$('#area_id').find('option:not(:selected)').removeAttr('selected');
				$('#area_id').find('option[value="'+ data.area_id +'"]').attr('selected', 'selected').trigger('change');
	
				$('#officer_id').find('option:not(:selected)').removeAttr('selected');
				$('#officer_id').find('option[value="'+ data.officer_id +'"]').attr('selected', 'selected').trigger('change');
	
				if ('active' == data.type) {
					$('#type', '#customerForm').prop('checked', true)
				} else {
					$('#type', '#customerForm').prop('checked', false)
				}
	
				if ('active' == data.wifi_is_active) {
					$('#wifi_is_active', '#customerForm').prop('checked', true)
				} else {
					$('#wifi_is_active', '#customerForm').prop('checked', false)
				}
	
				$('#wifi_amount, #speed_id').prop('disabled', false);
				$('#entry_date','#customerForm').val(data.entry_date);
				$('#dish_amount','#customerForm').val(data.dish_amount);
				$('#wifi_amount','#customerForm').val(data.wifi_amount);
				$('#reconn_date','#customerForm').val(data.reconn_date);
				$('#inactive_date','#customerForm').val(data.inactive_date);
				$('#speed_id','#customerForm').val(data.speed_id);
				$('#dish_total','#customerForm').val(data.dish_total);
				$('#wifi_total','#customerForm').val(data.wifi_total);
				$('#connection_fee','#customerForm').val(data.connection_fee);
	
	
				$('#action','#customerForm').val('Update');
				$('#action_id','#customerForm').val(id);
				$('#submit','#customerForm').val('Update');
				}
		  })
		})
		//delete customer
		$(document).on('click','#delete-cust',function(e){
		  e.preventDefault();
		  var id=$(this).attr('data-id');
		  if (confirm('Are you sure to delete this ?')) {
			$.ajax({
			  url:'<?php echo base_url('delete-cust') ?>',
			  method:'post',
			  data:{id:id},
			  success:function(data){
				if (data.trim()=='deleted') {
				  $('#delete').html('Deleted successfully');
				  location.reload();
				}
			  }
			})
		  }
		})
	
		//type customer
		$(document).on('click','#change-type',function(e){
		  e.preventDefault();
		  var id=$(this).attr('data-id');
			  if (confirm('Are you sure to change type ?')) {
				$.ajax({
				  url:'<?php echo base_url('change-type') ?>',
				  method:'post',
				  data:{id:id},
				  success:function(data){
					if (data.trim()=='update') {
					  alert('Updated successfully');
					  location.reload();
					}
				  }
				})
			}
		})
		
		//wifi-type 
		$(document).on('click', '#wifi-type', function(e) {
			e.preventDefault();
			var id = $(this).attr('data-id');
			
			if (confirm('Are you sure to change type ?')) {
				$.ajax({
				  url:'<?php echo base_url("change-wifi-type") ?>',
				  method:'post',
				  data:{id:id},
				  success:function(data){
					if (data.trim()=='update') {
					  alert('Updated successfully');
					  location.reload();
					}
				  }
				})
			}
		})
	})
</script>

