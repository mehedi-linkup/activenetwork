
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
  margin-bottom: 20px;
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
    printpage()
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
    <div style="width: 100%;margin: 0 auto">
    <table  cellspacing="0" cellpadding="0" width="100%" style="padding-bottom: 10px">
        <tr>
            <td colspan="2" class="invoice-title"><strong style="font-size:16px;"> Customer Due</strong></td>
        </tr>
        <tr>
            <!-- Customer html -->

            <td><table width="100%" >
                <?php

                // print_r($printdata[0]->id);
                // exit;
                $customer_id = $printdata[0]->id;
                $c_info = $this->db->query("SELECT * FROM tbl_customer WHERE id=? ",$customer_id)->row(); 

                 ?>
                    <tr>
                        <td width="25%"><strong>Id </strong></td>
                        <td>:</td>
                        <td><?php  echo $c_info->cust_id;?></td>
                    </tr>
                    <tr>
                        <td width="25%"><strong>Customer Name </strong></td>
                        <td>:</td>
                        <td><?php  echo $c_info->cust_name?></td>
                    </tr> 
                    <tr>
                        <td width="25%"><strong>Phone or Mobile </strong></td>
                        <td>: </td>
                        <td><?php  echo $c_info->cust_phone;?></td>
                    </tr> 
                     <tr>
                        <td width="25%"><strong>Customer Address </strong></td>
                        <td>:</td>
                        <td><?php  echo $c_info->cust_address;?></td>
                    </tr>
                     
                           
                </table>
            </td>
            <td>
    
            </td>        </tr>
        <tr>
            <td><br></td>
        </tr>
    </table>
    
    <table id="order-print">
        <tr>
           <th style="text-align:center;width: 5%;">Id</th>
           <th style="text-align:center;">Name</th>
           <th style="text-align:center;">Phone</th>
           <th style="text-align:center; width: 15%;">Due Month</th>
           <th style="text-align:center;">Dish Due</th>
           <th style="text-align:center;">Wifi Due</th>
           <th style="text-align:center;">Total</th>
        </tr>
        <?php
        	
        	$sum=0;
        	$j=1;
        	if ($printdata){ 
        		foreach($printdata as $value){
        		    $months='';
                    foreach($value->due_months as $v){
                        $months.=' '.$v->month_name.' ,';
                    }
        		?>

                <tr align="center">
                    <td><?php echo $value->cust_id ; ?></td>
                    <td><?php echo $value->cust_name; ?></td>
                    <td><?php echo $value->cust_phone; ?></td>
                    <td><?php echo rtrim($months,','); ?></td>
                    <td style="text-align: right;"><?php echo $value->totalDishDue; ?></td>
                    <td style="text-align: right;"><?php echo $value->totalWifiDue; ?></td>
                    <td style="text-align: right;"><?php echo ($value->totalDishDue +$value->totalWifiDue); ?></td>
               
                    
                </tr>
            <?php }}?>
   
    </table>
    <!--<div style="border: 1px solid #51DC8B;width: 100px; margin:0 auto;">-->
    <!--  <h4 style="margin:0px;padding: 5px 0px;text-align: center;">নিয়মাবলীঃ </h4>-->
    <!--</div>-->
    <!--<div>-->
    <!--  <ul class="rules">-->
    <!--    <li>সংযোগ চার্জ এবং ক্যাবল সম্পূর্নভাবে অফেরৎযোগ্য। সংযোগ ফি জমা দেয়ার ৩ দিনের মধ্যে সংযোগ দেয়া হবে।</li>-->
    <!--    <li>প্রতি মাসের ১ হইতে ৫ তারিখের মধ্যে অবশ্যই মাসিক ভাড়া অফিসে এসে রশিদের মাধ্যমে পরিশোধ করতে হবে। রশিদ ছাড়া কোনরুপ লেনদেনের জন্য কতৃপক্ষ দায়ী থাকবে না।</li>-->
    <!--    <li>নির্ধারিত সময়ের মধ্যে বিল পরিশোধে ব্যার্থ হলে ৫০ টাকা হারে জরিমানা আদায় করা হবে।</li>-->
    <!--    <li>পরপর ২ মাস ভাড়া পরিশোধ করতে ব্যার্থ হলে কতৃপক্ষ সংযোগ বিচ্ছিন্ন করতে পারবে।</li>-->
    <!--    <li>বিচ্ছিন্ন সংযোগ ২ মাস পর বাতিল বলে গন্য হবে।</li>-->
    <!--    <li>বিচ্ছিন্ন সংযোগ পুনরায় নিতে চাইলে বকেয়া বিল সহ পূন: সংযোগ ফি ১০০/= (একশত টাকা) প্রদান করে সংযোগ নিতে হবে।</li>-->
    <!--    <li>টিভি সেট নষ্ট থাকলে ভাড়া মওকুফ এর আপত্তি গন্য হবে না। সংযোগ চার্জ এবং ক্যাবল সম্পূর্নভাবে অফেরৎযোগ্য। সংযোগ ফি জমা দেয়ার ৩ দিনের মধ্যে সংযোগ দেয়া হবে।</li>-->
    <!--    <li>প্রতি মাসের ১ হইতে ৫ তারিখের মধ্যে অবশ্যই মাসিক ভাড়া অফিসে এসে রশিদের মাধ্যমে পরিশোধ করতে হবে। রশিদ ছাড়া কোনরুপ লেনদেনের জন্য কতৃপক্ষ দায়ী থাকবে না।</li>-->
    <!--    <li>নির্ধারিত সময়ের মধ্যে বিল পরিশোধে ব্যার্থ হলে ৫০ টাকা হারে জরিমানা আদায় করা হবে।</li>-->
    <!--    <li>পরপর ২ মাস ভাড়া পরিশোধ করতে ব্যার্থ হলে কতৃপক্ষ সংযোগ বিচ্ছিন্ন করতে পারবে।</li>-->
    <!--    <li>বিচ্ছিন্ন সংযোগ ২ মাস পর বাতিল বলে গন্য হবে।</li>-->
    <!--    <li>বিচ্ছিন্ন সংযোগ পুনরায় নিতে চাইলে বকেয়া বিল সহ পূন: সংযোগ ফি ১০০/= (একশত টাকা) প্রদান করে সংযোগ নিতে হবে।</li>-->
    <!--    <li>টিভি সেট নষ্ট থাকলে ভাড়া মওকুফ এর আপত্তি গন্য হবে না।</li>-->
    <!--    <li>এক সংযোগে একাধিক টিভি সেট চালালে প্রতি টিভি সেটের জন্য পৃথক ভাবে বিল পরিশোধ করতে হবে।</li>-->
    <!--    <li>গ্রাহকের সন্তুষ্টিই আমাদের কাম্য। আপনার কোন অভিযোগ থাকলে অভিযোগের নাম্বারে ফোন করতে হবে। আপনার অভিযোগ প্রাপ্তির ২৪ ঘন্টার মধ্যে নিষ্পত্তি করা হবে।</li>-->
    <!--    <li>আপনার গ্রাহক আইডি কার্ড টি যতœসহকারে রাখুন। অন্যথায় কার্ড হারিয়ে গেলে বকেয়া পরিশোধ সহ অতিরিক্ত ২০০ টাকা প্রদান করে নতুন আইডি কার্ড সংগ্রহ করতে হবে।</li>-->
    <!--    <li>কতৃপক্ষ দেশের রাজ¯^ আইন অনুযায়ী ক্যাবল টিভির চার্জ বৃদ্ধি করতে পারবে।</li>-->
    <!--    <li>গ্রহণযোগ্য কারন ছাড়া গ্রাহক অন্য কোন ক্যাবল অপারেটর এর নিকট হতে সংযোগ গ্রহন করতে পারবেন না।</li>-->
    <!--    <li>গ্রাহক তার সংযোগ বিচ্ছিন্ন করতে চাইলে কমপক্ষে ১ মাস পূর্বে লিখিত আবেদন করতে হবে এবং সকল বকেয়া বিল পরিশোধ করতে হবে। অন্যথায় উক্ত গ্রাহকের বিরুদ্ধে আইনগত ব্যাবস্থা গ্রহন করা হবে।</li>-->
    <!--  </ul>-->
    <!--  <p>বি: দ্র: এটি একটি সেবামলূ ক বিনোদন মাধ্যম, যাহা রক্ষনাবেক্ষন করা প্রতিটি গ্রাহকের দায়িত্ব। </p>-->
    <!--</div>-->
  </div>
</body>
</html>

