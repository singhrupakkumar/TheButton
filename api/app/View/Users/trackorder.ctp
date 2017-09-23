<div class="order_detls">
  <div class="container">    
   
   <div class="row">
   		
        <div class="col-sm-12">
		
		<?php 

if(!empty($orderdataa)):
    
   $i = 0; 
foreach($orderdataa as $order) :
    
    
    $i++;

    ?>
        	<div class="orderdtls_tbl">  
            
            <div class="table-responsive order_table order_table1">
            <h1>Order Details</h1>
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <tr>
                <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table order_inr">
                  <tr>
                    <td>Order ID:</td>
                    <td>112345</td>
                  </tr>
                  <tr>
                    <td>Order Date:</td>
                    <td>10 December, 2016 9:30PM</td>
                  </tr>
                  <tr>
                    <td>Event Date Time:</td>
                    <td>10 December, 2016 9:30PM</td>
                  </tr>
                  <tr>
                    <td>Amount Paid:</td>
                    <td>&#163;300</td>
                  </tr>
                </table>

                
                </td>
                <td >
                <div class="col-sm-9 col-sm-offset-2">
                	<h2>Anand Kumar</h2>
                    <p>Mobile: 985462598</p>
                    <p>Address: XXXXXXXXXXXX</p>
                 </div>   
                </td>
              </tr>              
            </table>

            </div>
            
            <div class="order_tblsec table-responsive">
            <h1>Order Items</h1>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <tr>
                <th>Item name</th>
                <th>Quantity</th>
                <th>Price</th>
              </tr>
              <tr>
                <td>Item 1</td>
                <td>2X&#163;10.0</td>
                <td>20.00</td>
              </tr> 
               <tr>
                <td>Item 1</td>
                <td>2X&#163;10.0</td>
                <td>20.00</td>
              </tr> 
                       
            </table>

            
            </div>
            
            <div class="order_trckng">
            <div class="odr_trckng_hed">
            	<h3>Order Tracking</h3>
              </div>  
                
            
             <div class="row bs-wizard" style="border-bottom:0;">
                
                <div class="col-xs-2 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum">Approval</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot bg-no"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Processing</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot bg-no"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Shipping</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot bg-no"></a>
                  
                </div>
                
                <div class="col-xs-4 bs-wizard-step active"><!-- active -->
                  <div class="text-center bs-wizard-stepnum">Delivery</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  
                </div>
            </div>
            
            
            
            <div class="itm_delvy">
            <p class="red_txt">Your item has been delivered</p>
            <p >Fri, 12th Dec, 2016 | 10.00 PM</p>
            <div class="voffset5">
            <button class="btn defult_btn btn-md">Cancel Order</button>
            <button class="btn defult_btn btn-md" data-toggle="modal" data-target="#reviewmodal">Review Order</button>
            <button class="btn defult_btn btn-md" data-toggle="modal" data-target="#opendmodal">Open Order</button>
            </div>
			</div>
                
            </div>
            
             </div>
             
                 <?php endforeach ;
       else:
           echo '<p style="text-align:center; font-weight:bold;"> Order list empty</p>';
       endif;
       ?> 
             
             
        </div>     
       
   </div>      
      
   
  </div>
</div>
    


<!-- Modal -->
<div id="reviewmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <img src="images/thoag.svg"  alt="">
        <h4 class="modal-title">Rating &amp; Reviews</h4>
      </div>
      <div class="modal-body rating_rvw">
	  <form action="<?php echo $this->webroot."shop/addreview"; ?>" method="post" class="reviw_from">
        <p>How did you love your catering experience?</p>
        <p class="stars rating" id="rating">
        <span class="fa fa-star"></span> 
                    <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
          <input type="hidden" name="data[Review][punctuality]" id="ratingsval" value="" required> 
		</p>
        <p>
		  <input type="hidden" name="data[Review][rest_id]" value="2"> 
          <input type="hidden" name="data[Review][uid]" value="<?php echo $loggeduser ;?>"> 
         <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
        <textarea name="data[Review][text]"  class="form-control" placeholder="Enter your Comments" rows="3"></textarea>
        </p>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default defultgrey_btn btn-sm" data-dismiss="modal">Cancel</button>
         <button type="button" class="btn btn-default defult_btn btn-sm" data-dismiss="modal">Post Review</button>
      </div>
    </div>

  </div>
</div>


<div id="opendmodal" class="modal fade" role="dialog">  
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <img src="images/thoag.svg"  alt="">
        <h4 class="modal-title">Open Dispute</h4>
      </div>
      <div class="modal-body rating_rvw">       
        <p>
        <textarea class="form-control" placeholder="Enter your Complaint" rows="3"></textarea>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default defultgrey_btn btn-sm" data-dismiss="modal">Cancel</button>
         <button type="button" class="btn btn-default defult_btn btn-sm" data-dismiss="modal">Post Complaint</button>
      </div>
    </div>

  </div>
</div>

			    <script>
      $('.rating span').each(function(){

    $(this).click(function(){
        if(!$(this).hasClass('checked')){
            $(this).addClass('checked');
            $(this).prevAll().addClass('checked');
            var rate = $('#rating .checked').length;
        }else{
            $(this).nextAll().removeClass('checked');
            var rate = $('#rating .checked').length;
        }
       
        $('#ratingsval').val(rate);
    });
});
  </script> 