jQuery(document).ready(function () {
   jQuery.getJSON("http://rajdeep.crystalbiltech.com/thoag/shop/webdisplaycart", function (data) { 
   
   console.log(data);
        var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
       jQuery('#cartcount').html(data['data']['cartcount']);
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  console.log(data['apply']);
  var carttotalval ='';
 if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['data']['cartInfo']['total']- data['data']['cartInfo']['discount_amount']; 
 }else if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['data']['cartInfo']['total'] - data['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['data']['cartInfo']['total']) - parseFloat(data['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['data']['cartInfo']['total']);
 }
 
 var min_order_amount_for_discount = parseFloat(data['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }  */

        jQuery.each(data['data']['products'], function (index, value) {
			if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>'; 
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';    
		//console.log(data['data']['cartInfo']['min_amount_for_refferal']) 
		if(data['data']['cartInfo']['total'] > parseFloat(data['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		if(data['apply'] !=' discount' && data['data']['cartInfo']['discount_amount'] != 0 && data['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discount</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
		
			
       
         /*if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */      
        
       if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
           if(data['data']['cartInfo']['calculated_repeat_discount'] > data['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
        if(data['apply'] ==' referal') {
            totalhtml += '<tr><td>';
            totalhtml += 'Referral Reward <span class="pull-right">SAR'+data['data']['cartInfo']['refferal_discount']+'</span>';  
            totalhtml += '</td></tr>'
        };  	
        
        if(data['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo') {
            if(data['data']['cartInfo']['calculated_promo_discount'] > data['data']['cartInfo']['max_promo_discount']){
                totalhtml += '<tr><td>';
                totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_promo_discount'] + '</span>';
                totalhtml += '</td></tr>';
            }
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
            totalhtml += '</td></tr>';
        };  
         
        if(data['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] ==' promo') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
        //$('#total_items').delay(2000).fadeIn('slow');
    });
    
    
    
    
    function rmv() {
        jQuery('.remove_item').off("click").on('click', function () {
            jQuery.ajax({
                type: "POST",
                url: "http://rajdeep.crystalbiltech.com/thoag/shop/webremoveitems",
                data: {
                    id: jQuery(this).attr("id"),
                  date:jQuery(this).attr("data-date"), 
                },
                dataType: "json",
                success: function (data) { 
        var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
        if(data['cartdata']['data']['cartcount'] > 0)  { 
        jQuery('#cartcount').html(data['cartdata']['data']['cartcount']);
    }else{
		window.location.reload();
         jQuery('#cartcount').html(0);    
    }
      /*  var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
  var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /* if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }*/  

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
          if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';   
		
	if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
       
        /* if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */    
        
  if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 &&  data['apply'] ==' discount') { 
      if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
                totalhtml += '<tr><td>';
                totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
                totalhtml += '</td></tr>'
            }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () { 
                    alert('Error!');
                }
            });
            return false;
        });
        jQuery('.cplus').off("click").on('click', function () {
            console.log(jQuery(this).attr("data-date"))
                 // var ids = jQuery(this).attr("id");
	    // var ress = ids.split("_0"); 
           // var newws = ress[0];
            jQuery.ajax({
                type: "POST",
                url: "http://rajdeep.crystalbiltech.com/thoag/shop/webcart_increaseqty", 
                data: { 
                    id:jQuery(this).attr("id"),
                    date:jQuery(this).attr("data-date"),
					max:jQuery(this).attr("max"),
					stock:jQuery(this).attr("stock"),	
                },
                dataType: "json",
                success: function (data) {
      var html = '<div class="mycart_view clearfix"><div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
         jQuery('#cartcount').html(data['cartdata']['data']['cartcount']); 
		 jQuery('.cartmesage').html(' ');
		  if(data.msg){
		  jQuery('.cartmesage').html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+data.msg);
		  }
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
  var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /* if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }  */

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
           if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';   
		
		if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
       
      /*   if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */    
        
     if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {
         if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
         totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'
    }; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') { 
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () {
                    alert('Error!'); 
                }
            });
            return false;
        });
        jQuery('.cmins').off("click").on('click', function () { 
        
            //var id = jQuery(this).attr("id");  
	    // var res = id.split("_0");    
           // var neww = res[0];
            jQuery.ajax({
                type: "POST",    
                url: "http://rajdeep.crystalbiltech.com/thoag/shop/webcart_decreaseqty",         
                data: { 
                   id:jQuery(this).attr("id"), 
                   date:jQuery(this).attr("data-date"),
				   min:jQuery(this).attr("min"),
                },
                dataType: "json",
                success: function (data) {
      var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
         jQuery('#cartcount').html(data['cartdata']['data']['cartcount']);
		  jQuery('.cartmesage').html(' ');
		  if(data.msg){
		  jQuery('.cartmesage').html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+data.msg);
				}
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
 
 
  var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }  */

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
         if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';  

     if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }		
       
        /* if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'};  */   
        
       if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
           if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () {
                    alert('Error!');
                }
            });
            return false;  
        });
       
        


       
      
    }        
    
    
    
    jQuery("#applypromo").click(function () {
        var promocode = jQuery("#promocode").val();
        var rest_id = jQuery("#cartrest_id").val();
        var subtotal = jQuery(".subtotal").val();
// Returns successful data submission message when the entered information is stored in database.
        var dataString = 'promocode=' + promocode + '&rest_id=' + rest_id+'&subtotal='+subtotal;
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",
            url: "http://rajdeep.crystalbiltech.com/thoag/promocodes/webpromocode",
            data: dataString,
            cache: false, 
            dataType: "json",  
            success: function (data) {
console.log(data);
			
         var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> ';
		if(data.msg =='Promo code Applied'){ 
        jQuery('#applypromo').html('Applied');
		}
		jQuery('#promomsg').html(' ');
		jQuery('#promomsg').html(data.msg);	
		
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
 
 
 
  var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }*/  

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
           if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';   
		
		
	if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
       
       /*  if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'};   */  
        
    if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {
        if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo') {
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] ==' promo') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () {
                    alert('Error!');
                }
            });
            return false;
    });
    
    
    
    /////////////////remove promocode//////////////   
    jQuery("#removepromo").click(function () {
        var promid = jQuery("#promid").val();

        var dataString = 'promocode_id=' + promid;  
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",
            url: "http://rajdeep.crystalbiltech.com/thoag/promocodes/removePromocode",
            data: dataString,
            cache: false,
            dataType: "json",  
            success: function (data) {  
        var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
         jQuery('#applypromo').html('Apply'); 
		 
		 jQuery('#promomsg').html(' ');
		jQuery('#promomsg').html(data.msg);
		 
        /*var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
 
   var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  } */ 

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
          if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';  


		
	if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
       
     /*    if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'};  */   
        
      if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
          if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () {
                    alert('Error!');
                }
            });
            return false;
    });
    
    
    
      /////////////////down payment promocode//////////////   
    jQuery("#total_items").on('click','.downpay',function (e) {  

        e.preventDefault();         
     

      var dataString = 'downpay=' + 1;  

//alert(dataString);	
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",  
            url: "http://rajdeep.crystalbiltech.com/thoag/shop/downpayment",
            data: dataString, 
            cache: false,
            dataType: "json",  
            success: function (data) {
       var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
      /*  var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
 
   var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  } */ 

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
          if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>'; 

	if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
       
      /*   if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'};  */   
        
      if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
          if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () {
                    alert('Error!');
                }
            });   
            return false;
    });
    
    
    
        /////////////////remove payment promocode//////////////   
  
     jQuery("#total_items").on('click','.downpayremove',function (e) {  

        e.preventDefault();      
      var dataString = 'downpay=' + 0;  
 	
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",  
            url: "http://rajdeep.crystalbiltech.com/thoag/shop/remove_downpayment", 
            data: dataString, 
            cache: false,
            dataType: "json",  
            success: function (data) {
       var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['cartdata']['data']['cartInfo']['total']- data['cartdata']['data']['cartInfo']['discount_amount']; 
 }else if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['cartdata']['data']['cartInfo']['total'] - data['cartdata']['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) -  parseFloat(data['cartdata']['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']) - parseFloat(data['cartdata']['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['cartdata']['data']['cartInfo']['total']);
 }
 
    var min_order_amount_for_discount = parseFloat(data['cartdata']['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }*/  

        jQuery.each(data['cartdata']['data']['products'], function (index, value) {
          if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';   
       
	if(data['cartdata']['data']['cartInfo']['total'] > parseFloat(data['cartdata']['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['cartdata']['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['cartdata']['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		if(data['apply'] !=' discount' && data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['cartdata']['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
       /*  if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */    
        
       if(data['cartdata']['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
           if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['cartdata']['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['cartdata']['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['cartdata']['data']['cartInfo']['calculated_promo_discount'] > data['cartdata']['data']['cartInfo']['max_promo_discount']){
           totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>' 
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['cartdata']['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['cartdata']['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['cartdata']['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['cartdata']['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['cartdata']['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () { 
                    alert('Error!');   
                }
            });       
            return false;          
    }); 
	
	
	
	
	
	
	    /////////////////remove payment promocode//////////////   
  
     jQuery("#total_items").on('click','.referbenfit',function (e) {  

        e.preventDefault();      
      var dataString = 'apply= referal';  
 	
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",  
            url: "http://rajdeep.crystalbiltech.com/thoag/shop/webdisplaycart",
            data: dataString, 
            cache: false,
            dataType: "json",  
            success: function (data) {
       var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['data']['cartInfo']['total']- data['data']['cartInfo']['discount_amount']; 
 }else if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['data']['cartInfo']['total'] - data['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['data']['cartInfo']['total']) - parseFloat(data['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['data']['cartInfo']['total']);
 }
 
    var min_order_amount_for_discount = parseFloat(data['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }*/  

        jQuery.each(data['data']['products'], function (index, value) {
          if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>'; 

   if(data['data']['cartInfo']['total'] > parseFloat(data['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['data']['cartInfo']['discount_amount'] != 0 && data['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
		
       
       /*  if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */    
        
        if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
            if(data['cartdata']['data']['cartInfo']['calculated_repeat_discount'] > data['cartdata']['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['cartdata']['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['data']['cartInfo']['calculated_promo_discount'] > data['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () { 
                    alert('Error!');   
                }
            });       
            return false;          
    }); 
	
	
	
	  jQuery("#total_items").on('click','.promo',function (e) {  

        e.preventDefault();      
      var dataString = 'apply= promo';  
 	
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",  
            url: "http://rajdeep.crystalbiltech.com/thoag/shop/webdisplaycart",
            data: dataString, 
            cache: false,
            dataType: "json",  
            success: function (data) {
       var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['data']['cartInfo']['total']- data['data']['cartInfo']['discount_amount']; 
 }else if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['data']['cartInfo']['total'] - data['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['data']['cartInfo']['total']) - parseFloat(data['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['data']['cartInfo']['total']);
 }
 
    var min_order_amount_for_discount = parseFloat(data['data']['cartInfo']['min_order_amount_for_discount']);
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }*/  

        jQuery.each(data['data']['products'], function (index, value) {
          if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';  

if(data['data']['cartInfo']['total'] > parseFloat(data['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' discount' && data['data']['cartInfo']['discount_amount'] != 0 && data['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
				
       
       /*  if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */    
        
       if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
           if(data['data']['cartInfo']['calculated_repeat_discount'] > data['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') { totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'};  	
        
        if(data['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['data']['cartInfo']['calculated_promo_discount'] > data['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);     
        rmv();
                },
                error: function () { 
                    alert('Error!');   
                }
            });       
            return false;          
    });
	
	
     jQuery("#total_items").on('click','.discounts',function (e) {  

        e.preventDefault();      
      var dataString = 'apply= discount';  
 	
// AJAX Code To Submit Form.
        jQuery.ajax({
            type: "POST",  
            url: "http://rajdeep.crystalbiltech.com/thoag/shop/webdisplaycart",
            data: dataString, 
            cache: false,
            dataType: "json",  
            success: function (data) {
       var html = '<div class="mycart_view clearfix"> <div class="mycart_left"><div class="clearfix">';
        html += '<div> '; 
       /* var downcheck ='';
  jQuery.each(data['data']['products'], function (index, value) {
    downcheck =   value.parent_product.Cart.down_payment;
  });*/
  var carttotalval ='';
if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') {  
  carttotalval = data['data']['cartInfo']['total']- data['data']['cartInfo']['discount_amount']; 
 }else if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] ==' promo'){
	 carttotalval = data['data']['cartInfo']['total'] - data['data']['cartInfo']['promocode_discount']; 
 } 
 if(data['apply'] ==' referal'){
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['refferal_discount']);
 }else if(data['apply'] ==' discount'){ 
	carttotalval = parseFloat(data['data']['cartInfo']['total']) -  parseFloat(data['data']['cartInfo']['discount_amount']); 
	 
 }else if(data['apply'] ==' promo'){
	 carttotalval = parseFloat(data['data']['cartInfo']['total']) - parseFloat(data['data']['cartInfo']['promocode_discount']); 
 }else{
	 
	carttotalval = parseFloat(data['data']['cartInfo']['total']);
 }
 
    var min_order_amount_for_discount = parseFloat(data['data']['cartInfo']['min_order_amount_for_discount']);
 
 /*if(downcheck ===true){   
    var  downpayment = carttotalval * data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']/100;
       var downpaymenttotal = carttotalval - downpayment;
      carttotalval = downpayment ; 
     
  }*/  

        jQuery.each(data['data']['products'], function (index, value) {
         if(value.parent_product.Cart.product_id != null){
			
            html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.product_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.product_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.product_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}else if(value.parent_product.Cart.offer_id != null){
				
				 html += '<div class="cart_frm"><a  id=' + value.parent_product.Cart.offer_id + ' data-date="'+ value.parent_product.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.parent_product.Cart.name + '';
            html += '<div class="border_crt"><a href="#" min="'+ value.parent_product.Product.min_order_quantity +'" data-date="'+ value.parent_product.Cart.created +'" class="cmins qtyplus" id=' + value.parent_product.Cart.offer_id + '></a> <a href="#" data-date="'+ value.parent_product.Cart.created +'" max="'+ value.parent_product.Product.max_order_quantity +'" stock="'+ value.parent_product.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.parent_product.Cart.offer_id + '></a></div>';
            html += '<span>'+ value.parent_product.Cart.quantity + 'x '+ value.parent_product.Cart.price + ' SAR</span></div>';   
			}
            jQuery.each(value['associated_products'], function (index, value) {   
                      
      
         html += '<div class="cart_frm suborder"><a  id=' + value.Cart.product_id + ' data-date="'+ value.Cart.created +'" class="remove_item"><img src="http://rajdeep.crystalbiltech.com/thoag/home/images/cross.png"  alt=""></a>' + value.Cart.name + '';
         html += '<div class="border_crt"><!--a href="#" min="'+ value.Product.min_order_quantity +'" data-date="'+ value.Cart.created +'" class="cmins qtyplus" id=' + value.Cart.product_id + '></a> <a href="#" data-date="'+ value.Cart.created +'" max="'+ value.Product.max_order_quantity +'" stock="'+ value.Product.quantity +'" class="cplus qtyminus qtyminus_bg" id=' + value.Cart.product_id + '></a--></div>';
         html += '<span>'+ value.Cart.quantity + 'x '+ value.Cart.price + ' SAR</span></div>';  
         
            
       }); 
             
        
        }); 
        html += '</div></div></div></div>';      
        jQuery('#added_items').html(html);  
  
        var totalhtml = '<table class="table table_summary">';       
        totalhtml += '<tbody>';   
		
		
	if(data['data']['cartInfo']['total'] > parseFloat(data['data']['cartInfo']['min_amount_for_refferal']) && data['apply'] !=' referal' && data['data']['cartInfo']['refferal_discount'] != 0){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="referbenfit" data-receve="referral"  class="btn btn-sm defult_btn view_btn waves-effect waves-light referbenfit">Redeem Referral Reward: SAR'+data['data']['cartInfo']['refferal_discount']+'</button>';
    
		totalhtml += '</td></tr>'; }
		if(data['apply'] !=' discount' && data['data']['cartInfo']['discount_amount'] != 0 && data['data']['cartInfo']['subtotal']  >= min_order_amount_for_discount){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" id="discounts" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light discounts">Apply Discounts</button>';
    
		totalhtml += '</td></tr>'; }
		
		if(data['apply'] !=' promo' && data['data']['cartInfo']['promocode_discount'] != 0 ){ totalhtml += '<tr><td>';  
       totalhtml += '<button type="button" data-receve="2" class="btn btn-sm defult_btn view_btn waves-effect waves-light promo">Apply Promocode</button>';
    
		totalhtml += '</td></tr>'; }
		
       
       /*  if(Math.round(data['data']['cartInfo']['total']) >= Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['min_amount_for_down_payment'])) { totalhtml += '<tr><td>';  
    if(downcheck ===false) {    totalhtml += '<button type="button" id="down" class="btn btn-sm defult_btn view_btn waves-effect waves-light downpay"> Down Payment ' + Math.round(data['data']['cartInfo']['restaurant']['Restaurant']['down_payment_percentage']) + '% </button>';}
     if(downcheck ===true) { totalhtml +='<input class="btn btn-sm defult_btn view_btn waves-effect waves-light downpayremove" type="button" value="Remove Down Payment" id="downpayremove">';}
            totalhtml += '</td></tr>'}; */    
        
       if(data['data']['cartInfo']['discount_amount'] != 0 && data['apply'] ==' discount') { 
           if(data['data']['cartInfo']['calculated_repeat_discount'] > data['data']['cartInfo']['max_repeat_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Max Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_repeat_discount'] + '</span>';  
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Discount Amount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_repeat_discount'] + '</span>';  
        totalhtml += '</td></tr>'}; 
			
		 if(data['apply'] ==' referal') {
                     totalhtml += '<tr><td>';
        totalhtml += 'Maximum Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'
                     totalhtml += '<tr><td>';
        totalhtml += 'Referral Reward <span class="pull-right">SAR100</span>';  
        totalhtml += '</td></tr>'
    };  	
        
        if(data['data']['cartInfo']['discount_percentage'] != 0 && data['apply'] ==' discount') { totalhtml += '<tr><td>'; 
        totalhtml += 'Discount % <span class="pull-right">' + data['data']['cartInfo']['discount_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
        
        if(data['data']['cartInfo']['promocode_discount'] != 0 && data['apply'] !=' referal') {
            if(data['data']['cartInfo']['calculated_promo_discount'] > data['data']['cartInfo']['max_promo_discount']){
            totalhtml += '<tr><td>';
            totalhtml += 'Promocode Max Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['max_promo_discount'] + '</span>';
            totalhtml += '</td></tr>'
        }
            totalhtml += '<tr><td>';
        totalhtml += 'Promocode Discount <span class="pull-right">SAR ' + data['data']['cartInfo']['calculated_promo_discount'] + '</span><input type="hidden" id="promid" value='+ data['data']['cartInfo']['promocode']['Promocode']['id'] +'>';
        totalhtml += '</td></tr>'};  
         
        if(data['data']['cartInfo']['promocode_percentage'] != 0 && data['apply'] !=' referal') { totalhtml += '<tr><td>';  
        totalhtml += 'Promocode % <span class="pull-right">' + data['data']['cartInfo']['promocode_percentage'] + '</span>';
        totalhtml += '</td></tr>'};
		
        totalhtml += '<tr><td>';  
        totalhtml += 'Subtotal <span class="pull-right">SAR ' + data['data']['cartInfo']['subtotal'] + '</span><input type="hidden" class="subtotal" value='+data['data']['cartInfo']['subtotal']+'>'; 
        totalhtml += '</td></tr>';
        totalhtml += '<tr><td>';
        totalhtml += '  TOTAL <span class="pull-right">\n\
 SAR ' + carttotalval.toFixed(2) + '</span><input type="hidden" id="carttotal" value='+data['data']['cartInfo']['total']+'><input type="hidden" id="finaltotal" name="finaltotal" value=' + carttotalval + '>';
        totalhtml += '</td></tr>'; 
        totalhtml += '</tbody></table>';   
        jQuery('#total_items').html(totalhtml);         
        rmv();
                },   
                error: function () {   
                    alert('Error!');   
                }
            });       
            return false;                  
    }); 
	

      
});  