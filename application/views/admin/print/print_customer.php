
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
 <div>
        

  <!-----------------    Print Type -- POS      ------------>
    <div style="width: 100%; height: auto; padding: 0px; margin:0 auto">
      <div style="width:15%; float: left;">
          <img src="<?php echo base_url().'assets/backend/images/'.$cominfo->com_logo?>" alt="Logo" style="width:100px;" />
      </div>
      <div style="width:85%;float: left;">
          <strong style="font-size:18px;"><?php echo $cominfo->com_name ?> </strong><br/>
          <strong> <?php echo $cominfo->com_address ?></strong><br>
          <strong>Mobile : <?php echo $cominfo->com_phone ?></strong><br>
          <strong>E-mail : <?php echo $cominfo->com_email ?></strong> &nbsp; <strong>Website :<?php echo $cominfo->website ?></strong><br><br>
      </div>
    </div>
    <div style="width: 100%;margin:0 auto ">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;">Customer List</strong></td>
        </tr>
    </table>
    </div>
    <div style="width: 100%;margin:0 auto ">
    <table id="order-print">
        <tr>
           <th style="text-align:center;width: 5%;padding:3px 0px">Sl</th>
           <th  style="text-align:center;padding:3px 0px">Id</th>
           <th style="text-align:center;padding:3px 0px">Name</th>
           <th style="text-align:center;padding:3px 0px">Phone</th>
           <th style="text-align:center;padding:3px 0px">Quantity</th>
           <th style="text-align:center;padding:3px 0px">Wifi Qty</th>
           <th style="text-align:center;padding:3px 0px">Bish Total</th>
           <th style="text-align:center;padding:3px 0px">Wifi Total</th>
           <!-- <th style="text-align:center;padding:3px 0px width: 15%;">Area</th> -->
           <!-- <th style="text-align:center;padding:3px 0px">Address</th> -->
        </tr>
        <?php
        	
        	$j=1;
        	if ($printcustomer){ 
        		foreach ($printcustomer as  $value) {
                
        		?>

                <tr align="center">
                    <td style="padding: 2px 0px"><?php echo $j++; ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->cust_id ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->cust_name ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->cust_phone ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->quantity ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->wifi_quantity ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->dish_total ?></td>
                    <td style="padding: 2px 0px"><?php echo $value->wifi_total ?></td>
                    <!-- <td style="padding: 2px 0px"><?php //echo $value->name ?></td> -->
                    <!-- <td style="padding: 2px 0px"><?php //echo $value->cust_address ?></td> -->
               
                    
                </tr>
            <?php }}?>

        <tr>
            <td colspan="5" style="border:0px"></td>
           
            <td colspan="2" style="border:0px;text-align: right;padding-top: 10px"> Total Customer: </td>
            <td style="border:0px; text-align: center;padding-top: 10px"><?php if (!empty($count)) {
               echo $count;
            } ?> </td>
        </tr>
        
    </table>
    
    </div>
</div>
</body>
</html>

