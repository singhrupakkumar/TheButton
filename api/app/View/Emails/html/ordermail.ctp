<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet"> 
</head>

<style>
	body{
		background: url(http://rajdeep.crystalbiltech.com/thoag/mail/bgplait.png) repeat #dddddd;
		margin:0px auto;
		font-family: 'Roboto', sans-serif;
		font-weight:400;
		background-size: 160px;
		}
	h2{
		font-weight:500;
		margin-bottom:1px;
		}
	p{
		color:#666;
		font-size:14px;
		}
	.reset{
		background:#cb202d;
		padding:15px 20px;
		text-transform:uppercase;
		display:inline-block;
		color:#fff;
		border-radius: 4px;
		text-decoration:none;
		font-weight:500;
		}
</style>

<body style="padding:15px 0; background: url(http://rajdeep.crystalbiltech.com/thoag/mail/bgplait.png) repeat #dddddd; ">
<table width="400" border="0" cellpadding="10" cellspacing="0" style="margin:0px auto; background:#f0f0f0; text-align:center;">
  <tr style="background:#fff;">
    <td style="text-align:center; padding-top:20px; padding-bottom:20px;">
    	<img src="http://rajdeep.crystalbiltech.com/thoag/mail/logo.png" alt="img" />
    </td>
  </tr>
  <tr>
<td>
<h2>Hi <?php echo $shop['Order']['name']; ?></h2>
<h2 style="margin-top:0;">Thanks for ordering with The Button App</h2>
<?php if($shop['Order']['order_status']==2){
$img_src = "https://rupak.crystalbiltech.com/thebutton/api/mail/placed.png";
}else if($shop['Order']['order_status']==1){
$img_src = "https://rupak.crystalbiltech.com/thebutton/api/mail/confirmed.png";
}else if($shop['Order']['order_status']==6){
$img_src = "https://rupak.crystalbiltech.com/thebutton/api/mail/cancelled.png";
}else if($shop['Order']['order_status']==7){
$img_src = "https://rupak.crystalbiltech.com/thebutton/api/mail/freezed.png";
}else{
$img_src = "https://rupak.crystalbiltech.com/thebutton/api/mail/placed.png";
}  ?>
<h3><img width="100%" src="<?php echo $img_src; ?>" /></h3>
    </td>
  </tr>
  <tr>
    <td>
    
<table width="100%" border="0" cellpadding="2" style="background:#fff; border:1px solid #ddd; border-radius:5px; padding:10px;">
<tr style="border-bottom:1px solid #ccc; float:left; width:100%;">
	<td style="text-align:left; color:#000; font-size:15px; float:left;">BILL DETAILS</td>
    <td style="text-align:right; color:#000; font-size:15px; float:right;">$</td>
</tr>
  <tr>
    <td colspan="2" style="float:left;">Order Id : <span style="color:#cb202d;"><?php echo $shop['Order']['id']; ?></span></td>
  </tr>
    <!-- Order Items -->
    <?php if(isset($shop['OrderItem'])){ foreach($shop['OrderItem'] as $item){ ?>
        <tr>
            <td style="float:left; color:#666;"><?php echo $item['name']." x ".$item['quantity']; ?></td>
            <td style="float:right; text-align:right;"><?php echo $item['price']*$item['quantity']; ?></td>
        </tr>
    <?php } }?>
    <?php if($shop['Order']['discount_amount']>0){ ?>
        <tr>
            <td style="float:left; color:#090;">Coupon discount</td>
            <td style="float:right; text-align:right; color:#090;">-<?php echo $shop['Order']['discount_amount'] ?></td>
        </tr>
    <?php } ?>
  
  <tr style="border-top:1px solid #CCC; float:left; width:100%;">
    <th style="float:left; color:#000;">Total</th>
    <th style="float:right; text-align:right;"><?php echo $shop['Order']['total'] ?></th>
  </tr>
</table>
    
    </td>
  </tr>
    <?php if($shop['Order']['delivery_status']==2){ ?>
  <tr>
    <td>
        <table width="100%" border="0" cellpadding="2" style="background:#fff; border:1px solid #ddd; border-radius:5px; padding:10px;">
        
        
        
        <tr>
            <td colspan="2" style="border-bottom:1px solid #ccc;"><p style="margin:0; text-align:left; color:#000; font-size:15px;">Order Summery</p></td>
        </tr>
          <tr>
            <td colspan="2" style="float:left; text-align:left;">
            <p>Hi <?php echo $shop['Order']['name']; ?> </p>
            <p style="margin:0; color:#999;"> Address : <?php echo $shop['Order']['billing_address'];  ?></p>
            <p style="margin:0; color:#999;">Order Status : <?php echo $shop['OrderStatus']['status'];  ?></p>
            
            <!--p>We'll let you know when the other package from this order is dispatched.</p-->
            
            </td>
          </tr>
</table>
</td>
</tr>
    <?php } ?>

<tr>
	<td>
    	<table width="100%" border="0" cellpadding="2" style="background:#fff; border:1px solid #ddd; border-radius:5px; padding:10px;">
        
        
        
        <tr>
            <td colspan="2" ><img width="200px" src="https://rupak.crystalbiltech.com/thebutton/api/mail/sentwith.png" /></td>
        </tr>
          <tr>
            <td colspan="2" style="float:left; text-align:left;">
            <p style="color:#999;">We hope you had an enjoyable food experience on The Button App. </p>

            </td>
          </tr>
      
</table>
    </td>
</tr>
</body>
</html>     