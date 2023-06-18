
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
          <strong>Mobile <?php echo $cominfo->com_phone ?></strong><br>
          <strong>E-mail : <?php echo $cominfo->com_email ?></strong> &nbsp; <strong>Website :<?php echo $cominfo->website ?></strong><br><br>
      </div>
    </div>
    <div style="width: 100%; margin:0 auto">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;">Customer Payment Invoice</strong></td>
        </tr>
    </table>
    <table>
      
      <tr>
          <td>
             <table width="100%">
                    <tr>
                        <td><strong style="font-weight: bold;">Customer Name </strong></td>
                        <td style="padding:0px 30px;">:</td>
                        <td><?php  echo $customerinfo->cust_name ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Mobile </strong></td>
                        <td style="padding:0px 30px;">: </td>
                        <td><?php  echo $customerinfo->cust_phone ?></td>
                    </tr> 
                     <tr>
                        <td><strong>Email </strong></td>
                        <td style="padding:0px 30px;">:</td>
                        <td><?php  echo $customerinfo->cust_email ?></td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td>
                        <td style="padding:0px 30px;">:</td>
                        <td><?php  echo $customerinfo->cust_address ?></td>
                    </tr>  
                    <tr>
                        <td><strong>Recipt No</strong></td>
                        <td style="padding:0px 30px;">:</td>
                        <td><?php  echo $recipt_no->recipt_book ?></td>
                    </tr>  
                </table>
          </td>
          <td></td>
        </tr>
    </table>
     
    <table id="order-print">
        <tr>
           <th style="text-align:center;width: 5%;font-family: times;font-weight: 500">SI</th>
           <th style="text-align:center;font-family: times;font-weight: 500">Transaction</th>
           <th style="text-align:center;font-family: times;font-weight: 500">Month</th>
           <th style="text-align:center;font-family: times;font-weight: 500">Date</th>
           <th style="text-align:center;font-family: times;font-weight: 500">Amount</th>
        </tr>
        <?php
          
          $sum=0;
          $discount=0;
          $subtotal=0;
              $j=1;
              foreach ($result as $value) {
                $coll_discount=$value->discount;
                $discount=$discount+$coll_discount;
                $sum=$sum + $value->coll_amount +$coll_discount;
             
            ?>

                <tr align="center">
                    <td><?php echo $j ?></td>
                    <td><?php echo $value->coll_code ?></td>
                    <td><?php echo $value->month_name ?></td>
                    <td><?php echo $value->update_date ?></td>
                    <td><?php echo $value->coll_amount+$coll_discount; ?></td>
                </tr>
           
          <?php } ?>
        <tr>
            <td colspan="4" style="border:0px;text-align: right;">Total : </td>
            <td style="border:0px; text-align: center;padding: 0px !important"><?php echo $sum ?> </td>
        </tr>
        <tr>
          <td colspan="4" style="border:0px;text-align: right;">Discount : </td>
          <td style="border:0px; text-align: center;padding: 0px !important"><?php echo $discount ?> </td>
        </tr>
        
        <tr>
          <hr class="bg">
          <td colspan="4" style="border:0px;text-align: right;">Sub Total : </td>
          <td style="border:0px; text-align: center;padding: 0px !important"><?php echo $subtotal=($sum -$discount); ?> </td>
        </tr>
    </table>
  </div>
</body>
</html>