<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="http://software.jtc-traders.com/assets/css/prints.css" rel="stylesheet" />
</head>
<style type="text/css" media="print">
.hide{display:none}
#order-print {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#order-print td, #order-print th {
  border: 1px solid #ddd;
  padding: 8px;
}
hr.bg{
   border-top: 1px solid #ddd;
}
.invoice-title {
    text-align: center;
    font-weight: bold;
    font-size: 15px;
    margin-bottom: 15px;
    padding: 5px;
    border-top: 1px dotted #454545;
    border-bottom: 1px dotted #454545;
}
</style>
<script type="text/javascript">
function printpage() {
window.print();
}
printpage();
</script>
<?php $cominfo=$this->db->query("select * from tbl_profile limit 1")->row(); ?>
<body style="background:none;">


  <!-----------------    Print Type -- POS      ------------>
    <div style="width: 100%; height: auto; padding: 0px; margin:0 auto">
      <div style="width:15%; float: left;">
          <img src="<?php echo base_url().'assets/backend/images/'.$cominfo->com_logo?>" alt="Logo" style="width:100px;" />
      </div>
      <div style="width:85%; float: left;">
          <strong style="font-size:18px;"><?php echo $cominfo->com_name ?> </strong><br/>
          <strong> <?php echo $cominfo->com_address ?></strong><br>
          <strong>Mobile : <?php echo $cominfo->com_phone ?></strong><br>
          <strong>E-mail : <?php echo $cominfo->com_email ?></strong> &nbsp; <strong>Website : <?php echo $cominfo->website ?></strong><br><br>
      </div>
    </div>
    <div style="width: 100%;margin: 0 auto">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;">Areawise Customer List </strong></td>
        </tr>
        <tr>
            <!-- Customer html -->
            <td></td>
            <td></td>        
        </tr>
    </table>
    <?php 
        if (isset($withoutdue)) {?>
           <table id="order-print">
                <tr>
                   <th style="text-align:center;width: 5%; padding:3px 0px">SI No</th>
                   <th style="text-align:center; padding:3px 0px">Id</th>
                   <th style="text-align:center; padding:3px 0px">Name</th>
                   <th style="text-align:center; padding:3px 0px">Phone</th>
                   <th style="text-align:center; padding:3px 0px">Area</th>
                   <!-- <th style="text-align:center; padding:3px 0px">Adress</th> -->
                  
                </tr>
                <?php
                    $j=1;
                    if (!empty($withoutdue)){ 
                        foreach ($withoutdue as  $value) {?>

                        <tr align="center">
                            <td><?php echo $j++; ?></td>
                            <td><?php echo $value->cust_id ?></td>
                            <td><?php echo $value->cust_name ?></td>
                            <td><?php echo $value->cust_phone ?></td>
                            <td><?php echo $value->area ?></td>
                            <!-- <td><?php //echo$value->cust_address ?></td> -->
                            
                        </tr>
                    <?php }}else{?>
                        <tr align="center"><td colspan="5">No customer not found !!</td></tr>
                    <?php } ?>
            </table>
        <?php }
        else if(isset($withdue)){?>
            <table id="order-print">
                <tr>
                   <th style="text-align:center;width: 5%; padding:3px 0px">SI No</th>
                   <th style="text-align:center; padding:3px 0px">Customer Id</th>
                   <th style="text-align:center; padding:3px 0px">Name</th>
                   <th style="text-align:center; padding:3px 0px">Phone</th>
                   <th style="text-align:center; padding:3px 0px">Area</th>
                   <!-- <th style="text-align:center; padding:3px 0px">Adress</th> -->
                   <th style="text-align:center; padding:3px 0px">Due Month</th>
                   <th style="text-align:center; padding:3px 0px">Dish Due</th>
                   <th style="text-align:center; padding:3px 0px">Wifi Due</th>
                   <th style="text-align:center; padding:3px 0px">Sub Total</th>
                  
                </tr>
                <?php
                    $j=1;
                    if (!empty($withdue)){ 
                        foreach ($withdue as  $value) {
                          $total=($value->totalDishDue + $value->totalWifiDue);
                          $months = '';
                          foreach($value->due_months as $v){ 
                            $months .= ' '.$v->month_name.' ,';
                          }
                        ?>

                        <tr align="center">
                            <td><?php echo $j++; ?></td>
                            <td><?php echo $value->cust_id ?></td>
                            <td><?php echo $value->cust_name ?></td>
                            <td><?php echo $value->cust_phone ?></td>
                            <td><?php echo $value->area ?></td>
                            <!-- <td><?php //echo $value->cust_address ?></td> -->
                            <td><?php echo rtrim($months,',') ?></td>
                            <td><?php echo $value->totalDishDue?></td>
                            <td><?php echo $value->totalWifiDue?></td>
                            <td><?php echo $total ?></td>
                            
                        </tr>
                    <?php }}else{?>
                        <tr align="center"><td colspan="8">No customer not found !!</td></tr>
                    <?php } ?>
            </table>
       <?php }
     ?>
    
    
  </div>
</body>
</html>