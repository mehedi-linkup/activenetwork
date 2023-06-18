<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
		<div class="row">
			<div class="col-md-10 col-sm-12 col-lg-12">
				<form class="" id="complaintForm">
					<div id="output" class="text-success text-center"></div>
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
					<div class="col-md-6">
		                <div class="row">
		                    <label for="cust_id" class="control-label col-md-4">Customer Name </label>
		                    <div class="col-md-8">
	                        	<select class="js-example-basic-single form-control" id="cust_id" name="cust_id" >
		                    		<option value="0">Choose Customer</option>
		                    		<?php 
		                    			$result=$this->db->query("select id,cust_name,cust_phone from tbl_customer where status='a'")->result();
		                    			if(!empty($result)){ foreach($result as $value){
		                    		 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->cust_name.' - '.$value->cust_phone ?></option>
		                    		<?php }} ?>
		                    	</select>
	                        </div>
		                </div>
		   			
		                <div class="row" style="margin-top: 5px;">
		                    <label for="area_id" class="control-label col-md-4">Area</label>
		                    <div class="col-md-8">
	                        	<select class="js-example-basic-single form-control" id="area_id" name="area_id" >
		                    		<option value="0">Choose Area</option>
		                    		<?php 
		                    			$result=$this->db->query("select * from tbl_area where status='a'")->result();
		                    			if(!empty($result)){ foreach($result as $value){
		                    		 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
		                    		<?php }} ?>
		                    	</select>
	                        </div>
		                </div>

		                <div class="row" style="margin-top: 5px;">
		                    <label for="officer_id" class="control-label col-md-4">Officer Name</label>
		                    <div class="col-md-8">
	                        	<select class="js-example-basic-single form-control" id="officer_id" name="officer_id" >
		                    		<option value="0">Choose Officer</option>
		                    		<?php 
		                    			$result=$this->db->query("select id,emp_name,emp_phone from tbl_emplyee where status='a'")->result();
		                    			if(!empty($result)){ foreach($result as $value){
		                    		 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->emp_name.' - '.$value->emp_phone ?></option>
		                    		<?php }} ?>
		                    	</select>
	                        </div>
		                </div>
		                 <div class="row" style="margin-top: 5px;">
		                    <label for="date" class="control-label col-md-4">Complaint Date </label>
		                    <div class="col-md-8">
	                        	<input type="text" name="date" id="date" class="form-control"  style="margin-bottom: 3px" required="1" value="<?php echo date("Y-m-d") ?>">
	                        </div>
		                </div>
					</div>

					<div class="col-md-6">
		                <div class="row">
		                    <label for="d" class="control-label col-md-4">Complaint Note </label>
		                    <div class="col-md-8">
	                        	<textarea id="complaint" name="complaint" class="form-control" style="height: 120px !important;margin-bottom: 10px" placeholder="Complaint note"></textarea>
	                        </div>
		                </div>
		                
		             
		               		 <div class="form-group ">
			                    <label for="emp_name" class="control-label col-md-4"></label>
			                    <div class="col-md-8">
			                    	<input type="hidden" name="action" id="action" value="complaint">
			                    	<input type="hidden" name="action_id" id="action_id">
		                        	<input type="submit" name="submit" id="submit" value="Add Complains" class="btn btn-info btn-block">
		                        </div>
			                </div>
		             
		                
					</div>

				</form>
			</div>
		</div>
			<div class="row">
				 <div class="col-md-12 col-sm-12 col-lg-12">
				 	<br>
					<table class="table table-bordered" id="complaintTable">
						<div id="delete" class="text-success"></div>
						<thead>
							<th>Serial</th>
							<th>Customer Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Area</th>
							<th>Officer Name</th>
							<th>Date</th>
							<th>Complaint</th>
							<th>Status</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php 
								$j=1;
								if (!empty($complaintlist)) { foreach($complaintlist as $value){
							 ?>
							<tr>
								<td><?php echo $j++; ?></td>
								<td><?php echo $value->cust_name ?></td>
								<td><?php echo $value->cust_phone ?></td>
								<td><?php echo $value->cust_address ?></td>
								<td><?php echo $value->area_name ?></td>
								<td><?php echo $value->emp_name ?></td> 
								<td><?php echo $value->date ?></td>

								<td style="width: 20%"><?php echo $value->complaint ?></td>
								<td>
									<?php 
									$status='';
									$btn='';
										if ($value->status=='p') {?>
											<a href="" data-id="<?php echo $value->id ?>" id="status" class="btn btn-sm btn-danger">Pending</a>
										<?php }
										else if($value->status=='c'){?>
									
											<a href="#" class="btn btn-sm btn-success">Completed</a>
										<?php }
									 ?>
									
								</td>
								<td class="text-center">

									<a href="" id="edit-complaint" data-id="<?php echo $value->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
		             				<a href="" class="" id="delete-complaint" data-id="<?php echo $value->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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

$(document).on('submit','#complaintForm',function(e){
	
	e.preventDefault();
	var action =$('#action','#complaintForm').val();
	var cust_id =$('#cust_id','#complaintForm').val();
	var area_id =$('#area_id','#complaintForm').val();
	var officer_id =$('#officer_id','#complaintForm').val();
	var date =$('#date','#complaintForm').val();
	var complaint =$('#complaint','#complaintForm').val();
	
	if(cust_id==0){
		alert('Choose customer name');
	}
	else if(area_id ==0){
		alert('Choose area name');
	}
	else if(officer_id ==0){
		alert('Choose officer name');
	}
	else if(date ==''){
		alert('Date is not empty!!');
	}
	else if(complaint ==''){
		alert('Complaint is not empty !!');
	}
	else{
		$.ajax({
			url:'<?php echo base_url("save-complaint") ?>',
			method:'post',
			data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){

            	if (data.trim()=='success') {
            		alert('Complaint entry successfully !!');
            		location.reload();
            	}
            	else if(data.trim()=='update'){
            		alert('Complaint Update successfully !!');
            		location.reload();
            	}

            }
		})
	}
})

 // edit 
    $(document).on('click','#edit-complaint',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url("edit-complaint")?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){

          $('#cust_id','#complaintForm').val(data.cust_id);
          $('#cust_id').trigger("chosen:updated");
          $('#area_id','#complaintForm').val(data.area_id);
          $('#area_id').trigger("chosen:updated");
          $('#officer_id','#complaintForm').val(data.officer_id);
          $('#officer_id').trigger("chosen:updated");
          $('#date','#complaintForm').val(data.date);
          $('#complaint','#complaintForm').val(data.complaint);

         
          $('#action','#complaintForm').val('Update');
          $('#action_id','#complaintForm').val(id);
          $('#submit','#complaintForm').val('Update');
          
        }
      })
    })
    //delete 
    $(document).on('click','#delete-complaint',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url("delete-complaint") ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='delete') {
             alert('Complaint deleted successfully !!');
              location.reload();
            }
          }
        }) 
      }
    })

    $(document).on('click','#status',function(e){
    	e.preventDefault();
    	var id=$(this).attr('data-id');
    	if (confirm('Are you sure to change this ?')) {
        $.ajax({
          url:'<?php echo base_url("change-status") ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='change') {
             alert('Status Update successfully !!');
              location.reload();
            }
          }
        })
      }
    })
</script>