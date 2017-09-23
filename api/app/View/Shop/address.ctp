<?php 
$page  = $this->set('title_for_layout', 'Address');    
?> 
<?php echo $this->Html->script(array('addtocart.js'), array('inline' => false)); ?> 
<!--------------------Process_sec----------------------->
  <?php 
              $x=$this->Session->flash(); echo $x;  
          ?> 
<div class="process_sec menudashbrd">
  <div class="steps_sec">
    <ul class="breadcrumb">
       <li><a href="javascript:void(0);"> <?php if ($arabic != 'ar') { ?>Select Caterer<?php }else { echo "حدد كاتيرر"; } ?> </a></li>
       <li><a href="<?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['id'])){ echo $this->webroot."restaurants/menu/".$cartdata['cartInfo']['restaurant']['Restaurant']['id']; } ?>"> <?php if ($arabic != 'ar') { ?>Choose menu items<?php }else { echo "اختر عناصر القائمة"; } ?></a></li>
	<li class="active"><a href="javascript:void(0);"><?php if ($arabic != 'ar') { ?>Confirm Order<?php }else { echo "أكد الطلب"; } ?></a></li>
 
    </ul>
  </div>
</div>

<!---------------------Process_sec-------------------------> 



<!---------------------caterer_sec------------------------->
   
<div class="address_last">   
  <form action="<?php echo $this->webroot."shop/review"?>" method="POST" id="payment_form">
  <div class="container-fluid">
    <div class="row">
      
      <div class="col-sm-9">
        <div class="confrm_odr clearfix">  
        <div class="col-sm-8 col-xs-12">        
		
          
       <h1><?php if ($arabic != 'ar') { ?>Order Confirmation<?php }else { echo "تأكيد الطلب"; } ?> </h1>
       </div>
       <div class="col-sm-8 col-xs-12">
       		<div class="enter_dlvry">
			<a href="#" style="margin-right:0px;" class="active btn defult_btn pull-right"  data-toggle="modal" data-target="#Address1">
     <?php if ($arabic != 'ar') { ?>Add New Address<?php }else{ echo "إضافة عنوان جديد"; } ?></a>
       			<h2><?php if ($arabic != 'ar') { ?>Choose Delivery Address<?php }else { echo "اختر عنوان التسليم"; } ?></h2>
				
			
                        <h2><input type="radio" name="address_id" value="defalt" checked> <?php if ($arabic != 'ar') { ?>Default Address<?php }else { echo "العنوان الافتراضي"; } ?></h2> 
			<?php foreach($address as $add){ ?>
			<div class="user_details-inner">
				<h2> <input type="radio" name="address_id" value="<?php if(!empty($add['Address']['id'])) { echo $add['Address']['id'];} ?>"> <?php if(!empty($add['Address']['title'])) { echo $add['Address']['title'];} ?></h2>
                               
				<p><?php if(!empty($add['Address']['name'])) { echo $add['Address']['name'];} ?></p>
                <p><?php if(!empty($add['Address']['phone'])) { echo $add['Address']['phone'];} ?></p>
				<p><?php if(!empty($add['Address']['recipent_mobile'])) { echo $add['Address']['recipent_mobile'];} ?></p>
				<p><?php if(!empty($add['Address']['address'])) { echo $add['Address']['address'];} ?></p> 
				
			</div>
			
			<?php } ?>
       		</div>
       </div>

       <div class="col-sm-4 col-xs-12">
       	<div class="paymt_metd">
       		<h3><?php if ($arabic != 'ar') { ?>Payment Method<?php }else { echo "طريقة الدفع او السداد"; } ?></h3>
            <select name="payment_method" class="form-control">  
                <option value="payfort"><?php if ($arabic != 'ar') { ?>Payfort<?php }else { echo "Payfort"; } ?></option>
                <option value="paypal"><?php if ($arabic != 'ar') { ?>Paypal<?php }else { echo "بايبال"; } ?></option>
                <option value="cod"><?php if ($arabic != 'ar') { ?>Cod<?php }else { echo "سمك القد"; } ?></option>   
            </select>
       	</div>
        <div class="paymt_metd">
       		<h3><?php if ($arabic != 'ar') { ?>Promo Code<?php }else { echo "رمز ترويجي"; } ?></h3>
            <p style="color:red;" id="promomsg"></p>    
         <div class="search_lctn">
             <input type="hidden" id="cartrest_id" value="<?php echo $cartdata['cartInfo']['restaurant']['Restaurant']['id']; ?>"> 
        
        <input type="text" id="promocode" name="promocode" value="<?php if(isset($cartdata['cartInfo']['promocode']['Promocode']['promocode'])){ echo $cartdata['cartInfo']['promocode']['Promocode']['promocode']; } ?>" class="form-control input-sm" maxlength="64" 
               placeholder="<?php if ($arabic != 'ar') { ?>Coupon code<?php }else { echo "رمز القسيمة"; } ?>" />
        <button type="button" id="applypromo" class="btn defultpurple_btn copn_btn"><?php if( $cartdata['cartInfo']['promocode_discount'] == 0) {   if ($arabic != 'ar') { ?> Apply <?php }else { echo "تطبيق"; } }else { echo "Applied"; } ?></button>
          <button type="button" id="removepromo" class="btn defultpurple_btn copn_btn"><?php if ($arabic != 'ar') { ?>Remove Promocode<?php }else { echo "إزالة بروموكود"; } ?></button>
         </div>     
            
                
       	</div>
         
         <div id="promodata">
         </div>    
       </div>
       
        </div>
       <!-- <div class="col-xs-12">
        <div class="cancl_ply">
        <p class="text-center">Cancellation Policy</p>
        </div>
        </div>-->

      </div>
	 <?php if($cartdata['cartcount'] > 0) {?> 
     <div class="col-sm-3">
        <div class="review_order clearfix" style="margin-top: 66px;">
          <div class="review_sec">
            <div class="review_btn"> 
                <a href="<?php echo $this->webroot."shop/review"; ?>" class="btn btn-sm defult_btn view_btn"><?php if ($arabic != 'ar') { ?>Review Order<?php }else { echo "مراجعة الطلب"; } ?></a>
            </div>
             
            <div class="clearfix" id="datetimediv"> 
              <div class="date">
                <div class="form-group">
                  <h3><?php if ($arabic != 'ar') { ?>Date:<?php }else{ echo "تاريخ:"; } ?></h3>
                  <input type="text" id="eventdate" value="<?php if(isset($shop['Order']['eventdate'])) { echo $shop['Order']['eventdate']; }else{ echo date('Y/m/d'); } ?>" 
                         placeholder="<?php if ($arabic != 'ar') { ?>Event Date<?php }else { echo "تاريخ الحدث"; } ?>" name="eventdate">  
		<input type="hidden" value="<?php echo $cartdata['cartInfo']['restaurant']['Restaurant']['id'] ;?>" id="restu_id">				 
                </div>
              </div>
              <div class="time">
                <div class="form-group ">
                  <h3><?php if ($arabic != 'ar') { ?>Time:<?php }else{ echo "زمن:"; } ?></h3>
                  <p id="datepairExample">
                   <input type="text" id="etime"  name="event_time" value="<?php if(isset($shop['Order']['event_time'])) { echo $shop['Order']['event_time']; }else { echo date("h:i:sa"); } ?>"
                          placeholder="<?php if ($arabic != 'ar') { ?>Event Time<?php }else { echo "وقت الحدث"; } ?>" class="time start" />  
                  </p>   
                </div>
              </div>
		 	
            </div> 
              <div class="checkmsg" style="color:red;" id="checkmsg"></div>
            <div class="my_cartsec clearfix">
              <h3><?php if ($arabic != 'ar') { ?>My Cart<?php }else { echo "سلة التسوق"; } ?></h3>
              <hr>
              <p class="cartmesage" style="color:red;"></p>
                 <div id="added_items"> 
              </div>  
 <?php $ordertype = $this->Session->read('ordertype');

//print_r($cartdata);   
if(!empty($cartdata)){
  if (array_key_exists("products",$cartdata)) {   
foreach ($cartdata['products'] as $item):    
              
            //  print_r($key); ?>     
              <!---------------mycart_view---------------->
            <!-- <div class="mycart_view clearfix">
                <div class="mycart_left">    
                  <div class="clearfix">
                    <div class="cart_frm">
                      
                        <div class="border_crt">     
                            <a href="#" id="<?php echo $item['parent_product']['product_id'];  ?>" class="qtyminus qtyminus_bg cplus"></a>
                            <a href="#" id="<?php echo $item['parent_product']['product_id'];  ?>" class="qtyplus cmins"></a>
                            <input type="hidden" id="redirect" value="<?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['id'])) { echo $cartdata['cartInfo']['restaurant']['Restaurant']['id']; } ?>">
                        </div>  
                          <input type='text' name='quantity' value='<?php if(!empty($item['parent_product']['quantity'])){ echo $item['parent_product']['quantity']; }?>' class='qty' />
                    
                      <p><?php echo $item['parent_product']['name']; ?></p> 
                    <?php if(isset($item['associated_products'])){
                          foreach ($item['associated_products'] as $assoc_product){ ?> 
                      <p><small>-<?php echo $assoc_product['name'];  ?></small><span>SAR <?php echo $assoc_product['price'];  ?></span></p>          
                            <?php 
                          }  
                      } 
                      ?>  
                    </div>
                  </div>   
                </div>
                <div class="mycart_right">  
                  <div class="cart_price text-right"> 
                    <div><?php if(!empty($cartdata['cartInfo']['restaurant']['Restaurant']['currency']))  echo $cartdata['cartInfo']['restaurant']['Restaurant']['currency']; ?>  <?php echo $item['parent_product']['price']*$item['parent_product']['quantity']; ?><a href="<?php  echo $this->webroot."shop/remove?pro_id=".$item['parent_product']['product_id']."&res_id=".$cartdata['cartInfo']['restaurant']['Restaurant']['id']; ?>"><img src="<?php echo $this->webroot."home/";?>images/cross.png"  alt=""></a></div>
                  </div>   
                </div> 
              </div>-->
              <!---------------mycart_view---------------->
              <?php endforeach;
                }
}
              ?>
      
              <!---------------mycart_view---------------->
              <?php if($ordertype=='catering' || empty($ordertype)){ ?> 
              <div class="social_res">
                <div class="checkbox checkbox-red checkbox-circle"> 
                  <input id="checkbox8" value="1" <?php if(isset($shop['Order']['social_responsible'])&& $shop['Order']['social_responsible']==1) { echo "checked"; } ?> name="social_respons"  type="checkbox">
                  <label for="checkbox8"><?php if ($arabic != 'ar') { ?>Social Responsibility<?php }else{ echo "مسؤولية اجتماعية"; } ?></label>
                <p><?php if ($arabic != 'ar') { ?>I agree to donate my leftover food to the people in need in my community.<?php }else{ echo "أوافق على التبرع بقايا الطعام إلى الناس المحتاجين في مجتمعي."; } ?></p>
                </div>
              </div>
			  <?php } ?>
            </div>
            <!------------My Cartsec Close---------->
               <?php if($ordertype=='catering' || empty($ordertype)){ ?> 
            <div class="my_cartsec clearfix">  
              <h3><?php if ($arabic != 'ar') { ?>Our Values<?php }else{ echo "قيمنا"; } ?></h3>
              <hr>
              
                     <div class="checkbox checkbox-red checkbox-circle">
               <input id="checkbox" <?php if(isset($shop['Order']['demand_m_w'])&& $shop['Order']['demand_m_w']==1) { echo "checked"; } ?> name="demand" value="1" type="checkbox" > 
                <label for="checkbox"><?php if ($arabic != 'ar') { ?>On Demand Waiter & Waitress <?php }else{ echo "على الطلب النادل والنادلة"; } ?></label> 
              </div>
              
              	<div class="male">
                    <div class="checkbox checkbox-red checkbox-circle">
                        <input id="checkbox2" value="1" <?php if(isset($shop['Order']['waitress'])&& $shop['Order']['waitress']==1) { echo "checked"; } ?> name="waitress" type="checkbox">
                    <label for="checkbox2"> </label>
                  </div>
                  <select name="waitre_male">      
                 <option <?php if(isset($shop['Order']['demand_waiter'])&& $shop['Order']['demand_waiter']==1) { echo "selected"; } ?>   value="1">1</option>
                <option <?php if(isset($shop['Order']['demand_waiter'])&& $shop['Order']['demand_waiter']==2) { echo "selected"; } ?>  value="2">2</option>
                 <option <?php if(isset($shop['Order']['demand_waiter'])&& $shop['Order']['demand_waiter']==3) { echo "selected"; } ?>   value="3">3</option> 
                
                </select>
                <label><?php if ($arabic != 'ar') { ?>Male<?php }else{ echo "الذكر"; } ?></label> 
                </div>
              
              <div class="female"> 
                <div class="checkbox checkbox-red checkbox-circle">
                    <input id="checkbox1" value="1" <?php if(isset($shop['Order']['waitre_female_true'])&& $shop['Order']['waitre_female_true']==1) { echo "checked"; } ?> name="waitre_female_true" type="checkbox" > 
                    <label for="checkbox1"> </label>  
                  </div>
                <select name="waitre_female">       
                 <option <?php if(isset($shop['Order']['demand_waitress'])&& $shop['Order']['demand_waitress']==1) { echo "selected"; } ?>  value="1">1</option>
                <option  <?php if(isset($shop['Order']['demand_waitress'])&& $shop['Order']['demand_waitress']==2) { echo "selected"; } ?> value="2">2</option>
                 <option <?php if(isset($shop['Order']['demand_waitress'])&& $shop['Order']['demand_waitress']==3) { echo "selected"; } ?> value="3">3</option> 
               </select>
                <label><?php if ($arabic != 'ar') { ?>Female<?php }else{ echo "إناثا"; } ?></label>    
              </div> 
            </div>
			 <?php } ?> 
             <div id="total_items">  
             </div>   
            <!--<div class="fotr_totl">
            <div class="text-left">Sub Total</div>            
            </div>
            <div class="price_totl">
            <div class="text-right">&#163;<?php if(!empty($cartdata['cartInfo']['subtotal'])) { echo $cartdata['cartInfo']['subtotal']; } ?></div>            
            </div>
            
            <div class="fotr_totl"> 
            <div class="text-left">Delivery</div>            
            </div>    
            <div class="price_totl">
            <div class="text-right">&#163;0.00</div>             
            </div>
            
             <div class="fotr_totl">
            <div class="text-left total">Total</div>            
            </div>
            <div class="price_totl">
            <div class="text-right price">&#163;<?php if(!empty($cartdata['cartInfo']['total'])){ echo $cartdata['cartInfo']['total']; } ?></div>             
            </div>--> 
             <p class="minordermsg" style="color:red;"></p> 
            <div class="textarea_bx">
               <?php if(!empty($shop['Order']['notes'])) { ?> <label><?php if ($arabic != 'ar') { ?>Order Notes<?php }else{ echo "ترتيب ملاحظات"; } ?></label><br/> <?php }?>   
           <?php if(!empty($shop['Order']['notes'])) { echo $shop['Order']['notes']; }  ?>
           
            </div>
            
   
     <div class="col-sm-12">
     <div class="button_outer"> 
	 <?php   if (!empty($loggeduser)) { ?>
         <button type="submit" id="payment_btn" class="btn btn-sm defult_btn view_btn waves-effect waves-light"><?php if ($arabic != 'ar') { ?>Payment<?php }else { echo "دفع"; } ?></button>
        <?php 
	 }else{?>
       <button type="button" class="btn btn-sm defult_btn view_btn waves-effect waves-light check " style="line-height: 15px !important;height: 40px;"><?php if ($arabic != 'ar') { ?>Payment<?php }else{ echo "دفع"; } ?></button>   
      <?php 
	  }
         
        ?>  
     </div>
   </div>
          </div> 
        </div>
      </div> 
	  <?php } ?>
    </div>
  </div>
  </form>
</div>




<div id="Address1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal Content Start Here -->
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d71e24;">
        <button type="button" class="close" style="color:#fff;" data-dismiss="modal">&times;</button>
        <h2 style="margin:0px; color:#fff;"><?php if ($arabic != 'ar') { ?>Add New Address<?php }else{ echo "إضافة عنوان جديد"; } ?></h2>
      </div><!-- End Here -->
      <div class="modal-body">
        <form id='addressform2'> 
          <div class="form-group">
            <div class="msg" style="color:red;"></div>
            <input class="form-control" autocomplete="off" id="title" name="title" placeholder="Address Title" type="text" required>
            <input  id="uid" name="uid" value="<?php echo $loggeduser; ?>" type="hidden">
          </div>
          <div class="form-group">
            <input class="form-control" autocomplete="off"  id="aname" name="aname" placeholder="User Name" type="text" required>
          </div>
          <div class="form-group list-first">
            <span>+966</span>
            <input class="form-control field" autocomplete="off" maxlength="9"  id="aphone" name="aphone" placeholder="Mobile Number" type="text" required>
          </div>
          <div class="form-group list-first">  
              <span>+966</span>
            <input class="form-control field" autocomplete="off" maxlength="9" id="recipent_mobile" name="recipent_mobile" placeholder="Recipient Number" type="text" required>
          </div>
          <div class="form-group">
            <div class="msg" style="color:red;"></div>
            <div class="map-locator">
				<input class="form-control" autocomplete="off" id="aaddress" name="aaddress" placeholder="Address" type="text" required>
				<input id="aalat"  type="hidden">
				<input id="aalong" type="hidden">
				<a class="btn btn-primary" id='getlatlongadd' style="position: absolute;right:30px; top:-8px;" ><img src="<?php echo $this->webroot; ?>img/location.png"></a>
				<p class="amsg" style="color:red;"></p>
			</div>
			<div class="map_outer">
				<div id="mapaddress" style="position: absolute; right:-600px;top:0; width:500px;height:300px"></div>
			</div>
          </div>
          <div class="form-group" style="text-align:right;">
            <button class="btn btn-default defltflat_btn text-center" id="addressubmit2"  type="button" >
                <?php if ($arabic != 'ar') { ?>Submit<?php }else{ echo "عرض"; } ?> 
            <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button>
          </div>
        </form>
       <input type="hidden" value='<?php echo $this->Session->read('leadtime'); ?>' id="leadtime"> 
       <input type="hidden" value="<?php echo $cartdata['cartInfo']['restaurant']['Restaurant']['lead_time']; ?>" id="rest_leadtime"> 
       <input type="hidden" value="<?php $ordertype = $this->Session->read('ordertype'); if(!empty($ordertype)){ echo $ordertype;}else{ echo "catering"; } ?>" id="rest_ordertype"> 
	 <input type="hidden" id="min_order" value="<?php echo $cartdata['cartInfo']['restaurant']['Restaurant']['min_order']; ?>"> 
      </div><!-- End Here -->
    </div><!-- End Here -->
  </div>
</div>

<script type="text/javascript">    
 jQuery.noConflict()(function ($) {   
    
jQuery(document).ready(function() {
jQuery('.map_outer').hide();	
	
	
    jQuery("#getlatlongadd").click(function(){
        console.log('clicked')
		if(jQuery("#aaddress").val()==''){
			jQuery(".amsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Enter Address and click Map Icon!');
	 }else{
		 jQuery(".amsg").html(' ');
		jQuery('.map_outer').show();	
        jQuery.post("http://rajdeep.crystalbiltech.com/thoag/eng/restaurants/LatLongFromAddress",
        {
            address: jQuery("#aaddress").val()
        },
        function(data, status){
			console.log(data)
            console.log("Data: " + data + "\nStatus: " + status);
            if(status=='success'){
                var res = JSON.parse(data);
                displayMap(res.latitude,res.longitude)
            }
            
        });
		
	  }	
		
    });
	
	    function displayMap(latitude,longitude){
        console.log('display mapaddress')
       // $('#RestaurantLatitude').val(latitude)
       // $('#RestaurantLongitude').val(longitude)
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var mapCanvas = document.getElementById("mapaddress");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter,draggable: true});
        marker.setMap(map);
        
        google.maps.event.addListener(marker, 'dragend', function(evt){
            //console.log('dragged')
			//console.log(evt)
			//console.log(marker)
            $('#aalat').val(evt.latLng.lat())
            $('#aalong').val(evt.latLng.lng())
			GetAddress(evt.latLng.lat(),evt.latLng.lng());
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
    }
	
	
	 function GetAddress(lat,lng) {
            //var lat = parseFloat(document.getElementById("aalat").value);
           // var lng = parseFloat(document.getElementById("aalong").value);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                       // alert("Location: " + results[1].formatted_address);
					jQuery("#aaddress").val(results[1].formatted_address);
						//console.log(results[1].formatted_address)
                    }
                }
            });
        }
	
	
	
	
	
	
   
          var addressform = jQuery("#addressform2").validate({
  errorClass: "my-error-class",
    validClass: "my-valid-class", 
        rules: {
              aphone : {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  },
          recipent_mobile : {  
                 number:true,
                minlength: 9,
                maxlength: 9,
                zeronot:true
                  }
        },
        messages: {
          
          title: {  
                    required: "Please enter valid title name", 
                },
                phone: {  
                    required: "Please enter valid number(9 digits)",  
                },
         recipent_mobile: {  
                    required: "Please enter valid number(9 digits)",  
                }
        }
    });


     jQuery("#addressubmit2").click(function(e){    

     e.preventDefault();
       
        if(addressform.form())
        {
        } 
        else{
            return false;
        }      
var uid = jQuery("#uid").val();
var aaddress = jQuery("#aaddress").val();
var title = jQuery("#title").val();
var aphone = jQuery("#aphone").val();
var aname = jQuery("#aname").val();
var recipent_mobile = jQuery("#recipent_mobile").val();

// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[Address][name]='+ aname+ '&data[Address][title]='+ title+ 
        '&data[Address][address]='+ aaddress+ '&data[Address][recipent_mobile]='+ recipent_mobile+
        '&data[Address][user_id]='+ uid+'&data[Address][phone]='+ aphone;    
 
// AJAX Code To Submit Form.
jQuery.ajax({ 
type: "POST", 
url: "<?php echo $this->webroot; ?>addresses/add", 
data: dataString,
cache: false,
success: function(result){
    if(result){
      alert('Your Address has been saved.');  
  window.location.reload();
   
    } 

}
});

return false;
});

  });
        }); 

</script>   



<script>
jQuery(document).ready(function () {

jQuery('.check').click(function(e){
 alert('you must login first');  

 jQuery('#Login').modal('show');  

});




 jQuery('#payment_btn').on('click', function(e){ 
	 e.preventDefault();	
var form = jQuery("#payment_form");
	var eventdate = jQuery("#eventdate").val();
	var etime = jQuery("#etime").val();
	
        var min_order = jQuery('#min_order').val();
 var shoptotal = jQuery('#carttotal').val(); 
 var rest_leadtime = jQuery('#rest_leadtime').val(); 
  var is_offer = '<?php echo $cartdata['is_offer']; ?>'; 
//var is_open = jQuery("#is_open").val();

	
if(eventdate == '' && jQuery("#rest_ordertype").val() == 'catering'){
//jQuery('.placeorder').hide();	
jQuery(".checkmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Select Event Date and Time'); 

  jQuery('html, body').animate({
        scrollTop: jQuery("#checkmsg").offset().top 
    }, 2000); 
e.preventDefault();  
}else{

var rest_id = jQuery("#restu_id").val();
var dataString = 'eventdate='+ eventdate+" "+etime+'&res_id='+rest_id;    
 
// AJAX Code To Submit Form.
jQuery.ajax({ 
type: "POST",  
url: "<?php echo $this->webroot; ?>restaurants/menu", 
data: dataString,
cache: false,
success: function(result){
	console.log(result); 
 var obj = jQuery.parseJSON( result);
  if(obj.isSucess =='false'){ 
    jQuery(".checkmsg").html(' ');
      jQuery(".checkmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Restaurant is Unavailable for your selected Date. Either choose another restaurant or select another Date.');
		
    jQuery('html, body').animate({
        scrollTop: jQuery("#datetimediv").offset().top 
    }, 2000); 
 e.preventDefault();	
 }else if(obj.isSucess =='true'){ 
 jQuery(".checkmsg").html(' '); 
//jQuery('#restavadate').hide();  
//jQuery('.placeorder').show();
  	
}
else if(obj.isSuccess =='false'){   
     jQuery(".checkmsg").html(' ');
      jQuery(".checkmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Restaurant is Closed for selected Time. Either choose another Restaurant or select another Date/Time');
		
    jQuery('html, body').animate({
        scrollTop: jQuery("#datetimediv").offset().top 
    }, 2000); 
  e.preventDefault();		
}else if (Math.round(min_order) <= Math.round(shoptotal) && is_offer==0) {
		if(jQuery("#rest_ordertype").val() == 'catering'){
			
		if (jQuery('#leadtime').val() >= rest_leadtime || rest_leadtime == 0) { 
            form.submit();
        }else{  
             	
             jQuery(".minordermsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Opps! Min Lead Time required : ' +rest_leadtime+ ' hours');
			
			e.preventDefault();	 
		 } 
		}else{
		form.submit();	
		}	
        }else{ 
				
				if(is_offer==1){
				if(jQuery("#rest_ordertype").val() == 'catering'){
			
		if (jQuery('#leadtime').val() >= rest_leadtime || rest_leadtime == 0) { 
            form.submit();
        }else{  
             	
             jQuery(".minordermsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Opps! Min Lead Time required : ' +rest_leadtime+ ' hours');
			//alert('<p style="color:red;">Opps! Min Order required: SAR '+min_order+'</p>'); 
			 e.preventDefault();	
		} 
		}else{
		 form.submit();	
		}	
				}else{
	
             jQuery(".minordermsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Opps! Min Order required: SAR '+min_order);
			//alert('<p style="color:red;">Opps! Min Order required: SAR '+min_order+'</p>'); 
				e.preventDefault();
		}
		}
}
});
}

	
	


			
    });



	
jQuery('.time').on('change', function(){
	  
	  var event_time = jQuery('ul .ui-timepicker-selected').html();
	  var event_date = jQuery('#eventdate').val();

	jQuery.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: 'event_time='+event_time+'&event_date='+event_date,
cache: false,
dataType: "json",
success: function(result){
	console.log(result)
jQuery('#leadtime').val(result.leadtime);

}
});

 }); 
 
jQuery('#eventdate').on('change', function(){
	  
	  var event_time = jQuery('ul .ui-timepicker-selected').html();
	  var event_date = jQuery('#eventdate').val();

	jQuery.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>shop/readsession",
data: 'event_time='+event_time+'&event_date='+event_date,
cache: false,
dataType: "json",
success: function(result){
	console.log(result)
jQuery('#leadtime').val(result.leadtime);

}
});

 }); 
	

	
    var proid = jQuery('#promid').val();
    if(proid == ''){  
   jQuery('#removepromo').hide(); 
    }
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&libraries=places&callback=initAutocomplete"
        async defer></script>  
<!---------------------caterer_sec-------------------------> 