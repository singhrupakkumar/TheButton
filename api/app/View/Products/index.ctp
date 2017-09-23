<?php 
 echo $this->set('title_for_layout', 'Live Events');   
?> 
<style>
    p.counter1 {
    margin-bottom: -2px;
    float: right;
    margin-right: 43px;
}
 </style>   
   <script> 
//        jQuery(document).ready(function() {
//            alert('c');
//            jQuery('.counter').counterUp({   
//                delay: 10,
//                time: 10000
//            });
//        });
//        
      (function($) {
    $.fn.countTo = function(options) {
        // merge the default plugin settings with the custom options
        options = $.extend({}, $.fn.countTo.defaults, options || {});

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(options.speed / options.refreshInterval),
            increment = (options.from - options.to) / loops;

        return $(this).each(function() {
            var _this = this,
                loopCount = 0,
                value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                $(_this).html(value.toFixed(options.decimals));

                if (typeof(options.onUpdate) == 'function') {
                    options.onUpdate.call(_this, value);
                }

                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;

                    if (typeof(options.onComplete) == 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,  // the number the element should start at
        to: 100,  // the number the element should end at
        speed: 10000,  // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,  // the number of decimal places to show
        onUpdate: null,  // callback method for every time the element is updated,
        onComplete: null,  // callback method for when the element finishes updating
    };
})(jQuery);  
    </script>  

 <script type="text/javascript">
//    jQuery(function($) {
//        $('.counter').countTo({
//            from: 500,
//            to: 0,
//            speed: 1000000,
//            refreshInterval: 50,
//            onComplete: function(value) {
//                //console.debug(this);
//            }
//        });
//    });
    
   $(document).ready(function(){
    $('.counter1').each(function () {
  var $this = $(this);
  var minprice = $(this).attr('min-price');
  jQuery({ Counter: $this.text() }).animate({ Counter: minprice-1 }, {
    duration: 10000,
    easing: 'swing',
    step: function () {
    
      $this.text(Math.ceil(this.Counter));
    }
  });
});
       
   }); 


(function(ip) {
var hbeat = function() {

 $.ajax({
        url: "https://rupak.crystalbiltech.com/thebuttonapp/users/getrandom",
        type: "post",
        data: ip ,
        dataType: "json",
        success: function (response) { 
          //console.log(response);
             //   $("#1").find("div.username").html(response+' is Winning');
             
      $('.username').html(response+' is Winning');
        }
    });

//$('.username').html('Rupak is winning');

};
hbeat();
setInterval(hbeat,60000); 
})('<?php echo mt_rand(5, 15); ?>');  
</script>
 <div id="anchored-container">
    <div id="reminder-banner" style="display: none;"> <img class="reminder-image right10"> <span class="fa fa-heart right5"></span> <span class="reminder-text">Up now. Tap to view.</span>
      <button class="close">×</button>
    </div>
    <div id="anchored-reminders-group" style="display: none;"></div>
    <div id="anchored-slots-group"></div>
  </div>
  <div class="container">
    <div class="alert text-center" id="banner-group" style="background-color: rgb(224, 220, 232); opacity: 1; display: none;"></div>
  </div>
  <div class="container">
    <div class="row" id="reminder-group"></div>
  </div>
  <div style="position: relative;">
    <div class="container">
      <div class="row" id="slot-group" style="display: block;">
          
          <?php
          if(!empty($live_event_cat[0]['Product'])):
          foreach($live_event_cat[0]['Product'] as $liveproduct): ?>
        <div class="default slot slot-auction" id="<?php echo $liveproduct['id']; ?>">
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 slot-grid-wrapper">
            <div class="slot-wrapper">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-left">
                    <div class="lot-image-holder"> <img class="lot-image img-responsive" src="<?php echo $this->webroot."/files/product/".$liveproduct['image']; ?>" style="" alt="<?php echo $liveproduct['name']; ?>"> </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-left col-right">
                  <button class="bid-button btn btn-lg btn-block btn-success" style="">
                  <input class="bid-button-lot-id" value="46172670" type="hidden">
                  <input class="bid-button-amount" value="3" type="hidden"> 
                  <div class="row bid-button-text-wrapper">
                    <div class="col-xs-12">
                      <div class="bid-button-title">Buy Now</div>
                      <div class="bid-button-subtitle" style="display: block;">$<p class="counter1" min-price="<?php echo $liveproduct['min_price']; ?>"> <?php echo $liveproduct['price']; ?></p></div> 
                    </div>
                  </div>
                  <div class="bid-button-timer-wrapper">
                    <div class="bid-button-timer reset" style="width: 223px;"></div>
                  </div>
                  </button>
                  <div class="slot-details">
                    <div class="state" style="color: rgb(103, 78, 167);"><strike>Starting $<?php echo $liveproduct['price']; ?></strike></div>
                    <div class="high-bidder username" style="color: rgb(153, 153, 153);"> </div>
                    <div class="row">
                      <div class="col-xs-5" style="padding-right: 0;">
                        <div class="retail" style="color: rgb(119, 119, 119);">200 sold</div>
                      </div>
                      <div class="col-xs-7" style="padding-left: 7px;">
                        <div class="discount" style="color: rgb(68, 157, 68);"><?php echo $liveproduct['views']; ?> <i class="fa fa-eye" aria-hidden="true"></i>
</div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
        endforeach;
        else:
         echo "<p>No Products founds</p>" ;  
        endif;
        ?>  
          
         
      </div>
    </div>
  </div>
  <div class="hide">
    <div class="default slot slot-auction" id="slot-auction">
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 slot-grid-wrapper">
        <div class="slot-wrapper">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-left">
              <div class="lot-image-holder"> <img class="lot-image img-responsive" src="#"> </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-left col-right">
              <button class="bid-button btn btn-disabled btn-lg btn-block">
              <input class="bid-button-lot-id" type="hidden">
              <input class="bid-button-amount" type="hidden">
              <div class="row bid-button-text-wrapper">
                <div class="col-xs-12">
                  <div class="bid-button-title"></div>
                  <div class="bid-button-subtitle"></div>
                </div>
              </div>
              <div class="bid-button-timer-wrapper">
                <div class="bid-button-timer"></div>
              </div>
              </button>
              <div class="slot-details">
                <div class="state"></div>
                <div class="high-bidder"></div>
                <div class="row">
                  <div class="col-xs-5" style="padding-right: 0;">
                    <div class="retail"></div>
                  </div>
                  <div class="col-xs-7" style="padding-left: 7px;">
                    <div class="discount"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="bid-count"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slot slot-auction anchored-slot" id="anchored-slot">
      <div class="container">
        <div class="row">
          <div class="col-xs-1">
            <button class="close"> <span class="fa fa-close"></span> </button>
          </div>
          <div class="col-xs-5 col-sm-2 col-md-1"> <img class="lot-image anchored-image" src="#"> </div>
          <div class="hidden-xs hidden-sm col-md-2">
            <div class="slot-details"> <span class="retail"></span> <br>
              <span class="discount"></span> </div>
          </div>
          <div class="hidden-xs col-sm-6 col-md-5">
            <div class="slot-details">
              <div class="state"></div>
              <div class="high-bidder"></div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-3">
            <button class="bid-button btn btn-disabled btn-lg btn-block">
            <input class="bid-button-lot-id" type="hidden">
            <input class="bid-button-amount" type="hidden">
            <div class="row bid-button-text-wrapper">
              <div class="col-xs-12">
                <div class="bid-button-title"></div>
                <div class="bid-button-subtitle"></div>
              </div>
            </div>
            <div class="bid-button-timer-wrapper">
              <div class="bid-button-timer"></div>
            </div>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- close img discount state bid-button --> 
    <!-- xs  1     5   0        0     6 = 12 --> 
    <!-- sm  1     2   0        6     3 = 12 --> 
    <!-- md  1     1   2        5     3 = 12 --> 
    <!-- lg  1     1   2        5     3 = 12 -->
    
    <div class="anchored-reminder" id="anchored-reminder">
      <div class="container">
        <div class="row">
          <div class="col-xs-1"> &nbsp; </div>
          <div class="col-xs-3 col-sm-2 col-md-1"> <img class="img-responsive" src="#"> </div>
          <div class="col-xs-7 col-sm-6 col-md-7 text-and-heart"> <span></span> <i class="fa fa-heart fa-2x pull-right"></i> </div>
        </div>
      </div>
    </div>
    <div class="slot slot-reminder" id="slot-reminder">
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="slot-wrapper"> <img class="lot-image"> <span class="body"> Coming Up Soon </span> <span class="fa fa-heart"></span> </div>
      </div>
    </div>
  </div>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script>
        /*!
* jquery.counterup.js 1.0
*
* Copyright 2013, Benjamin Intal http://gambit.ph @bfintal
* Released under the GPL v2 License
*
* Date: Nov 26, 2013
*/(function(e){"use strict";e.fn.counterUp=function(t){var n=e.extend({time:400,delay:10},t);return this.each(function(){var t=e(this),r=n,i=function(){var e=[],n=r.time/r.delay,i=t.text(),s=/[0-9]+,[0-9]+/.test(i);i=i.replace(/,/g,"");var o=/^[0-9]+$/.test(i),u=/^[0-9]+\.[0-9]+$/.test(i),a=u?(i.split(".")[1]||[]).length:0;for(var f=n;f>=1;f--){var l=parseInt(i/n*f);u&&(l=parseFloat(i/n*f).toFixed(a));if(s)while(/(\d+)(\d{3})/.test(l.toString()))l=l.toString().replace(/(\d+)(\d{3})/,"$1,$2");e.unshift(l)}t.data("counterup-nums",e);t.text("0");var c=function(){t.text(t.data("counterup-nums").shift());if(t.data("counterup-nums").length)setTimeout(t.data("counterup-func"),r.delay);else{delete t.data("counterup-nums");t.data("counterup-nums",null);t.data("counterup-func",null)}};t.data("counterup-func",c);setTimeout(t.data("counterup-func"),r.delay)};t.waypoint(i,{offset:"100%",triggerOnce:!0})})}})(jQuery);

    </script>    
