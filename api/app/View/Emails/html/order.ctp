<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet"> 
</head>

<style>
	body{
		background: url(img/bgplait.png) repeat #dddddd;
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
		
.brdr_btmm {
    border-bottom: 1px solid #ccc;
    padding: 10px 5px;
    color: #2d2e29;
	
}
.brdr_btmm1 {
    border-bottom: 1px solid #ccc;
    padding: 10px 5px;
    color: #2d2e29;
	border-top: 1px solid #ccc;
	
}
.brdr_btm1 {
    border-bottom: 1px solid #ccc;
    color: #2d2e29
}
.brdr_btm {
    border-bottom: 1px solid #ccc;
    color: #2d2e29;
	border-top: 1px solid #ccc;
}
.brdr_btm2 {
    width: auto;
    padding: 6px 0px 5px 97% !important;
    float: left;
}
.pay_sum{
	  color: #2d2e29;
}
.order_id{
color: #7c7d77;
font-size: 13px;
padding-top: 0px;
padding-bottom: 0px;	
}
.order_id1{
color: #7c7d77;
font-size: 13px;
padding-top: 0px;
padding-bottom: 14px;	
}
</style>

<body>

<table width="500" border="0" cellpadding="10" cellspacing="0" style="margin:0px auto; background:#f0f0f0; text-align:center;">
  <tr style="background:#f0f0f0; ">
    <td style="text-align:center; padding-top:20px; padding-bottom:20px; ">
    	<img src="http://rajdeep.crystalbiltech.com//thoag/home/images/logo.png" alt="img" />
    </td>
  </tr>
  <tr>
    <td>
		<h2>Hi <?php echo $shop['Order']['name']; ?></h2>
	
    	<h2>Thanks for ordering with Thoag</h2>
        <p>Here's your order summary</p>
        
        
        
        
       <table width="100%" border="0" cellpadding="10" bgcolor="#f2f2f2" style="background-color:#e2e2e2; margin:20px 0px;">
       <thead>
       <tr>
        <td class="pay_sum" style=" color: #2d2e29;" align="left" style="text-align:left;">PAYMENT SUMMARY</td>
       </tr>
       <tr>
         <td class="order_id" style="color: #7c7d77;
font-size: 13px;
padding-top: 0px;
padding-bottom: 0px;" align="left" style="text-align:left;">Order Id: <?php echo $shop['Order']['id']; ?></td>
       </tr>
       <tr>
          <td class="order_id1" style="color: #7c7d77;
font-size: 13px;
padding-top: 0px;
padding-bottom: 14px;" align="left" style="text-align:left;">Date: <?php echo $shop['Order']['created']; ?></td>
       </tr>
       </thead>
<?php foreach ($shop['OrderItem'] as $item):?>	   
  <tr>
    <td class="brdr_btmm1" align="left" style="text-align:left;"><?php echo $item['name']; ?> (<?php echo $item['quantity']; ?> * <?php echo $item['price']; ?>)</td>
    <td class="brdr_btm" style=" border-bottom: 1px solid #ccc;
    color: #2d2e29;
	border-top: 1px solid #ccc;" align="left" style="text-align:right;"><?php echo $item['price']*$item['quantity']; ?></td>
  </tr>
<?php endforeach; ?>
  <tr>
    
    <td colspan="2" class="brdr_btm1" style="  border-bottom: 1px solid #ccc;
    color: #2d2e29" align="left" style="text-align:right;"><b><?php echo $shop['Restaurant']['currency']; ?> <?php echo $shop['Order']['total']; ?></td>
  </tr>
</table>
 
        
        
        
        
        <p>Issused on behalf of<br /><span style="color:#2d2e29; font-size:20px; line-height: 29px;">Thoag</span>.</p>

    </td>
  </tr>
  
  
  

</table> 





</body>
</html>  
 