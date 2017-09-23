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
</style>

<body>

<table width="500" border="0" cellpadding="0" cellspacing="0" style="margin:0px auto; background:#fff; text-align:center;">
  <tr style="background:#f0f0f0;">
    <td style="text-align:center; padding-top:20px; padding-bottom:20px;">
    	<img src="http://rajdeep.crystalbiltech.com//thoag/home/images/logo.png" alt="img" /> 
    </td>
  </tr>
  <tr>
    <td> 
    	<h2>Hi <?php if(!empty($user['User']['name'])) { echo $user['User']['name']; }else { echo $user['User']['email']; } ?></h2>
        <p>Did you just make a request to reset your passwoard ? <br />
Yes ? Go right ahead.</p>
        
        <a class="reset" href="<?php echo $link ;?>">Reset my password</a>
        
        <p>If the big red button does not work, copy and paste <br /> the following link in your browser.</p>
	<?php echo $link; ?>
    </td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>



</body>
</html>
