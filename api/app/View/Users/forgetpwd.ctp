<div class="con_main pass_gap">
	<div class="container">
		<div class="edit"><!--page inn start-->
			<h2>Forgot Password</h2>
			<h4>			
				<?php $x=$this->Session->flash(); 
					if($x)
						{
							echo $x;
						}
				?>
			</h4>
			 <div class="col-sm-9 col-center">
				<div class="edit_box">
					<p> Enter your Email Address. We will send you password reset link.</p>
					<form method="POST" action="<?php echo $this->webroot;?>users/forgetpwd">
						<div class="form-group">
							<input placeholder="Please Enter Your Email Adderss" type="text" name="data[User][username]">
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Submit">
						</div>
					</form>
				</div>
			 </div>
		</div>
	</div>
</div>