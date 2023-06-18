
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
  font-size: 12px;
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
          <strong>Mobile <?php echo $cominfo->com_phone ?></strong><br>
          <strong>E-mail <?php echo $cominfo->com_email ?></strong> &nbsp; <strong>Website : <?php echo $cominfo->website ?></strong><br><br>
      </div>
    </div>
    <div style="width: 100%;margin:0 auto">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;">Customer Payment </strong></td>
        </tr>
        <tr>
            <!-- Customer html -->

            <td><table width="100%">
                <?php
                $customer_id = $printdata[0]['cust_id'];
                $c_info = $this->db->query("SELECT * FROM tbl_customer WHERE id='$customer_id' ")->result_array(); 

                 ?>
                    <tr>
                        <td width="25%"><strong>Customer Name </strong></td>
                        <td>:</td>
                        <td><?php  echo $c_info[0]['cust_name']?></td>
                    </tr> 
                    <tr>
                        <td width="25%"><strong>Phone or Mobile </strong></td>
                        <td>: </td>
                        <td><?php  echo $c_info[0]['cust_phone'];?></td>
                    </tr> 
                     <tr>
                        <td width="25%"><strong>Customer Address </strong></td>
                        <td>:</td>
                        <td><?php  echo $c_info[0]['cust_address'];?></td>
                    </tr>
                     <tr>
                        <td width="25%"><strong>Email </strong></td>
                        <td>:</td>
                        <td><?php  echo $c_info[0]['cust_email'];?></td>
                    </tr>
                           
                </table>
            </td>
            <td>
    
            </td>        </tr>
    </table>
    
    <table id="order-print">
        <tr>
           <th style="text-align:center;width: 5%;">Sl</th>
           <th colspan="2" style="text-align:center;">Name</th>
           <th style="text-align:center;">Phone</th>
           <th style="text-align:center;">Date</th>
           <th style="text-align:center; width: 15%;">Payment Month</th>
           <th style="text-align:center;">Dish Paid</th>
           <th style="text-align:center;">Wifi Paid</th>
           <th style="text-align:center;">Total Paid</th>
        </tr>
        <?php
            
            $dish = 0;
            $wifi = 0;
            $sum = 0;
            $j=1;
            if ($printdata){ 
                foreach($printdata as $value){

                    $cust_id=$value['cust_id'];
                    $month_id=$value['coll_month'];
                    $selectData=$this->db->query("select coll.coll_month,coll.dish_bill,coll.wifi_bill,coll.coll_date,c.*,m.month_name from tbl_collection as coll inner join tbl_customer as c on c.id=coll.cust_id inner join tbl_month as m on m.id=coll.coll_month where coll.cust_id=? and coll.coll_month =?  and coll.coll_status='a'",[$cust_id,$month_id])->row();
                    $dish += $selectData->dish_bill; 
                    $wifi += $selectData->wifi_bill; 
                    $subTotal = $selectData->dish_bill + $selectData->wifi_bill;
                    $sum +=$subTotal;
                
                ?>

                <tr align="center">
                    <td><?php echo $j++; ?></td>
                    <td colspan="2"><?php echo $selectData->cust_name; ?></td>
                    <td><?php echo $selectData->cust_phone; ?></td>
                   
                    <td><?php echo $selectData->coll_date; ?></td>
                    <td><?php echo $selectData->month_name; ?></td>
                    <td style="text-align: right"><?php echo $selectData->dish_bill; ?></td>
                    <td style="text-align: right"><?php echo $selectData->wifi_bill; ?></td>
                    <td style="text-align: right"><?php echo $subTotal; ?></td>
               
                    
                </tr>
            <?php }}?>

        <tr>
            <td colspan="6" style="border:0px"></td>
           
            <td colspan="2" style="border:0px;text-align: right;padding-top:10px">Sub Total : </td>
            <td style="border:0px; text-align: right;padding-top:10px"><?php echo $sum ?> </td>
        </tr>   
    </table>
  </div>
</body>
</html>

