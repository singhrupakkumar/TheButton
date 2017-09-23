<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo $this->webroot; ?>files/staticpage/<?php echo $staticabout[0]['Staticpage']['image']; ?>" data-natural-width="1400" data-natural-height="350">
    <div id="subheader">
    	<div id="sub_content">
    	 <h1>About us</h1>        
         <p></p>
        </div><!-- End sub_content -->
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#0">Home</a></li>
                <li><a href="#0">About</a></li>
              
            </ul>
        </div>
    </div><!-- Position -->
<!-- Content ================================================== -->
<div class="container margin_60_35">
	<div class="row">
             <?php foreach ($staticabout as $abt){ ?>
		<div class="col-md-4">
			<h3 class="nomargin_top"><?php echo $abt['Staticpage']['title']; ?></h3>
			<p>
				<?php echo $abt['Staticpage']['description']; ?>
			</p>
			
		
		</div>
		<div class="col-md-7 col-md-offset-1 text-right hidden-sm hidden-xs">
			<img src="<?php echo $this->webroot; ?>files/staticpage/<?php echo $abt['Staticpage']['image']; ?>" alt="" class="img-responsive">
		</div>
             <?php }?>
	</div><!-- End row -->
	<hr class="more_margin">
   

</div><!-- End container -->
