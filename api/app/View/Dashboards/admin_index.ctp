<section class="admin_main-sec">
    <div class="sec_inner">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-line-chart" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number"><?php echo $total_orders; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money" aria-hidden="true"></i></span>  

            <div class="info-box-content">
              <span class="info-box-text">Total Sale Amount</span>
              <span class="info-box-number">$<?php echo $total_sale_amount[0][0]['total']; ?></span>  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
 
        <div class="col-md-3 col-sm-6 col-xs-12">  
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-undo" aria-hidden="true"></i></span>  

            <div class="info-box-content">
              <span class="info-box-text">Total Return Order</span>
              <span class="info-box-number"><?php echo $refund_order; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Members</span>
              <span class="info-box-number"><?php echo $total_users; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          
          <!-- /.box -->
          <div class="row">
 
            <div class="col-md-12">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Members</h3>

                  <div class="box-tools pull-right">
                    <!--<span class="label label-danger">8 New Members</span>-->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                      <?php if(isset($latest_members)){ foreach($latest_members as $member){ ?>
                    <li>
                        <img src="<?php echo $member['User']['image']; ?>" alt="User Image">
                      <a class="users-list-name" href="#"><?php echo $member['User']['name']; ?></a>
                      <!--<span class="users-list-date">Today</span>-->
                    </li>
                    <?php }}else{
                    echo "<li style='width:100%;float: left;height: auto;text-align: left;'> No members Yet! </li>";
                    } ?>
                   
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="<?php echo $this->Html->url(array('controller'=>'users','view'=>'index')); ?>" class="btn btn-sm btn-info btn-flat pull-right">View All Users</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Orders</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                 
                    <th>Status</th>
                    <th>Total Items</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php if(isset($latest_orders)){ foreach($latest_orders as $order){
                      $order_id = $order['Order']['id'];
                      ?>
                        <tr>
                            <td><a href="<?php echo $this->Html->url(array('controller'=>'orders','view'=>'view',$order_id)); ?>"><?php echo $order['Order']['id']; ?></a></td>
                        
                            <td><span class="label label-success"><?php echo $order['OrderStatus']['status']; ?></span></td>
                            <td>
                              <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo count($order['OrderItem']); ?></div>
                            </td>
                        </tr>
                      <?php }} ?>
                  
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
              <a href="<?php echo $this->Html->url(array('controller'=>'orders','view'=>'index')); ?>" class="btn btn-sm btn-info btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Added Products</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                  <?php if($latest_products){ foreach($latest_products as $product){ ?>
                <li class="item">
                  <div class="product-img">
                      <img src="<?php echo $product['Product']['image']; ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><?php echo $product['Product']['name']; ?>
                      <span class="label label-warning pull-right">$<?php echo $product['Product']['price']; ?></span></a>
                        <span class="product-description">
                            <?php echo $product['Product']['description']; ?>
                        </span>
                  </div>
                </li>
                <?php }}else{ ?>
                <li class="item">No Products Yet!</li>
                <?php } ?>
                <!-- /.item -->
                
              </ul>
            </div>
            <!-- /.box-body -->
<!--            <div class="box-footer text-center">
              <a href="javascript:void(0)" class="uppercase">View All Products</a>
            </div>-->
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
</section>
<style>
    .products-list .product-description{
	display: block;
	color: #999;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	max-width: 250px;
}
</style>