<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="col-md-10 col-sm-12 col-lg-12">
				<form class="" id="expenseForm">
					<div id="output" class="text-success text-center"></div>
					<div style="padding: 10px 0px" id="error" class="text-danger text-center"></div>
					<div class="col-md-6 col-sm-6 col-lg-6">
						<div class="row">
		                    <label for="cust_name" class="control-label col-md-4 col-sm-4 col-lg-4">Expense Name </label>
		                    <div class="col-md-8">
		                    	<input type="text" name="exp_name" id="exp_name" class="form-control" style="margin-bottom: 3px" placeholder="Expense name">
	                        </div>
		                </div>
		                
		                <div class="row">
		                    <label for="exp_type" class="control-label col-md-4 col-sm-4 col-lg-4">Expense Type </label>
		                    <div class="col-md-7 col-sm-7 col-lg-7">
	                        	<select class="form-control select-box" id="exp_type" name="exp_type" style="height: 31px !important">
		                    		<option value="0">Choose expense</option>
		                    		<?php 
		                    			$data=$this->db->query("select * from tbl_exp_type where status='a'")->result();
		                    			foreach($data as $value){
		                    		 ?>
		                    		<option value="<?php echo $value->id ?>"><?php echo $value->expense_name ?></option>
									<?php } ?>		                    		
		                    	</select>
	                        </div>
	                        <div class="col-md-1 col-sm-1 col-lg-1">
	                        	<a href="<?php echo base_url('expense-type') ?>" target="_blanck" style="position: relative;left: -15px;height: 30px;" id="expense" class="btn btn-info"><span style="position: absolute;top: -5px;left: 21%;font-size: 20px;padding: 2px">+</span></a>
	                        	
	                        </div>
		                </div>
		   
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6">
						
		                <div class="row">
		                    <label for="emp_name" class="control-label col-md-4 col-md-4 col-sm-4 col-lg-4">Expense Date </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<input type="text" name="exp_date" id="exp_date" class="form-control"  style="margin-bottom: 3px" required="1" value="<?php echo date("Y-m-d") ?>">
	                        </div>
		                </div>
		                <div class="row">
		                    <label for="exp_desc" class="control-label col-md-4 col-md-4 col-md-4 col-sm-4">Description </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	
	                        	<textarea name="exp_desc" id="exp_desc" class="form-control" placeholder="Description" style="height: 50px!important;margin-bottom: 3px"></textarea>
	                        </div>
		                </div>
		                <div class="row">
		                    <label for="emp_name" class="control-label col-md-4 col-md-4 col-md-4 col-sm-4">Amount </label>
		                    <div class="col-md-8 col-sm-8 col-lg-8">
	                        	<input type="text" name="exp_amount" id="exp_amount" class="form-control" placeholder="Amount" style="margin-bottom: 3px;margin-top: 3px" >
	                        </div>
		                </div>
		                <div class="row">
		               		<div class="form-group ">
			                    <label for="emp_name" class="control-label col-md-4 col-md-4 col-md-4 col-sm-4"></label>
			                    <div class="col-md-8 col-md-8 col-sm-8 col-lg-8">
			                    	<input type="hidden" name="action" id="action" value="expense">
			                    	<input type="hidden" name="action_id" id="action_id">
		                        	<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info btn-block">
		                        </div>
			                </div>
		                </div>
					</div>

				</form>
			</div>

			<div class="row">
				 <div class="col-md-10 col-sm-12 col-lg-12">
				 	<br>
					<table class="table table-bordered" id="dataTable">
						<div id="delete" class="text-success"></div>
						<thead>
							<th>Serial</th>
							<th>Exp. Name</th>
							<th>Exp. Type</th>
							<th>Description</th>
							<th>Date</th>
							<th>Amount</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php 
								$j=1;
								if (!empty($expenses)) { foreach($expenses as $exp){

							 ?>
							<tr>
								<td><?php echo $j++; ?></td>
								<td><?php echo $exp->exp_name; ?></td>
								<td><?php echo $exp->expense_name; ?></td>
								<td><?php echo $exp->exp_desc; ?></td>
								<td><?php echo $exp->exp_date; ?></td>
								<td><?php echo $exp->exp_amount; ?></td>
								<td>
									<a href="" id="edit-exp" data-id="<?php echo $exp->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
		             				<a href="" class="" id="delete-exp" data-id="<?php echo $exp->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
								</td>
							</tr>
							<?php }}else{ ?>
								<tr>
									<td colspan="7" class="text-center">No Expense </td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	 
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	
	$(document).on('submit','#expenseForm',function(e){
		e.preventDefault();
		var action =$('#action','#expenseForm').val();
		var exp_name =$('#exp_name','#expenseForm').val();
		var exp_type =$('#exp_type','#expenseForm').val();
		var exp_date =$('#exp_date','#expenseForm').val();
		var exp_desc =$('#exp_desc','#expenseForm').val();
		var exp_amount =$('#exp_amount','#expenseForm').val();
		
		if(exp_name==''){
			alert('Expense name field is not empty !!');
		}
		else if(exp_type ==0){
			alert('Choose expense type');
		}
		else if(exp_date ==''){
			alert('Expense date is not empty !!');
		}
		else if(exp_desc ==''){
			alert('Expense description is not empty!!');
		}
		else if(exp_amount ==''){
			alert('Expense amount is not empty !!');
		}
		else{
			$.ajax({
				url:'<?php echo base_url("save-exp") ?>',
				method:'post',
				data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data){

	            	if (data.trim()=='success') {
	            		alert('Expense entry successfully !!');
	            		location.reload();
	            	}
	            	else if(data.trim()=='update'){
	            		alert('Expense Update successfully !!');
	            		location.reload();
	            	}
	           
	            }
			})
		}
	})

 // edit 
    $(document).on('click','#edit-exp',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url('edit-exp') ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){

          $('#exp_name','#expenseForm').val(data.exp_name);
          $('#exp_type','#expenseForm').val(data.exp_type);
          $('#exp_type').trigger("chosen:updated");
          $('#exp_date','#expenseForm').val(data.exp_date);
          $('#exp_desc','#expenseForm').val(data.exp_desc);
          $('#exp_amount','#expenseForm').val(data.exp_amount);
         
          $('#action','#expenseForm').val('Update');
          $('#action_id','#expenseForm').val(id);
          $('#submit','#expenseForm').val('Update');
          
        }
      })
    })
    //delete 
    $(document).on('click','#delete-exp',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url('delete-exp') ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='delete') {
             alert('Expense deleted successfully !!');
              location.reload();
            }
          }
        })
      }
    })
})    
</script>

