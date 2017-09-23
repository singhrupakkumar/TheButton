<div class="con_main pass_gap review">
        <div class="container">  
        <div class="edit">
                <h2><?php if ($arabic != 'ar') { ?>Review Your Order<?php }else{ echo "راجع طلباتك"; } ?></h2>
                <div class="col-sm-9 col-center">
                    <div class="edit_box">
                        <div class="event_date">
                            <h3><?php if ($arabic != 'ar') { ?>Event Details<?php }else{ echo "تفاصيل الحدث"; } ?></h3>
                            <table class="table table-bordered table-hover table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th><?php if ($arabic != 'ar') { ?>Caterer Name<?php }else{ echo "اسم مقدم الخدمة"; } ?></th> 
                                        <th><?php if ($arabic != 'ar') { ?>Date<?php }else{ echo "تاريخ"; } ?></th>
                                        <th><?php if ($arabic != 'ar') { ?>Time<?php }else{ echo "زمن"; } ?></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>  
                                        <?php if(!empty($cart_dataa['cartInfo']['restaurant']['Restaurant']['name'])) { ?><td><?php echo $cart_dataa['cartInfo']['restaurant']['Restaurant']['name'];?></td> <?php } ?>
                                        <?php if(!empty($shop['Order']['eventdate'])) { ?> <td><?php echo $shop['Order']['eventdate'];?></td><?php } ?>
                                       <?php if(!empty($shop['Order']['event_time'])) { ?> <td><?php echo $shop['Order']['event_time'];?></td><?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="order_item">
                            <h3><?php if ($arabic != 'ar') { ?>Order Item(s)<?php }else{ echo "طلب بضاعة)"; } ?></h3>
                            <table class="table table-bordered table-hover table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th><?php if ($arabic != 'ar') { ?>Product Name<?php }else{ echo "اسم المنتج"; } ?></th>
                                        <th><?php if ($arabic != 'ar') { ?>Price<?php }else{ echo "السعر"; } ?></th>
                                        <th><?php if ($arabic != 'ar') { ?>QTY<?php }else{ echo "الكمية"; } ?></th>
                                        <th><?php if ($arabic != 'ar') { ?>Notes<?php }else{ echo "ملاحظات"; } ?></th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php   
                                   //  print_r($cart_dataa['cartInfo']);      
                                    foreach ($cart_dataa['products'] as  $item):
                                         
                                        ?>
                                    <tr>
                                        <td><?php echo $item['parent_product']['Cart']['name']; ?></td>
                                        <td>SAR <?php echo $item['parent_product']['Cart']['price']; ?></td>
                                        <td><?php echo $item['parent_product']['Cart']['quantity']; ?></td>
                                        <td><p><?php echo $item['parent_product']['Cart']['notes']; ?></p></td>
                                    </tr>
                                    <?php if(!empty($item['associated_products'])):
                                        foreach($item['associated_products'] as $assoitem):
                                        ?>
                                     <tr>
                                        <td><?php echo $assoitem['Cart']['name']; ?></td>    
                                        <td>SAR <?php echo $assoitem['Cart']['price']; ?></td>
                                        <td><?php echo $assoitem['Cart']['quantity']; ?></td>
                                        <td><p><?php echo $assoitem['Cart']['notes']; ?></p></td>
                                    </tr>
                                   <?php   
                                   endforeach ;
                                              endif;
                                   endforeach ; 
                                   ?> 
                                </tbody>
                            </table>
                        </div>
                        <div class="demand_sec"> 
                            <h3><?php if ($arabic != 'ar') { ?>Your demand for Waiter and Waitress<?php }else{ echo "طلبك على النادل والنادلة"; } ?></h3>
                            <table class="table table-bordered table-hover table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;"><?php if ($arabic != 'ar') { ?>Male<?php }else{ echo "الذكر"; } ?></th>
                                        <th style="width: 50%;"><?php if ($arabic != 'ar') { ?>Female<?php }else{ echo "إناثا"; } ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
               <?php if(!empty($shop['Order']['demand_waiter'])) { ?><td style="width: 50%;"><?php echo $shop['Order']['demand_waiter'];?></td><?php } ?>
              <?php if(!empty($shop['Order']['demand_waitress'])) { ?><td style="width: 50%;"><?php echo $shop['Order']['demand_waitress'];?></td> <?php } ?>
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                        <div class="not_sec">
                                <h3><?php if ($arabic != 'ar') { ?>Your Notes<?php }else{ echo "ملاحظاتك"; } ?></h3>
                               <?php if(!empty($shop['Order']['notes'])) { ?>  <p><?php echo $shop['Order']['notes'];?></p><?php } ?>
                        </div>
                        <div class="total_sec">
                            <table class="table table-bordered table-hover table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;"><?php if ($arabic != 'ar') { ?>Sub Total<?php }else{ echo "جنوب إجمالي"; } ?></th>
                                        <th style="width: 50%;"><?php if ($arabic != 'ar') { ?>Total<?php }else{ echo "مجموع"; } ?></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
     <?php if(!empty($cart_dataa['cartInfo']['subtotal'])) {
         
        // $carttotalval ='';
 if($cart_dataa['cartInfo']['discount_amount'] != 0) { 
  $carttotalval = $cart_dataa['cartInfo']['total']- $cart_dataa['cartInfo']['discount_amount'];    
 }else if($cart_dataa['cartInfo']['promocode_discount'] != 0){
	 $carttotalval = $cart_dataa['cartInfo']['total'] - $cart_dataa['cartInfo']['promocode_discount']; 
 }
 $downcheck = '';
  foreach ($cart_dataa['products'] as  $item){
    $downcheck =  $item['parent_product']['Cart']['down_payment'];
  }
 if($downcheck == 1){      
   $downpayment = $carttotalval * $cart_dataa['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
  // $downpaymenttotal = $carttotalval - $downpayment; 
      $carttotalval = $downpayment ;   
     
  } 
         
         ?><td style="width: 50%;">SAR <?php echo $cart_dataa['cartInfo']['subtotal']; ?></td> <?php } ?> 
    <?php if(!empty($cart_dataa['cartInfo']['total'])) { ?> <td style="width: 50%;"`>SAR <?php echo $carttotalval; ?></td><?php } ?>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-sec">
                              <?php
                              $it = 0;
                              foreach ($shop['OrderItem'] as $key => $item):
                               $it++;   
                           if($it==1){
                            ?>
                            <a href="<?php echo $this->webroot."restaurants/menu/".$item['res_id']; ?>" class="btn btn-default btn-reviev pull-left"><?php if ($arabic != 'ar') { ?>Back To Menu<?php }else{ echo "العودة إلى القائمة"; } ?></a>
                            <?php

                           }
                                  ?>
                                     
                                    <?php endforeach; ?>
                                <a href="<?php echo $this->webroot."shop/address"; ?>" class="btn btn-default btn-reviev pull-right"><?php if ($arabic != 'ar') { ?>Checkout<?php }else{ echo "الدفع"; } ?></a>
                        </div>
                    </div>
                </div>
        </div>
    </div> 
</div>     