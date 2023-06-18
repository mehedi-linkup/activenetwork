
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
.rules li {
  font-size: 11px;
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
    <div style="width: 100%;margin:0 auto">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;">Customer Payment List</strong></td>
        </tr>
    </table>
    
    <table id="order-print" style="padding-bottom: 50px">
        <tr>
           <th style="text-align:center;width: 5%;">Sl</th>
           <th colspan="2" style="text-align:center;">Name</th>
           <th style="text-align:center;">Phone</th>
           <!-- <th style="text-align:center;">Address</th> -->
           <th style="text-align:center; width: 20%;">Dish Payment</th>
           <th style="text-align:center;">Wifi Payment</th>
           <th style="text-align:center;">Total Payment</th>
        </tr>
        <?php
        	
        	$dish = 0;
        	$wifi = 0;
        	$sum = 0;
        	$j=1;
        	if ($printdata){ 
        		foreach ($printdata as  $value) {
              $subTotal = $value->totalDishPay + $value->totalWifiPay;
              $dish += $value->totalDishPay;
              $wifi += $value->totalWifiPay;
              $sum = $subTotal;
                
        		
        		?>

                <tr align="center">
                    <td><?php echo $j++; ?></td>
                    <td colspan="2"><?php echo $value->cust_name ?></td>
                    <td><?php echo $value->cust_phone ?></td>
                    <!-- <td><?php //echo $value->payMonthCount[0]->payMonths ?></td> -->
                    <td style="text-align: right;"><?php echo $value->totalDishPay ?></td>
                    <td style="text-align: right;"><?php echo $value->totalWifiPay ?></td>
                    <td style="text-align: right;"><?php echo $subTotal ?></td>
               
                    
                </tr>
            <?php }}?>

        <tr>
            <td colspan="2" style="border:0px"></td>
           
            <td colspan="2" style="border:0px;text-align: right;padding-top: 10px">Sub Total : </td>
            <td style="border:0px; text-align: right;padding-top: 10px"><?php echo $dish ?> </td>
            <td style="border:0px; text-align: right;padding-top: 10px"><?php echo $wifi ?> </td>
            <td style="border:0px; text-align: right;padding-top: 10px"><?php echo $sum ?> </td>
        </tr>   
    </table>
    
  </div>
</body>
</html>

