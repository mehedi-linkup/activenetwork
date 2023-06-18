
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> </title>

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
      <div style="width:85%;float: left;">
          <strong style="font-size:18px;"><?php echo $cominfo->com_name ?> </strong><br/>
          <strong> <?php echo $cominfo->com_address ?></strong><br>
          <strong>Mobile : <?php echo $cominfo->com_phone ?></strong><br>
          <strong>E-mail : <?php echo $cominfo->com_email ?></strong> &nbsp; <strong>Website : <?php echo $cominfo->website ?></strong><br><br>
      </div>
    </div>
    <div style="width:100%;margin: 0 auto">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;">Areawise Customer Due </strong></td>
        </tr>
        <tr>
            <!-- Customer html -->

            <td>
            </td>
            <td>
    
            </td>        </tr>
    </table>
    
    <table id="order-print">
        <tr>
           <th style="text-align:center;width: 5%; padding:3px 0px">Sl</th>
           <th colspan="2" style="text-align:center; padding:3px 0px">Name</th>
           <th style="text-align:center; padding:3px 0px">Phone</th>
           <!-- <th style="text-align:center; padding:3px 0px">Adress</th> -->
           <th style="text-align:center; padding:3px 0px; width: 15%;">Due Month</th>
           <th style="text-align:center; padding:3px 0px">Dish Due</th>
           <th style="text-align:center; padding:3px 0px">Wifi Due</th>
           <th style="text-align:center; padding:3px 0px">Total Due</th>
        </tr>
        <?php
        	
        	$dish=0;
        	$wifi=0;
        	$sum=0;
        	$j=1;
        	if ($getCollAreaWise){ 
        		foreach ($getCollAreaWise as  $sub) {
                    $i=0;
                    foreach ($sub as $key => $value) {
                       $i++;
                    $dish += $value->dish_bill;
                    $wifi += $value->wifi_bill;
                    $subTotal = $value->dish_bill + $value->wifi_bill;
                    $sum=$sum + $subTotal;
                
        		
        		?>

                <tr align="center">
                    <td><?php echo $j++; ?></td>
                    <td colspan="2"><?php echo $value->cust_name ?></td>
                    <td><?php echo $value->cust_phone ?></td>
                   
                    <!-- <td><?php //echo $value->cust_address ?></td> -->
                    <td><?php echo $value->month_name ?></td>
                    <td style="text-align: right;"><?php echo$value->dish_bill ?></td>
                    <td style="text-align: right;"><?php echo$value->wifi_bill ?></td>
                    <td style="text-align: right;"><?php echo $subTotal ?></td>
               
                    
                </tr>
            <?php }}}?>

        <tr>
            <td colspan="3" style="border:0px"></td>
            <td colspan="2" style="border:0px;text-align: right;padding-top: 10px">Sub Total : </td>
            <td style="border:0px; text-align: right;padding-top: 10px"><?php echo $dish ?> </td>
            <td style="border:0px; text-align: right;padding-top: 10px"><?php echo $wifi ?> </td>
            <td style="border:0px; text-align: right;padding-top: 10px"><?php echo $sum ?> </td>
        </tr>
   
    </table>
    
  </div>
</body>
</html>