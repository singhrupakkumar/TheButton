<div class="row">
      <div class="col-md-9">
        <div data-columns="3" id="grid">
            
              <?php 
			if(!empty($products)):

			foreach ($products  as $val): ?>
           <div class="column size-1of3"> 
             <div class="panel panel-default panel-catalog"  data-toggle="modal" data-target="#prodtdescr">
              <div class="panel-heading" >
                <div class="discount">-80%</div>
                 <?php echo $this->Html->Image('/files/product/'. $val['Product']['image'], array('alt' => $val['Product']['name'], 'class' => 'img-responsive lot-show')); ?> 
               
	      </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="pricing"> <span class="price">$<?php echo  $val['Product']['price'] ;?></span> <span class="msrp">$<?php echo  $val['Product']['price'] ;?></span> </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="ratings">
                                   <?php
                                        $i=round($val['Product']['avg_rating']);
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                       <span class="fa fa-star" style="color: #f0ad4e;"></span> 
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <span class="fa fa-star-half-o" style="color: #f0ad4e;"></span>
                                        <?php 
                                        
                                        } 
			                    ?> 
                     
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="bought-this">2k+ bought this</div>
                  </div>
                </div>
              </div>
              <div class="panel-footer">
                <div class="row">
                  <div class="col-xs-6 panel-separator"> <i class="fa fa-heart-o remind-me" data-lot-id="30134427" data-position="1"></i> <span class="reminder-count">3702</span> </div>
                  <div class="col-xs-6">
                    <div class="buy-it-now" data-lot-id="30134427"> <i class="fa fa-shopping-cart"></i> <span>Buy</span> </div>
                  </div>
                </div>
              </div>
            </div>
           </div>    
                <!---------product_item--------------->
               <?php endforeach ; 
		else:
		 echo "Product Not find";
		 endif;
		 
			   ?>
           
  
</div>
 </div>
    
    <div class="col-md-3">
        <hr class="visible-xs">
        <h3>Electronics Catalogs:</h3>
        <div class="panel panel-default panel-selected">
          <div class="panel-body">
            <p><a href="/catalogs/9180">Electronics</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9180"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/c7c432019cdf61a16bbe0a688239fb57/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9180"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/d9d43d4423e411b9ce9904e7b183c544/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9180"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/9819dad7c60916e79390e90cd766483e/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9186">Electronics: Accessories</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9186"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/35e99db02baa20a6c9322f21663ca458/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9186"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/5e79358b91f5a4bcb1771f68058c0bbe/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9186"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/67f8593f99cee569d852b25df407620c/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9182">Hardware (Computers/Tablets/Phones)</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9182"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/c23a3eec908d022ccba3bf841b1d4837/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9182"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/76ba0502492b389338002904422230f5/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9182"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/a5a31b6d4b70b026ee2c18b19a78f185/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9181">Audio</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9181"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/0bd282f0d165b892ba5bbde4e9bc1357/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9181"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/759fab35864d2806c0438cf410f994ae/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9181"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/e0a32b30ccb46d7780dd46c1523727e3/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9185">Gaming</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9185"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/2ca0fc435580955c46728bedebf36daa/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9185"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/ba454695bb598fdcd55db72328c840fb/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9185"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/40c0d64b21b14d88079909e880d7eddd/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9184">Photography/Camera</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9184"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/d6b594cf34cb7d90bb23bb5de4959860/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9184"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/cf3358c7ec6bdc12fa94e213e447dc60/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9184"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/cf3358c7ec6bdc12fa94e213e447dc60/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9183">TV &amp; Projectors</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9183"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/f1cb25701d681c1dce8de402626383c8/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9183"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/e3c005e5ee3229a19d570737d2622b64/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9183"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/643bf83757e7649e4523af90f4874a6e/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p><a href="/catalogs/9187">Electronics: Other</a></p>
            <div class="row">
              <div class="col-xs-4"> <a href="/catalogs/9187"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/c6c4852a5ee59b95deb9e328e8beda4c/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9187"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/7442da464f80d5372b82fac5c3be8c73/square.jpg"> </a> </div>
              <div class="col-xs-4"> <a href="/catalogs/9187"> <img class="img-responsive" src="https://d38eepresuu519.cloudfront.net/a1c336226209ccd7699fd6b58f4ac4a7/square.jpg"> </a> </div>
            </div>
          </div>
        </div>
      </div>

 </div>

