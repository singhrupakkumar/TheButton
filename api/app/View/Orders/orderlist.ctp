<?php $this->set('title_for_layout', 'orderlist');   ?> 
<style>
  .pagination>li {
    display: inline;
    float: left;
}
.imaginary_container{
  width: 50%;
}
.imaginary_container form{
  width: 100%;
  float: left;
  text-align: right;
}
.imaginary_container form input[type="text"]{
  box-sizing: border-box;
    width: auto;
    padding: 0;
    float: none;
    display: inline-block;
    margin: 0px;
    height: 45px;
    padding: 0px 11px;
    background: none;
    background-color: #fff;
}
.imaginary_container form #ordersearch{
  float: none;
    padding: 0px;
    border: none;
    background: none;
    display: inline-block;
    border: 1px solid #f34848;
    height: 45px;
    padding: 0px 20px;
    background-color: #f34848;
    color: #fff;

}
</style>
<?php // print_r($data);?>
<div class="smart_container">
<!--------------------Your Order_sec----------------------->
	<div class="ur_ordr_sec">
              
            <div class="ur_order">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                  <h3>Order History</h3> 
                </div>
              </div>
            </div>            
            </div>
               

	</div>

<!---------------------Your Order_sec-------------------------> 



<!---------------------Have A Questions------------------------->

<div class="urorder">
  <div class="container-fluid">    
   
   <div class="row">
   		
        <div class="col-sm-10 col-sm-offset-1">
        	<div class="order_tbl">
                    <div class="imaginary_container pull-right"> 
                    <form method="POST">    
                    <input type="text" name="orderid" class="form-control"  placeholder="Search by order ID" >                   
                    <button id="ordersearch"><i class="fa fa-search" aria-hidden="true"></i></button>   
                     </form> 
                    </div>
            	
           
            
            
            <div class="order_tblsec table-responsive">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Caterer Name</th>
                <th>Status</th>
                <th>Payment Type</th>
                <th>Total</th>
                <th>Order Date</th>
                 
              </tr>
              </thead>
              <tbody>
              <?php
              $datalist = $fdata?$fdata:$data;
                if(!empty($datalist)){   
                 foreach($datalist as $list): ?>
              <tr>
                <td data-label="Order ID"><a href="<?php echo $this->webroot."orders/orderhistry/".$list['Order']['id']; ?>"><?php echo $list['Order']['id']; ?></a></td>
                <td data-label="Caterer Name"><?php echo $list['Restaurant']['name']; ?></td>
                <td data-label="Status">
                  <?php if($list['Order']['order_status']==1){ echo "Pending"; }elseif($list['Order']['order_status']==2)
                   { echo "Placed"; }elseif($list['Order']['order_status']==3)
                   { echo "Processing"; }elseif($list['Order']['order_status']==4)
                   { echo "Shipped"; }elseif($list['Order']['order_status']==5)
                   { echo "Delivery"; }elseif($list['Order']['order_status']==6)
                   { echo "User Cancelled"; }elseif($list['Order']['order_status']==7)
                   { echo "Freeze Order"; }  
                  ?>  
                </td>
                <td data-label="Payment Type"><?php echo $list['Order']['order_type']; ?></td>
                <td data-label="Total"><?php echo $list['Restaurant']['currency']; ?> <?php echo $list['Order']['total']; ?></td>
                <td data-label="Order Date"><?php echo $list['Order']['created']; ?></td>
                
              </tr> 
              <?php 
            endforeach ;
                }else{
                    echo "<tr><td colspan='6' style='text-align: center;'>No Orders Yet!</td></tr>";
                    }
                ?>
             
              </tbody>           
            </table>

            
            </div>
            
             </div>
             
             
            
               <?php echo $this->Paginator->numbers(array(
    'before' => '<nav class="text-center order_pg"><ul class="pagination">', 
    'separator' => '', 
    'tag' => 'li',
    'after' => '</ul></nav>' 
      )); ?>  

        </div>     
       
   </div>      
      
   
  </div>
</div>
</div>