
<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">User Entry</h4>
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
            <div class="col-md-10 col-sm-12 col-lg-12">
				<form class="form-horizontal" id="createadministatorForm" enctype="multipart/form-data">
					<div id="output" class="text-success text-center"></div>
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>

					<div class="col-md-6">
						<div>
							<label for="full_name" class="control-label col-md-4">Full Name</label>
							<div class="col-md-8">
								<input type="text" name="full_name" id="full_name" class="form-control" placeholder="Administator Full Name" style="margin-bottom: 5px" required>
							</div>
						</div>
						<div>
							<label for="email" class="control-label col-md-4">E-mail</label>
							<div class="col-md-8">
								<input type="email" name="email" id="email" class="form-control" placeholder="E-mail" style="margin-bottom: 5px" >
							</div>
						</div>
						<div>
							<label for="phone" class="control-label col-md-4">Phone</label>
							<div class="col-md-8">
								<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" style="margin-bottom: 5px" required>
							</div>
						</div>
						<div>
							<label for="designation" class="control-label col-md-4">Designation</label>
							<div class="col-md-8">
								<input type="text" name="designation" id="designation" class="form-control" placeholder="Designation" style="margin-bottom: 5px">
							</div>
						</div>
						<div>
							<label for="image" class="control-label col-md-4">Image</label>
							<div class="col-md-8">
							<input type="file" name="picture">    
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div>
							<label for="user_name" class="control-label col-md-4">User Name</label>
							<div class="col-md-8">
								<input type="text" name="user_name" id="user_name" class="form-control" placeholder="User name" style="margin-bottom: 5px" required>
							</div>
						</div>
						<div>
							<label for="password" class="control-label col-md-4">Password</label>
							<div class="col-md-8">
								<input type="password" name="password" id="password" class="form-control" placeholder="Password" style="margin-bottom: 5px" required>
							</div>
						</div>
						<div>
							<label for="password" class="control-label col-md-4">Re-type Password</label>
							<div class="col-md-8">
								<input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Re-type Password" style="margin-bottom: 5px" required>
							</div>
						</div>
						<div>
							<label for="type" class="control-label col-md-4">Choose Type</label>
							<div class="col-md-8">
								<select class="form-control js-example-basic-single" id="type" name="type">
								
								<option value="1">Genaral User</option>
								<option value="2">Supper Admin</option>
								</select>
							</div>
						</div> 

						<div>
		                    <label for="area" class="control-label col-md-4 col-sm-4">Select Officer</label>
		                    <div class="col-md-7 col-sm-7" style="padding-top: 5px;">
	                        	<select id="employee_id" name="employee_id" class="form-control js-example-basic-single" required>
	                        		<option value="">Select Officer</option>
	                        		<?php 
	                        			$employee = $this->db->query("select * from tbl_emplyee where status ='a'")->result();
	                        			foreach ($employee as  $value) {
	                        		 ?>
	                        		 <option value="<?php echo $value->id ?>"><?php echo $value->emp_name; ?></option>
	                        		<?php } ?>
	                        	</select>
	                        </div>
	                        <div class="col-md-1 col-sm-1"  style="padding-top: 5px;"><a href="<?php echo base_url().'employee' ?>" target="_blanck" style="position: relative;left: -15px;height: 25px;" id="area" class="btn btn-info"><span style="position: absolute;top: -5px;left: 25%;font-size: 20px;">+</span></a></div>
		                </div>
						<div>
							<label for="emp_name" class="control-label col-md-4"></label>
							<div class="col-md-3" style="margin-top: 5px;">
								<input type="hidden" name="action" id="action" value="create">
								<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info btn-sm btn-block">
							</div>
						</div>
					</div>
				</form>
				<hr>
			</div>
            </div>
        </div>
    </div>
</div>
<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">List Entry</h4>
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
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-bordered" id="dataTable">
						<thead>
							<th>So</th>
							<th>Name</th>
							<th>E-mail</th>
							<th>Phone</th>
							<th>Designation</th>
							<th>image</th>
							<th>Type</th>
							<th>Access</th>
						</thead>
						<tbody>
							<?php 
							$j=1;
							if(!empty($userlist)){ foreach($userlist as $value){ 
							$type='';
							if ($value->type==1) {
								$type='Genaral User';
							}
							else if($value->type==2){
								$type='Supper Admin';
							}
							?>
							<tr>
							<td><?php echo $j++; ?></td>
							<td><?php echo $value->full_name ?></td>
							<td><?php echo $value->email ?></td>
							<td><?php echo $value->phone ?></td>
							<td><?php echo $value->designation ?></td>
							<td class="text-center"><img src="<?php echo base_url().'assets/backend/images/'.$value->image ?>" style="height:60px;width: 80px;"></td>
							<td><?php echo $type ?></td>
							<td class="text-center">
								<?php if($value->type ==1){?>
								<a href="<?php echo base_url().'menu-access/'.$value->id ?>" style="color:#797979"><i class="fa fa-users"></i></a>
								<?php }?>
								<a href="" class="" id="delete-user" data-id="<?php echo $value->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
   
  $(document).on('submit','#createadministatorForm',function(e){
    e.preventDefault();
    var action = $('#action','#createadministatorForm').val();
    var full_name = $('#full_name','#createadministatorForm').val();
    var email = $('#email','#createadministatorForm').val();
    var phone = $('#phone','#createadministatorForm').val();
    var user_name = $('#user_name','#createadministatorForm').val();
    var password = $('#password','#createadministatorForm').val();
    var employeeId = $('#employee_id','#createadministatorForm').val();

    if (full_name == '') {
      alert('Please fill up full name!!');
    }
    else if(user_name == ''){
      alert('Please fill up user name !!');
    }
    else if(password == ''){
      alert('Please fill up password !!');
    }
    else if(phone == ''){
      alert('Please fill up phone !!');
    }
    else if(employeeId == ''){
      alert('Select officer !!');
    }
    else {
      $.ajax({
        url:'<?php echo base_url("save-admin") ?>',
        method:'post',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success: function(data){
          if (data.trim() =='created') {
            $('#output').html(data);
            $('#createadministatorForm')[0].reset();
            location.reload();
             show_list();
          }
          else{
            $('#error').html(data);
          }
        }
      })
    }

  })


  $(document).on('click','#delete-user',function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    //alert(id);
    if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url('user-delete') ?>',
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
</script>
