<div class="container">
  <div class="row">
    <div class="well" style="min-height: 500px">
      <form id="createsalaryForm" method="post">
        <div class="col-md-12 col-sm-12 col-lg-12">
          <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="row" style="margin-bottom: 5px">
              <label for="type" class="control-label col-md-4 col-sm-4 col-lg-4">Employee Name</label>
              <div class="col-md-8">
                <select class="form-control js-example-basic-single" id="emp_id" name="emp_id">
                  
                  <option value="0">Select Employee</option>
                  <?php 
                    $employees=$this->db->query("select id,emp_name,emp_phone from tbl_emplyee where status='a'")->result();
                    if (!empty($employees)) { foreach($employees as $value){
                   ?>
                   <option value="<?php echo $value->id ?>"><?php echo $value->emp_name.'-'.$value->emp_phone ?></option>
                  <?php }} ?>
                </select>
              </div>
            </div>
            <div class="row" style="margin-bottom: 5px">
              <label for="type" class="control-label col-md-4 col-sm-4 col-lg-4">Month</label>
              <div class="col-md-8 col-sm-8 col-lg-8">
                <select class="form-control js-example-basic-single" id="month_id" name="month_id">
                  
                  <option value="0">Select Month</option>
                  <?php 
                    $selectMonth=$this->db->query("select * from tbl_month where status='a' order by id desc")->result();
                    foreach($selectMonth as $month){
                   ?>
                    <option value="<?php echo $month->id ?>"><?php echo $month->month_name ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4">Payment Date </label>
              <div class="col-md-8 col-sm-8 col-lg-8">
                <input type="text" name="payment_date" id="payment_date" class="form-control" value="<?php echo date("Y-m-d") ?>" style="margin-bottom: 3px" >
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="row">
              <label for="payment_amount" class="control-label col-md-4">Payment Amount</label>
              <div class="col-md-8 col-sm-8 col-lg-8">
                  <input type="text" name="payment_amount" id="payment_amount" class="form-control" placeholder="Amount" style="margin-bottom: 5px" >
                </div>
            </div> 
            <div class="row">
              <label for="payment_note" class="control-label col-md-4 col-sm-4 col-lg-4">Payment Note</label>
              <div class="col-md-8 col-sm-8 col-lg-8">
                <textarea name="payment_note" id="payment_note" class="form-control" placeholder="Note" style="margin-bottom: 5px;height: 60px !important"></textarea>
              </div>
            </div>
            <div class="row">
                <label for="emp_name" class="control-label col-md-4 col-sm-4 col-lg-4"></label>
                <div class="col-md-8 col-sm-8 col-lg-8">
                  <input type="hidden" name="action" id="action" value="create">
                  <input type="hidden" name="action_id" id="action_id"  value="">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info btn-block">
                  </div>
            </div>
          </div>
        </div>
      </form>
     
     <div class="row">
       <div class="col-md-10 col-sn-12 col-lg-12">
        <br>
         <table class="table table-bordered" id="dataTable">
           <thead>
             <th>So</th>
             <th>Name</th>
             <th>Month</th>
             <th>Date</th>
             <th>Amount</th>
             <th>Note</th>
             <th>Action</th>
           </thead>
           <tbody>
            <?php 
            $j=1;
             if(!empty($salarylist)){ foreach($salarylist as $value){ ?>
             <tr>
               <td><?php echo $j++; ?></td>
               <td><?php echo $value->emp_name ?></td>
               <td><?php echo $value->month_name ?></td>
               <td><?php echo $value->payment_date ?></td>
               <td><?php echo $value->payment_amount ?></td>
               <td><?php echo $value->payment_note ?></td>
               <td class="text-center">
                 <a href="" id="edit-salary" data-id="<?php echo $value->id ?>" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
                          <a href="" class="" id="delete-salary" data-id="<?php echo $value->id ?>"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
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
$(document).ready(function(){


  $(document).on('submit','#createsalaryForm',function(e){
    e.preventDefault();
    var action=$('#action','#createsalaryForm').val();
    var emp_id=$('#emp_id','#createsalaryForm').val();
    var month_id=$('#month_id','#createsalaryForm').val();
    var payment_amount=$('#payment_amount','#createsalaryForm').val();

    if (emp_id ==0) {
      alert('Please choose employee name');
    }
    else if(month_id ==0){
      alert('Please select month name');
    }
    else if(payment_amount==''){
      alert('Please fill up salary amount !!');
    }
    else {
      $.ajax({
        url:'<?php echo base_url("save-salary") ?>',
        method:'post',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success: function(data){
        
          if (data.trim()=='inserted') {
            alert('Salary added successfully !');
            location.reload();
          }
          else if(data.trim()=='updated'){
            alert('Salary updated successfully !');
            location.reload();
          }
          else{
            alert(data);
          }
        }
      })
    }

  })

  $(document).on('click','#edit-salary',function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    //alert(id)
    if (id !=0) {
      $.ajax({
        url:'<?php echo base_url("edit-salary") ?>',
        method:'post',
        dataType:'json',
        data:{id:id},
        success:function(data){
          // alert(data)
          $('#payment_date','#createsalaryForm').val(data.payment_date);
          $('#payment_amount','#createsalaryForm').val(data.payment_amount);
          $('#payment_note','#createsalaryForm').val(data.payment_note);
          $('#emp_id','#createsalaryForm').val(data.emp_id);
          $('#emp_id').trigger("chosen:updated");
          $('#month_id','#createsalaryForm').val(data.month_id);
          $('#month_id').trigger("chosen:updated");
          $('#action','#createsalaryForm').val('Update');
          $('#action_id','#createsalaryForm').val(id);
          $('#submit','#createsalaryForm').val('Update');
        }
      })
    }
  })

  $(document).on('click','#delete-salary',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      if (confirm('Are you sure to delete this ?')) {
        $.ajax({
          url:'<?php echo base_url('delete-salary') ?>',
          method:'post',
          data:{id:id},
          success:function(data){
            if (data.trim()=='delete') {
             alert('Salary deleted successfully !!');
              location.reload();
            }
          }
        })
      }
    })

})
</script>
