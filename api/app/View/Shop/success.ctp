<section class="st-content">
	<section class="order_succ">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="thnk_head">Thank You !</h1>
					<p class="title_thnk">For placing order with thoag</p>
					<div class="card-img">
						<img src="<?php echo $this->webroot; ?>img/card.png" alt="">
					</div>
					<p class="order-id">Order Id : <?php if(isset($_GET['order_id'])) { echo $_GET['order_id']; }?></p>
					<p class="text_thnk">We’ve sent you an email with all the details of your order & remember <br />you can track your order using this website!</p>
					<div class="btn-sec-back">
						<a href="<?php echo $this->webroot;?>" class="btn btn-primary btn-back">Back To Home</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>