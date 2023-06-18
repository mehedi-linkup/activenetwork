
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
  font-size: 13px;
}
</style>
<script type="text/javascript">
function printpage() {
  window.print();
}
printpage();
 </script>
<?php 

  $cominfo=$this->db->query("select * from tbl_profile limit 1")->row();
  $id = $this->uri->segment(2);
  $info = $this->db->where('id', $id)->get("tbl_registration")->row();
  
?>
<body style="background:none; border:3px dashed #363333;padding: 10px 5px 15px 5px;">
  <p style="text-align: center;" class="hide">
    <a href="<?php echo base_url('registration')?>" style="width: 183px;height: 30px;background: #fd0740;color: #fff;padding: 7px">Back Registration Form</a>
  </p>
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
    <hr class="bg">
    <div style="border: 1px solid #51DC8B;width: 100px; margin:0 auto;border-radius: 7px 0px;
">
      <h4 style="margin:0px;padding: 5px 0px;text-align: center;">ফরম </h4>
    </div>
    <div style="width: 100%; margin:0 auto">
    <table>
      
      <tr>
        <td colspan="3">লাইসেন্স নং: সি/ও- ৩১৭</td>
      </tr>
      <tr>
        <td width="15%">গ্রাহকেরনামঃ</td>
        <td width="35%" style="border-bottom: 1px dotted;"><?= $info->name ?></td>
        <td width="15%">পিতারনামঃ</td>
        <td width="35%" style="border-bottom: 1px dotted;"><?= $info->father_name ?></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td width="15%">মোবাইল নংঃ</td>
        <td width="35%" style="border-bottom: 1px dotted;"><?= $info->phone ?></td>
        <td width="15%">ভোটার আইডি নংঃ</td>
        <td width="35%" style="border-bottom: 1px dotted;"><?= $info->nid ?></td>
        <td></td>
        <td></td>
      </tr>
    </table>
    <table width="100%">
      <tr>
        <td width="15%">বর্তমান ঠিকানাঃ গ্রামঃ</td>
        <td width="20%" style="border-bottom: 1px dotted;"><?= $info->present_address ?></td>
        <td width="15%">হোল্ডিং নংঃ</td>
        <td width="15%" style="border-bottom: 1px dotted;"><?= $info->holding_no ?></td>
        <td width="15%">ফ্ল্যাট/বাসা নংঃ</td>
        <td width="20%" style="border-bottom: 1px dotted;"><?= $info->house_no ?></td>
      </tr>
    </table>
     <table width="100%">
      <tr>
        <td width="10%">বাড়ির নামঃ</td>
        <td width="15%" style="border-bottom: 1px dotted;"><?= $info->house_name ?></td>
        <td width="10%">পোঃ</td>
        <td width="15%" style="border-bottom: 1px dotted;"><?= $info->pre_post ?></td>
        <td width="10%">থানাঃ</td>
        <td width="15%" style="border-bottom: 1px dotted;"><?= $info->pre_thana ?></td>
        <td width="10%">জেলাঃ</td>
        <td width="15%" style="border-bottom: 1px dotted;"><?= $info->pre_district ?></td>
      </tr>
    </table>
    <table width="100%">
      <tr>
        <td width="15%">স্থায়ী ঠিকানাঃ গ্রামঃ</td>
        <td width="25%" style="border-bottom: 1px dotted;"><?= $info->parament_address ?></td>
        <td width="10%">পোঃ</td>
        <td width="20%" style="border-bottom: 1px dotted;"><?= $info->par_post ?></td>
        <td width="10%">থানাঃ</td>
        <td width="20%" style="border-bottom: 1px dotted;"><?= $info->par_thana ?></td>
      </tr>
    </table>
    <table width="100%">
      <tr>
        <td width="15%">জেলাঃ</td>
        <td width="20%" style="border-bottom: 1px dotted;"><?= $info->par_district ?></td>
        <td width="15%">সংযোগেরতারিখ</td>
        <td width="20%" style="border-bottom: 1px dotted;"><?= $info->connection_date ?></td>
        <td width="15%">সংযোগ ফি</td>
        <td width="15%" style="border-bottom: 1px dotted;"><?= $info->connection_fee ?></td>
      </tr>
    </table>
    <div style="border: 1px solid #51DC8B;width: 100px; margin:0 auto;border-radius: 7px 0px;margin-top: 7px;">
      <h4 style="margin:0px;padding: 5px 0px;text-align: center;">নিয়মাবলীঃ </h4>
    </div>
    <div>
      <ul class="rules">
        <li>সংযোগ চার্জ এবং ক্যাবল সম্পূর্নভাবে অফেরৎযোগ্য। সংযোগ ফি জমা দেয়ার ৩ দিনের মধ্যে সংযোগ দেয়া হবে।</li>
        <li>প্রতি মাসের ১ হইতে ৫ তারিখের মধ্যে অবশ্যই মাসিক ভাড়া অফিসে এসে রশিদের মাধ্যমে পরিশোধ করতে হবে। রশিদ ছাড়া কোনরুপ লেনদেনের জন্য কতৃপক্ষ দায়ী থাকবে না।</li>
        <li>নির্ধারিত সময়ের মধ্যে বিল পরিশোধে ব্যার্থ হলে ৫০ টাকা হারে জরিমানা আদায় করা হবে।</li>
        <li>পরপর ২ মাস ভাড়া পরিশোধ করতে ব্যার্থ হলে কতৃপক্ষ সংযোগ বিচ্ছিন্ন করতে পারবে।</li>
        <li>বিচ্ছিন্ন সংযোগ ২ মাস পর বাতিল বলে গন্য হবে।</li>
        <li>বিচ্ছিন্ন সংযোগ পুনরায় নিতে চাইলে বকেয়া বিল সহ পূন: সংযোগ ফি ১০০/= (একশত টাকা) প্রদান করে সংযোগ নিতে হবে।</li>
        <li>টিভি সেট নষ্ট থাকলে ভাড়া মওকুফ এর আপত্তি গন্য হবে না। সংযোগ চার্জ এবং ক্যাবল সম্পূর্নভাবে অফেরৎযোগ্য। সংযোগ ফি জমা দেয়ার ৩ দিনের মধ্যে সংযোগ দেয়া হবে।</li>
        <li>বিচ্ছিন্ন সংযোগ ২ মাস পর বাতিল বলে গন্য হবে।</li>
        <li>টিভি সেট নষ্ট থাকলে ভাড়া মওকুফ এর আপত্তি গন্য হবে না।</li>
        <li>এক সংযোগে একাধিক টিভি সেট চালালে প্রতি টিভি সেটের জন্য পৃথক ভাবে বিল পরিশোধ করতে হবে।</li>
        <li>গ্রাহকের সন্তুষ্টিই আমাদের কাম্য। আপনার কোন অভিযোগ থাকলে অভিযোগের নাম্বারে ফোন করতে হবে। আপনার অভিযোগ প্রাপ্তির ২৪ ঘন্টার মধ্যে নিষ্পত্তি করা হবে।</li>
        <li>আপনার গ্রাহক আইডি কার্ড টি যতœসহকারে রাখুন। অন্যথায় কার্ড হারিয়ে গেলে বকেয়া পরিশোধ সহ অতিরিক্ত ২০০ টাকা প্রদান করে নতুন আইডি কার্ড সংগ্রহ করতে হবে।</li>
        <li>কতৃপক্ষ দেশের রাজ¯^ আইন অনুযায়ী ক্যাবল টিভির চার্জ বৃদ্ধি করতে পারবে।</li>
        <li>গ্রহণযোগ্য কারন ছাড়া গ্রাহক অন্য কোন ক্যাবল অপারেটর এর নিকট হতে সংযোগ গ্রহন করতে পারবেন না।</li>
        <li>গ্রাহক তার সংযোগ বিচ্ছিন্ন করতে চাইলে কমপক্ষে ১ মাস পূর্বে লিখিত আবেদন করতে হবে এবং সকল বকেয়া বিল পরিশোধ করতে হবে। অন্যথায় উক্ত গ্রাহকের বিরুদ্ধে আইনগত ব্যাবস্থা গ্রহন করা হবে।</li>
      </ul>
      <p>বি: দ্র: এটি একটি সেবামলূ ক বিনোদন মাধ্যম, যাহা রক্ষনাবেক্ষন করা প্রতিটি গ্রাহকের দায়িত্ব। </p>
    </div>
  </div>
</body>
</html>