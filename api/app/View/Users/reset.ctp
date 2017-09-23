<div class="con_main pass_gap">
	<div class="container">
		<div class="edit">
			<h2>Forgot Password</h2>
            <h4>
				<?php
					$x = $this->Session->flash();
					if ($x) {
						echo $x;
					}
                ?>
			</h4>
			<div class="col-sm-9 col-center">
				<div class="edit_box">
					<form method="POST">
						<div class="form-group">
							<input placeholder="Please Enter New Password" type="password" id="pass5" name="data[User][password]" required >
						</div>
						<div class="form-group">
							<input placeholder="Confirm New Password" type="password"  name="data[User][password_confirm]" required>
						</div>
						<div class="form-group">
							<input type="submit" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
     <script type="text/javascript">
          $(document).ready(function() {
                $("#reset").validate({
                    errorElement: 'span',
                    rules: {
                      "data[User][password]": "required",
                        "data[User][password_confirm]": {
                            required: true,
                            minlength: 8,
                            equalTo: "#pass5"
                        }
                    },
                    messages: {
                           "data[User][password_confirm]": {
                            required: "Please Enter confirm password",
                            equalTo: "Confirm Password is not matching your Password"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
            
         </script>