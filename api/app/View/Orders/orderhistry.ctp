<?php 
 echo $this->set('title_for_layout', 'Orderhistory');   
?> 
<div class="order_detls">
  <div class="container">    
   
   <div class="row">
       <div class="col-md-12">
	      <?php 
              $x=$this->Session->flash(); echo $x;  
          ?> 
	   
           <div class="order_trckng">
            <div class="odr_trckng_hed">
            	<h3><?php if ($arabic != 'ar') { ?>Order Tracking<?php }else{ echo "تتبع الطلب"; } ?></h3>
              </div>  
                
            
             <div class="row bs-wizard" style="border-bottom:0;">  
                 
                <div class="col-xs-3 bs-wizard-step <?php if($datahistory['Order']['order_status']== 1){ echo "active"; }?>">
                  <div class="text-center bs-wizard-stepnum"><?php if ($arabic != 'ar') { ?>Pending<?php }else{ echo "قيد الانتظار"; } ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($datahistory['Order']['order_status']== 1){ echo "active"; }?>"></a>
                  
                </div>
                
                <div class="col-xs-2 bs-wizard-step <?php if($datahistory['Order']['order_status']== 2){ echo "active"; }?>">
                  <div class="text-center bs-wizard-stepnum"><?php if ($arabic != 'ar') { ?>Placed<?php }else{ echo "وضعت"; } ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($datahistory['Order']['order_status']== 2){ echo "active"; }?>"></a>
                  
                </div>
                
                <div class="col-xs-2 bs-wizard-step <?php if($datahistory['Order']['order_status']== 3){ echo "active"; }?>"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum"><?php if ($arabic != 'ar') { ?>Processing<?php }else{ echo "معالجة"; } ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($datahistory['Order']['order_status']== 3){ echo "active"; }?>"></a>
                  
                </div>
                
                <div class="col-xs-2 bs-wizard-step <?php if($datahistory['Order']['order_status']== 4){ echo "active"; }?>"><!-- complete --> 
                  <div class="text-center bs-wizard-stepnum"><?php if ($arabic != 'ar') { ?>Shipping<?php }else{ echo "الشحن"; } ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($datahistory['Order']['order_status']== 4){ echo "active"; }?>"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step <?php if($datahistory['Order']['order_status']== 5){ echo "active"; }?>"><!-- active -->
                  <div class="text-center bs-wizard-stepnum"><?php if ($arabic != 'ar') { ?>Delivery<?php }else{ echo "توصيل"; } ?></div>  
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($datahistory['Order']['order_status']== 5){ echo "active"; }?>"></a> 
                  
                </div>
            </div>

            </div>
       </div>
        <div class="col-sm-12">

            
        	<div class="orderdtls_tbl">  
            
            <div class="table-responsive order_table order_table1">
            <h1><?php if ($arabic != 'ar') { ?>Order Details<?php }else{ echo "تفاصيل الطلب"; } ?></h1>
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <tr>
                <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table order_inr">
                  <tr>
                    <td><?php if ($arabic != 'ar') { ?>Order ID:<?php }else{ echo "رقم التعريف الخاص بالطلب:"; } ?></td>
                    <td><?php echo $datahistory['Order']['id']; ?></td>
                  </tr>
                  <tr>
                    <td><?php if ($arabic != 'ar') { ?>Order Date:<?php }else{ echo "تاريخ الطلب:"; } ?></td>
                    <td><?php echo $datahistory['Order']['created']; ?></td>
                  </tr>
                  <tr>
                    <td><?php if ($arabic != 'ar') { ?>Event Date Time:<?php }else{ echo "الحدث تاريخ الوقت:"; } ?></td>
                    <td><?php echo $datahistory['Order']['event_datetime']; ?></td>
                  </tr>
                  <tr>
                    <td><?php if ($arabic != 'ar') { ?>Amount Paid:<?php }else{ echo "المبلغ المدفوع:"; } ?></td>
                    <?php
                    $disprice  = $datahistory['Order']['subtotal'] - $datahistory['Order']['total'];
                    $discount = $disprice*100/$datahistory['Order']['subtotal']; 

					if($datahistory['Order']['promocode_id'] !=0 ){ ?>
					
				  <td>SAR  <strike style="color:#d41f1f;"><?php if($datahistory['Order']['subtotal'] != $datahistory['Order']['total']) {  echo round($datahistory['Order']['subtotal'], 2); } ?></strike>  
                    <span style="color:#d41f1f;"><?php  echo round($datahistory['Order']['discount_percentage'], 2)."% off"; ?></span>  <?php echo round($datahistory['Order']['total'], 2); ?>
					<p>(Max Discount Limit SAR <?php echo $datahistory['Order']['discount_amount']; ?>)</p>
					</td> 	
				<?php
				}elseif($datahistory['Order']['discount_id'] !=0 ){	
					?> 
				  <td>SAR  <strike style="color:#d41f1f;"><?php if($datahistory['Order']['subtotal'] != $datahistory['Order']['total']) {  echo round($datahistory['Order']['subtotal'], 2); } ?></strike>  
                    <span style="color:#d41f1f;"><?php  echo round($datahistory['Order']['discount_percentage'], 2)."% off"; ?></span>  <?php echo round($datahistory['Order']['total'], 2); ?>
					<p>(Max Discount Limit SAR <?php echo $datahistory['Order']['discount_amount']; ?>)</p>
					</td> 	
				<?php }elseif($datahistory['Order']['discount_id'] ==0 && $datahistory['Order']['promocode_id'] ==0 &&$datahistory['Order']['discount_amount'] != null){?>
				  <td>SAR  <strike style="color:#d41f1f;"><?php if($datahistory['Order']['subtotal'] != $datahistory['Order']['total']) {  echo round($datahistory['Order']['subtotal'], 2); } ?></strike>  
                    <span style="color:#d41f1f;"><?php  echo $datahistory['Order']['discount_amount']." off"; ?></span>  <?php echo round($datahistory['Order']['total'], 2); ?>
					<p>(Referral Reward Received SAR <?php echo $datahistory['Order']['discount_amount']; ?>)</p>
					</td> 
				
				<?php }else{ ?>
                    <td>SAR  <strike style="color:#d41f1f;"><?php if($datahistory['Order']['subtotal'] != $datahistory['Order']['total']) {  echo round($datahistory['Order']['subtotal'], 2); } ?></strike>  
                    <span style="color:#d41f1f;"><?php  echo round($datahistory['Order']['discount_percentage'], 2)."% off"; ?></span>  <?php echo round($datahistory['Order']['total'], 2); ?></td> 
				<?php }?>	
                  </tr>
                </table>

                
                </td>
                <td >
                <div class="col-sm-9 col-sm-offset-2">
                	<h2><?php echo $datahistory['Order']['name']; ?></h2>
                    <p><?php if ($arabic != 'ar') { ?>Mobile: <?php }else{ echo "التليفون المحمول:"; } ?><?php echo $datahistory['Order']['phone']; ?></p>
                    <p><?php if ($arabic != 'ar') { ?>Address: <?php }else{ echo "عنوان:"; } ?><?php echo $datahistory['Order']['billing_address']; ?></p>
                 </div>   
                </td>
              </tr>              
            </table>

            </div>
            
            <div class="order_tblsec table-responsive">
            <h1><?php if ($arabic != 'ar') { ?>Order Items<?php }else{ echo "طلب بضاعة"; } ?></h1>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <tr>
                <th><?php if ($arabic != 'ar') { ?>Item Name<?php }else{ echo "اسم العنصر"; } ?></th> 
                <th><?php if ($arabic != 'ar') { ?>Quantity<?php }else{ echo "كمية"; } ?></th>
                <th><?php if ($arabic != 'ar') { ?>Price<?php }else{ echo "السعر"; } ?></th>
              </tr>
              <?php foreach ($datahistory['OrderItem'] as $item): ?>
              <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['quantity']; ?> X <?php echo $datahistory['Restaurant']['currency']; ?> <?php echo $item['price']; ?></td>
                <td> <?php echo $item['quantity']*$item['price']; ?></td>
              </tr> 
              <?php endforeach; ?>
            </table>

            
            </div>
            <div class="itm_delvy">
            <p class="red_txt"><?php if($datahistory['Order']['order_status']==5){ ?><?php if ($arabic != 'ar') { ?>Your item has been delivered<?php }else{ echo "تم تسليم العنصر"; } ?></p><?php } ?>
            <p ><?php echo $datahistory['Order']['delivery_schedule_time']; ?></p>
            <div class="voffset5"> 
           <?php if($datahistory['Order']['order_status']== 1){ ?> <button class="btn defult_btn btn-md" type="button" onclick=" if (confirm('Are you sure you want to cancel order?')) {  
    window.location.href='<?php echo $this->webroot;?>orders/userorder_cancel/<?php echo $datahistory['Order']['id']; ?>'; 
  }"><?php if ($arabic != 'ar') { ?>Cancel Order<?php }else{ echo "الغاء الطلب"; } ?></button><?php }elseif($datahistory['Order']['order_status']== 5){  ?> 
            <button class="btn defult_btn btn-md" data-toggle="modal" data-target="#reviewmodal"><?php if ($arabic != 'ar') { ?>Review Order<?php }else{ echo "مراجعة الطلب"; } ?></button>
           <?php
           } 
         $orderdate = $datahistory['Order']['created'];  
       $createDate = new DateTime($orderdate);
       $strip = $createDate->format('Y-m-d');
        $now = time(); // or your date as well
$your_date = strtotime($strip);
$datediff = $now - $your_date;

 $datecount = floor($datediff / (60 * 60 * 24));
 if($datecount < 2 && $datahistory['Order']['order_status']==5){   
?>
            <button class="btn defult_btn btn-md" data-toggle="modal" data-target="#opendmodal"><?php if ($arabic != 'ar') { ?>Open Dispute<?php }else{ echo "نزاع مفتوح"; } ?></button>  
 <?php } ?>
            </div>
			</div>   
             </div>
            
            
<!-- Modal --> 
<div id="reviewmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
          <form action="<?php echo $this->webroot."shop/addreview"; ?>" method="post" class="reviw_from">
      <div class="modal-header">
       <img src="<?php echo $this->webroot;?>home/images/thoag.svg"  alt="">  
        <h4 class="modal-title"><?php if ($arabic != 'ar') { ?>Rating & Reviews<?php }else{ echo "التقييم"; } ?></h4>
      </div>
      <div class="modal-body rating_rvw"> 
	
        <p><?php if ($arabic != 'ar') { ?>How did you love your Order Experience?<?php }else{ echo "كيف كنت تحب تجربة تقديم الطعام الخاص بك؟"; } ?></p>
        <p class="stars rating" id="rating">
        <span class="fa fa-star"></span> 
                    <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span> 
                     <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
          <input type="hidden" name="data[Review][punctuality]" id="ratingsval" value="" required>    
		</p>
        <p>
		  <input type="hidden" name="data[Review][rest_id]" value="<?php echo $datahistory['Order']['restaurant_id']; ?>"> 
          <input type="hidden" name="data[Review][uid]" value="<?php echo $loggeduser ;?>"> 
         <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
        <textarea name="data[Review][text]"  class="form-control" placeholder="Enter your Comments" rows="3"></textarea>
        </p>
	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default defultgrey_btn btn-sm" data-dismiss="modal"><?php if ($arabic != 'ar') { ?>Cancel<?php }else{ echo "إلغاء"; } ?></button>
         <button type="submit" class="btn btn-default defult_btn btn-sm"><?php if ($arabic != 'ar') { ?>Post Review<?php }else{ echo "مراجعة آخر"; } ?></button> 
      </div>
        </form>
    </div>
  
  </div>
</div>
 <script>
      jQuery('.rating span').each(function(){

    jQuery(this).click(function(){
        if(!jQuery(this).hasClass('checked')){
            jQuery(this).addClass('checked');
            jQuery(this).prevAll().addClass('checked');
            var rate = jQuery('#rating .checked').length;
        }else{
            jQuery(this).nextAll().removeClass('checked');
            var rate = jQuery('#rating .checked').length;
        }
       
        jQuery('#ratingsval').val(rate); 
    });
});
  </script> 
 
        </div>     
       
   </div>      
      
   
  </div>
</div>
      




<div id="opendmodal" class="modal fade" role="dialog">  
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?php echo $this->webroot."disputes/add";?>" method="POST"> 
      <div class="modal-header">
       <img src="<?php echo $this->webroot;?>home/images/thoag.svg"  alt="">  
        <h4 class="modal-title">Open Dispute</h4>
      </div>
      <div class="modal-body rating_rvw">       
        <p>
             <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"> 
            <input type="hidden" name="order_id" value="<?php echo $datahistory['Order']['id']; ?>">
		<?php if(!empty($dispute)) {
			echo $dispute['Dispute']['message'];
		}else{ ?>		
        <textarea class="form-control" name="complaintmsg" placeholder="Enter your Complaint" rows="3"></textarea>
		<?php } ?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default defultgrey_btn btn-sm" data-dismiss="modal">Cancel</button>
        <?php if(empty($dispute)) { ?> <button type="submit" class="btn btn-default defult_btn btn-sm">Post Complaint</button> <?php } ?>
      </div>
     </form>       
    </div>

  </div>
</div>

			   