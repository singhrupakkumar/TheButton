<?php
//$catname  = $category['Category']['name'];
echo $this->set('title_for_layout', $category['Category']['name']);
 
$this->Html->addCrumb('Categories', '/categories/');
//$this->Html->addCrumb('Categories'); 
  
/*foreach ($parents as $parent) {
    $this->Html->addCrumb($parent['Category']['name'], '/category/' . $parent['Category']['slug']);

}*/ 

?>
<style>
.ftr_pagination .pagination > li.current {
    /* border: 1px solid #dadada; */
    padding: 8px 14px;
	    line-height: 20px !important;
    background-color: #000;
    color: #fff;
    float: left;
}
</style>
<div class="container">



<?php if (!empty($products)): ?>

<?php echo $this->element('products'); ?>

<?php 
else:
    echo "<h3>Product Not Founds </h3>";
endif; ?>
             
</div>

<script>
  jQuery(document).ready(function ($) {
	  $(".tooltip").eq(0).addClass("slid1");
	  $(".tooltip").eq(1).addClass("slid2");
	  var k1 = $(".slid1").text();
	  var k2 = $(".slid2").text();
	   $("#r1").val(k1);
	   $("#r2").val(k2);
  });
  </script>
  
 
<style>

.tooltip {
	
	 color: #fff;
    display: block;
    font: 10px Arial,sans-serif;
    height: 15px;
    opacity: 1;
    position: absolute;
    text-align: center;
    top: -21px;
    width: auto;
	background-color:#626262;
	padding:1px 2px;
}
.ui-slider-handle {
/*	position: absolute;
	z-index: 2;
	width: 29px;
	height: 31px;
	cursor: pointer;
	/*background: url('./img/range_arrow.png') no-repeat 50% 50%;*/
	outline: none;
	top: -7px;
	margin-left: -12px;*/
}
.ui-slider-range {
	background:#eecb19;
	position: absolute;
	border: 0;
	top: 1px;
	height: 7px;
	border-radius: 25px;
}
#textarea_one{
	margin-left: 0;
    margin-top: -18px;
}
#textarea_two {
	margin-left: 192px;
	margin-top: -25px;
}
#textarea_one, #textarea_two {
	font-weight: 700;
	font-family: Arial;
	font-size: 11px;
	color: #959595;
}
  </style>
   <script src="<?php echo $this->webroot; ?>frontend/js/slick.js" type="text/javascript" charset="utf-8"></script>
   <script>
  jQuery(document).ready(function ($) {
	  $(".tooltip").eq(2).addClass("slid11");
	  $(".tooltip").eq(3).addClass("slid21");
	  var k11 = $(".slid11").text();
	  var k22 = $(".slid21").text();
	   $("#r11").val(k11);
	   $("#r21").val(k22);
	   

	   
  });
  </script>
<style>
#slider1 {
	width: 64%;
	position: absolute;
	height: 7px;
	background: #e1e1e1 ;
       border-radius:5px;
top:13px;
margin-left:10px;
}
.tooltip {
	
	/* color: #000;
    display: block;
    font: 10px Arial,sans-serif;
    height: 15px;
    opacity: 1;
    position: absolute;
    text-align: center;
    top: -8px;
    width: 31px;*/
}
.ui-slider-handle {
	  border-color: transparent transparent #eecb19;
    border-style: solid;
    border-width: 0 0 11px;
    cursor: pointer;
    height: 16px;
    margin-left: -12px;
    outline: medium none;
    position: absolute;
    top: -7px;
    width: 12px;
    z-index: 2;
	/*background: url('./img/range_arrow.png') no-repeat 50% 50%;*/

}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { background:#eecb19; border:1px solid #eecb19;}

.ui-slider-handle:after {     border-color: #eecb19 transparent transparent;
    border-style: solid;
    border-width: 9px 9px 0;
    content: "";
    height: 0;
    left: 0;
    position: absolute;
    top: 16px;
    width: 0;}
	
.ui-slider-range {
	background:#d2b728;
	position: absolute;
	border: 0;
	top: 1px;
	height: 7px;
	border-radius: 25px;
}
#textarea_one{
	margin-left: 0;
    margin-top: -18px;
}
#textarea_two {
	margin-left: 192px;
	margin-top: -25px;
}
#textarea_one, #textarea_two {
	font-weight: 700;
	font-family: Arial;
	font-size: 11px;
	color: #959595;
}
  </style>
