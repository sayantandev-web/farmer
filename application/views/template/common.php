<?php $settings=$this->Apimodel->getSettings(); ?>
<!DOCTYPE html>
<html>
<head>
   <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
<body>
   <div style="width:600px;margin: 0 auto;background: #fff;font-family: 'Poppins', sans-serif; border: 1px solid #e6e6e6; font-size:13px;">
      <div style="padding: 30px 30px 15px 30px;box-sizing: border-box;">
        <div style="border-bottom:2px solid grey;">
         <img src="<?=base_url('uploads/logos/logo.png')?>" style="width:200px; margin-top: 0 auto;"></div><br/>
         <p style="font-size:15px;color:blue;">Thank you for registering with MadeToSplit, we are super excited that you are here! Your account has been successfully created with the following credentials, email & password. Please verify your email here to confirm & complete registration.</p>
         <p><?php echo @$mail_content; ?></p>
          <!--<p>If you need any  assitance while using our website, please reply directly to this mail.</p>-->
          <h3>Thank You</h3>
          <h4>MadeToSplit Team</h4>
          <p><a href="<?=base_url()?>" target="_blank"> madetosplit.com</a></p>
          <p>E-mail: <a href="mailto:info@madetosplit.com"> info@madetosplit.com</a></p>
          <!--<p>To Unsubscribe <a href="<?= base_url('unsubscribe/'.$email)?>" style="color:#000; text-decoration:none;"> Click Here  </a> </p>-->
         </div>
         
      </div>

   </body>
   </html>
