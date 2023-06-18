<div class="container">
  <style>
    .admin-profile{
      padding:20px;
      font-size: 16px;
    }
  </style>
  <div class="row">
    <div class="well" style="min-height: 500px">
      <div class="col-md-10">
        <div class="row">
          <div class="col-md-4">
            <div class="admin-profile">
              Name : <strong> <?php echo $admin_info->full_name ?></strong><br><br>
              Designation : <strong> <?php echo $admin_info->designation ?></strong><br><br>
              Phone : <strong> <?php echo $admin_info->phone ?></strong><br><br>
              E-mail : <strong> <?php echo $admin_info->email ?></strong><br><br>
              User Name : <strong> <?php echo $admin_info->user_name ?></strong><br><br>

              <a href="#" class="btn btn-info" data-toggle="modal" data-target="#editprofileModal">Edit</a>
             
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Change Password</button>
            </div>
          </div>
          <div class="col-md-3">
            <img src="<?php echo base_url().'assets/backend/images/'.$admin_info->image ?>" class="img-responsive">
          </div>  
        </div>   
           
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editprofileModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">Edit Admin Profile </h4>
      </div>
      <div class="modal-body">
          <form id="adminForm" enctype="multipart/form-data">
            <div class="from-group">
              <label>Full Name</label>
              <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $admin_info->full_name ?>" required>
            </div>
            <div class="from-group">
              <label>Designation</label>
              <input type="text" name="designation" id="designation" class="form-control" value="<?php echo $admin_info->designation ?>" required>
            </div>
            <div class="from-group">
              <label>E-mail</label>
              <input type="text" name="email" id="email" class="form-control" value="<?php echo $admin_info->email ?>" required>
            </div>
            <div class="from-group">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $admin_info->phone ?>" required>
            </div>
            <div class="from-group">
              <label>User Name</label>
              <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $admin_info->user_name ?>" required>
            </div>
            <div class="from-group">
              <label>Images</label>
              <input type="file" name="picture" id="picture">
              <div>
                <img src="<?php echo base_url().'assets/backend/images/'.$admin_info->image ?>" style="height:60px;width: 80px;">
              </div>
            </div>
          <input type="hidden" name="old_image" id="old_image" value="<?php echo $admin_info->image ?>">
          <input type="hidden" name="id" id="id" value="<?php echo $admin_info->id ?>">
          <input type="hidden" name="action" id="action" value="updateadmin">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div>
</div>
<!-- Modal -->
 <!-- password change modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
       <form id="updatepassword" method="post">
          <div class="from-group">
              <label>Old Password</label>
              <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password" required>
            </div>
            <div class="from-group">
              <label>New Password</label>
              <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required>
            </div>
            <div class="from-group">
              <label>Re-type Password</label>
              <input type="password" name="retype_pass" id="retype_pass" class="form-control" placeholder="Re-type Password" required>
            </div>

          <input type="hidden" name="id" id="id" value="<?php echo $admin_info->id ?>">
          <input type="hidden" name="action" id="action" value="updatepass">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- password change modal -->



<script>
$(document).ready(function(){
  $(document).on('submit','#adminForm',function(e){
    e.preventDefault();
    $.ajax({
      url:'<?php echo base_url("update-admin") ?>',
      method:'post',
      data:new FormData(this),
      contentType:false,
      processData:false,
      success:function(data){
        if (data.trim()=='update') {
          $('#adminForm')[0].reset();
          location.reload();
          $('#editprofileModal').modal('hide');

        }else{
          alert(data);
        }
        
      }
    })
  })

   //admin password change
   $(document).on('submit','#updatepassword',function(e){
      e.preventDefault();
      var action = $('#action','#updatepassword').val();
      var id = $('#id','#updatepassword').val();
      var old_password = $('#old_password','#updatepassword').val();
      var new_password = $('#new_password','#updatepassword').val();
      var retype_pass = $('#retype_pass','#updatepassword').val();
      
      $.ajax({
        url:"<?php echo base_url().'change-pass';?>",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data){
            if (data.trim()=='update') {
              $('#updatepassword')[0].reset();
              window.location.reload();
              $('#myModal').modal('hide');
            }else{
              alert(data);
            }
            
        }
       });
      
     });

})

</script>
