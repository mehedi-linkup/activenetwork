<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<div class="col-md-10 col-sm-12 col-lg-12">
				<form id="transactionForm" method="post">
					<div class="col-md-6 col-sm-6 col-lg-6">
						<div class="row" style="margin-bottom: 3px">
						<?php 
							$code='T';
						    $Id = $code.'00001';
					        $lastCode = $this->db->query("select id from tbl_transaction order by tr_id desc limit 1");
					       
					        if (isset($lastCode)) {
					        	 $lastCode = $lastCode->row()->id + 1;
					        $zeros = array('0', '00', '000', '0000');
					        $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
					        }
						 ?>
							<div class="form-group">
								<label for="transaction_id" class="col-md-4 col-sm-4 col-lg-4">Transction Id</label>
								<div class="col-md-8 col-sm-8 col-lg-8">
									<input type="text" name="tr_id" id="tr_id" class="form-control" value="<?php echo $Id ?>" readonly required>
								</div>
							</div>
						</div>
						<div class="row" style="margin-bottom: 3px">
							<div class="form-group">
								<label for="tr_type" class="col-md-4 col-sm-4 col-lg-4">Transction Type</label>
								<div class="col-md-8 col-sm-8 col-lg-8">
									<select id="tr_type" name="tr_type" class="form-control js-example-basic-single" required>
										<option value="0">Choose Type</option>
										<option value="1">Cash Receive</option>
										<option value="2">Cash Payment</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-bottom: 3px">
							<div class="form-group">
								<label for="tr_type" class="col-md-4 col-sm-4 col-lg-4">Voucher No</label>
								<div class="col-md-8 col-sm-8 col-lg-8">
									<input type="text" id="voucher_no" name="voucher_no" class="form-control">
								</div>
							</div>
						</div>

						<div class="row" style="margin-bottom: 3px">
							<div class="form-group">
								<label for="tr_account" class="col-md-4 col-sm-4 col-lg-4">Account Head</label>
								<div class="col-md-7 col-sm-7 col-lg-7">
									<select class="form-control js-example-basic-single" id="account_id" name="account_id" required>
										<option value="0">Choose Account</option>
										<?php 
											$data=$this->db->query("select * from tbl_account where status  ='a'")->result();
											foreach($data as $value){
										 ?>
										<option value="<?php echo $value->id ?>"><?php echo $value->account_name?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1 col-sm-1 col-lg-1">
									<div style="position: relative; left: -15px;">
										<a target="_blank" href="<?php echo base_url('account') ?>" class="btn btn-info btn-sm">+</a>
									</div>
									
								</div>
							</div>
						</div>

					</div>
					<div class="col-md-6 col-sm-6 col-lg-6">
						
							<div class="row" style="margin-bottom: 3px">
								<div class="form-group">
									<label for="tr_date" class="col-md-4 col-sm-4 col-lg-4">Transaction Date</label>
									<div class="col-md-8 col-sm-8 col-lg-8">
										<input type="date" name="tr_date" id="tr_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
									</div>
								</div>
							</div>
						
						
							<div class="row" style="margin-bottom: 3px">
								<div class="form-group">
									<label for="tr_desc" class="col-md-4 col-sm-4 col-lg-4">Description</label>
									<div class="col-md-8 col-sm-8 col-lg-8">
										<input type="text" name="tr_desc" id="tr_desc" class="form-control" style="margin-bottom: 3px " placeholder="Description" required>
									</div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 3px">
								<div class="form-group">
									<label for="tr_amount" class="col-md-4 col-sm-4 col-lg-4">Amount</label>
									<div class="col-md-8 col-sm-8 col-lg-8">
										<input type="text" name="tr_amount" id="tr_amount" class="form-control" style="margin-bottom: 3px" placeholder="Amount" required> 
									</div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 3px">
								<div class="form-group">
									<label for="tr_amount" class="col-md-4 col-sm-4 col-lg-4"></label>
									<div class="col-md-8 col-sm-8 col-lg-8">
										<input type="hidden" name="action" id="action" value="create">
										<input type="hidden" name="action_id" id="action_id">
										<input type="submit" name="submit" id="submit" class="btn btn-info" value="Save">
										<input type="reset" name="cancel" value="Cancel" class="btn btn-danger">
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
				
					<div class="row">
						<div class="col-md-10 col-sm-12 col-lg-12">
							<table class="table table-bordered" id="dataTable"> 
								<thead>
									<th>Serial</th>
									<th>Date</th>
									<th>Voucher No</th>
									<th>Transction Type</th>
									<th>Account</th>
									<th>Amount</th>
									<th>Description</th>
									<th>Action</th>
								</thead>
								<tbody>
									<?php 
										if (!empty($transactionlist)) {
											$j=1;
											foreach ($transactionlist as $value) {
											$type='';
											if ($value->tr_type ==1) {
												$type='Cash Recive';
											}
											else if($value->tr_type ==2){
												$type='Cash Payment';
											}
									 ?>
									<tr>
										<td><?php echo $j++ ?></td>
										<td><?php echo $value->tr_date ?></td>
										<td><?php echo $value->voucher_no ?></td>
										<td><?php echo $type ?></td>
										<td><?php echo $value->account_name ?></td>
										<td><?php echo $value->tr_amount ?></td>
										<td><?php echo $value->tr_desc ?></td>
										<td class="text-center">
											<a href="" id="edit-transaction" data-id="<?php echo $value->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
				             				<a href="" class="" id="delete-transaction" data-id="<?php echo $value->id?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
</div>
<script>
$(document).ready(function(){
	$(document).on('submit','#transactionForm',function(e){
		e.preventDefault();

		var tr_type =$('#tr_type','#transactionForm').val();
		var account_id =$('#account_id','#transactionForm').val();
		var tr_date =$('#tr_date','#transactionForm').val();
		var tr_desc =$('#tr_desc','#transactionForm').val();
		var tr_amount =$('#tr_amount','#transactionForm').val();
		
		if(tr_type==0){
			alert('Choose transaction type !');
		}
		else if(account_id ==0){
			alert('Choose account name !');
		}
		else if(tr_date ==''){
			alert('Transction date is not empty !!');
		}
		else if(tr_desc ==''){
			alert('Transction description is not empty!!');
		}
		else if(tr_amount ==''){
			alert('Transction amount is not empty !!');
		}
		else{
			$.ajax({
				url:'<?php echo base_url("save-transaction") ?>',
				method:'post',
				data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data){

	            	if (data.trim()=='success') {
	            		alert('Transaction entry successfully !!');
	            		location.reload();
	            	}
	            	else if(data.trim()=='update'){
	            		alert('Transaction Update successfully !!');
	            		location.reload();
	            	}
	           		else{
	           			alert(data);
	           		}
	            }
			})
		}
	})

 // edit 
    $(document).on('click','#edit-transaction',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      $.ajax({
        url:'<?php echo base_url("edit-transaction") ?>',
        method:'post',
        data:{id:id},
        dataType:'json',
        success: function(data){
          $('#tr_id','#transactionForm').val(data.tr_id);
		  $('#tr_type').find('option:not(:selected)').removeAttr('selected');
		  $('#tr_type').find('option[value="'+ data.tr_type +'"]').attr('selected', 'selected').trigger('change');
		  $('#account_id').find('option:not(:selected)').removeAttr('selected');
		  $('#account_id').find('option[value="'+data.account_id+'"]').attr('selected', 'selected').trigger('change');
          $('#tr_date','#transactionForm').val(data.tr_date);
          $('#tr_desc','#transactionForm').val(data.tr_desc);
          $('#tr_amount','#transactionForm').val(data.tr_amount);
          $('#voucher_no','#transactionForm').val(data.voucher_no);
         
          $('#action','#transactionForm').val('Update');
          $('#action_id','#transactionForm').val(id);
          $('#submit','#transactionForm').val('Update');
          
        }
      })
    })
    //delete 
    $(document).on('click','#delete-transaction',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url("delete-transaction") ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='delete') {
             alert('Transaction deleted successfully !!');
              location.reload();
            }
          }
        })
      }
    })
})
</script>
