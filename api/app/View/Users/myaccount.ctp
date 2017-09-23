
<style type="text/css">
.offer-sec{
    width: 100%;
    display: table;
    position: relative;
}
.offer-sec img{    
    width: 100%;
}
.offer-sec p{
    margin: 0px;
    position: absolute;
    right: 100px;
    bottom: 10px;
    color: #fff;
    font-style: italic;
    font-size: 16px;
}
</style>
<div id="fb-root"></div>
<script> 
window.fbAsyncInit = function() {
FB.init({appId: '1366372560094822', status: true, cookie: true,
xfbml: true});
};
(function() {
var e = document.createElement('script'); e.async = true;
e.src = document.location.protocol +
'//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
}());
</script>

<div class="welcome_sec">
            <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?> 
            <div class="welcom_prfl">
            <div class="welcome_bg"> <img src="<?php echo $this->webroot."home/";?>images/welcome_bg.png" class="img_head" alt=""></div>
            <div class="welcome_txt">
            	<h1><?php if ($arabic != 'ar') { ?>Welcome<?php }else{ echo "أهلا بك"; } ?>, <?php echo $data['User']['name']; ?></h1>
                <ul> 
                <li><span>(<?php echo $odata; ?>) <?php if ($arabic != 'ar') { ?>All Orders <?php }else{ echo "جميع الطلبات"; } ?></span></li>   
                <li><a href='<?php echo $this->webroot.$arb."/users/favouritie_caterers"; ?>'> (<?php echo $favcount; ?>) <?php if ($arabic != 'ar') { ?>Favourite Caterers<?php }else{ echo "المطاعم المفضلة"; } ?></a></li> 
                </ul>
<a href="<?php echo $this->webroot; ?>orders/orderlist"><button class="btn defult_btn view_btn"><?php if ($arabic != 'ar') { ?>View Order History<?php }else{ echo "عرض سجل الطلبات"; } ?> <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button></a>
            </div>  
            </div>         

	</div>

        <?php       
          if ($data['User']['image'] != '') {  
                    if (!filter_var($data['User']['image'], FILTER_VALIDATE_URL) === false) {
                         $image = $data['User']['image'];
                    } else {
                      $image= $this->webroot."files/profile_pic/".$data['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                     $image= $this->webroot."files/profile_pic/no_img.png";
                }                     
        ?>
<div class="profile_sec_inner pass_gap">
 <div class="container">
    <div class="row">
        <div class="col-md-12">
          <?php 
              $x=$this->Session->flash(); echo $x; 
          ?>
        </div>
		<div class="row">
      <div class="col-md-12">
        <h3><?php if ($arabic != 'ar') { ?>My Account<?php }else{ echo "حسابي"; } ?></h3>
      </div>
			<!--<div class="col-sm-8 col-center">-->
            <div class="col-sm-9 ">
				<div class="edit_box">				
					<div class="well well-sm">
						<div class="row">
							<div class="col-sm-6 col-md-4">
                                                           
								<figure class="profile_avtar" id="preview"> 
									<img src="<?php echo $image; ?>" width="380" height="500" alt="" class="img-rounded img-responsive" />
								</figure>
                                                             
								<form action="<?php echo $this->webroot; ?>users/myaccount" method="POST" id="imageform" enctype= multipart/form-data >
									<div class="pic_up_sec">
										<input type="file" name="data[User][image]" id="imageupload" value=""/>
										<span><?php if ($arabic != 'ar') { ?>Choose Your Image<?php }else{ echo "اختر صورتك"; } ?></span>
									</div>
                                                                      
								</form>
                                                             
							</div>
							<div class="col-sm-6 col-md-8">
								<div class="user_details">  
                                                                        <?php if(!empty($data['User']['name'])){ ?><p><strong><?php if ($arabic != 'ar') { ?>Name :<?php }else{ echo "اسم :"; } ?></strong><?php echo $data['User']['name']; ?></p><?php } ?>
									<?php if(!empty($data['User']['email'])){ ?><p>
										<strong><?php if ($arabic != 'ar') { ?>E-mail :<?php }else{ echo "البريد الإلكتروني:"; } ?></strong> <?php echo $data['User']['email']; ?>
									</p><?php } ?>  
									<p>
										<strong><?php if ($arabic != 'ar') { ?>Referral code :<?php }else{ echo "كود الإحالة :"; } ?></strong>
										<span class="clipboard_outer">
                                                                                <span style="display:none;" id="shairebaseurl"><?php echo $this->html->url('/', true); ?>users/sharecode/<?php if($data['User']['referral_code']) { echo $data['User']['referral_code']; } ?></span>      
											<span class="clipboard" id="clipboard">
                                                                                       
												<?php if($data['User']['referral_code']) { echo $data['User']['referral_code']; } ?>
											</span>
                                                                                <button type='button' id="copyButton" class="copy_btn"><?php if ($arabic != 'ar') { ?>Click to Copy<?php }else{ echo "انقر للنسخ"; } ?></button>
										</span> 
									</p>  
									<p class="align_left"><strong>Step 1</strong><?php if ($arabic != 'ar') { ?>First copy this code<?php }else{ echo "أولا نسخ هذا الرمز"; } ?></p>
										<p class="align_left"><strong>Step 2</strong><?php if ($arabic != 'ar') { ?>Paste the code to get exciting discounts  <?php }else{ echo "الصق الشفرة للحصول على خصومات مثيرة"; } ?>
										</p>
										<p class="align_left"><strong>Step 3</strong><?php if ($arabic != 'ar') { ?>Save money with us<?php }else{ echo "توفير المال معنا"; } ?></p> 
                                                                                <p class="align_left"><strong><?php if ($arabic != 'ar') { ?>Share:  <?php }else{ echo "شارك: "; } ?> </strong><span class="size" id="share_button"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></span>
                                                                                   <a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $this->html->url('/', true); ?>users/sharecode/<?php if($data['User']['referral_code']) { echo $data['User']['referral_code']; } ?>&pubid=ra-42fed1e187bae420&title=ThoagReferralcode%20%7C%<?php if($data['User']['referral_code']) { echo $data['User']['referral_code']; } ?>&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a>
                                                                                 </p> 
                                                               
                                                                
                                                                </div> 
							</div>
                            <div class="col-md-12">
                                <div class="offer-sec">
                                    <img src="<?php echo $this->webroot; ?>img/referrel.png">
                                    <p>Tell them about us<br /> and get <strong><?php if($setting[0]['Setting']['dimension']==1){ echo "%"; }elseif($setting[0]['Setting']['dimension']==2){ echo "SAR"; } ?> <?php echo $setting[0]['Setting']['value']; ?></strong> on their first purchase.</p>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
            
            
         <div class="col-sm-3 ">
        
        
        <div class="review_order review_order22 clearfix">
          <div class="review_sec">
   
            <div class="review_btn review_btn2"> 
                <a href="#" class="btn btn-sm defult_btn view_btn waves-effect waves-light">Referral Rewards</a>
            </div>
		<?php
if(empty($referdata['data'])){  
    echo $referdata['msg']; 
}else{
  foreach($referdata['data'] as $refer):   ?>	  
           <div class="centerdiv">   
            <div class="my_cartsec clearfix my_referral">
                    <?php
echo $this->Html->image("/home/images/reff_gift.png", array(
    "alt" => "logo",
    'url' => array('controller' => 'products', 'action' => 'index')
));              
 ?>
              <h3 style="text-align:center;">Congratulations!<br>
            </h3>
             
             
              <div class="social_res social_res1">
               <p>Free food upto <strong><?php if($setting[0]['Setting']['dimension']==1){ echo "%"; }elseif($setting[0]['Setting']['dimension']==2){ echo "SAR"; } ?> <?php echo $setting[0]['Setting']['value']; ?> on order above SAR<?php echo $setting[4]['Setting']['value']; ?> for inviting <?php if(!empty($refer['User']['name'])) { echo $refer['User']['name']; } ?></p>
			 </div>
             
             </div>
             <div class="col-sm-12">
     <div class="button_outer"> 
         <button type="submit" class="btn btn-sm defult_btn view_btn view_btn2 waves-effect waves-light">Expires <?php if(!empty($refer['Order']['valid_till'])) { echo $refer['Order']['valid_till']; } ?></button>
          <hr />
     </div>
   </div>
          </div> <!-- centerdiv -->  
          <?php endforeach; 
}
?>
 
          </div> 
        </div>
      </div>
           
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
		</div>
    </div>
</div> 
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('#share_button').click(function(e){
e.preventDefault();
FB.ui(
{
method: 'feed',
name: 'Thoag Referral Code: <?php if($data['User']['referral_code']) { echo $data['User']['referral_code']; } ?>',
link: 'http://rajdeep.crystalbiltech.com/thoag/users/sharecode/<?php if($data['User']['referral_code']) { echo $data['User']['referral_code']; } ?>',
picture: 'http://rajdeep.crystalbiltech.com/thoag/home/images/logo.png',
caption: 'Thoag',
description: 'Please use this referral code for thoag account registration and get benefits.',
message: ''
}); 
});
});
</script>
<script>
    document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("shairebaseurl"));
});

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
 
        // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
          
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
  if(succeed== true){
     jQuery('#copyButton').text('Copied');  
  }
    return succeed;
}
</script>
<!--<form action="<?php echo $this->webroot; ?>users/wallet" method="POST" enctype= multipart/form-data >
    Enter Money<input type="number" name="data[User][money]" value=""/>
    <input type="hidden" name="data[User][uid]" value="<?php echo $data['User']['id']; ?>"/>
    <input type="submit" name="submit" value="Add Wallet Money">
</form>-->   