<div class="con_main pass_gap">
    <div class="container">
        <div class="edit">
            <h2><?php if ($arabic != 'ar') { ?>Change Password<?php }else{ echo "تغيير كلمة السر"; } ?></h2>
            <h4><?php
                $x = $this->Session->flash();
                if ($x) {
                    echo $x; 
                }
                ?></h4>    
            <div class="col-sm-9 col-center"> 
                <div class="edit_box">
                    <?php echo $this->Form->create('User', array('id' => 'changepassword')); ?>
					<div class="form-group">
						<input type="password" name="data[User][old_password]" value="" placeholder="Please Enter Old Password"/>
					</div>
					<div class="form-group">
						<input type="password" name="data[User][new_password]" id="pass1" value="" placeholder="Please Enter New Password"/>
					</div>
					<div class="form-group">
						<input type="password" name="data[User][cpassword]" value="" placeholder="Confirm New Password"/>
					</div>
					<div class="form-group">
						<input name="submit" type="submit" value="<?php if ($arabic != 'ar') { ?>Submit<?php }else{ echo "عرض"; } ?>"/> 
					</div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
                $("#changepassword").validate({
                    errorElement: 'span',
                    rules: {
                        "data[User][old_password]": "required",
                         "data[User][new_password]": "required",
                        "data[User][cpassword]": {
                            required: true,
                            minlength: 8,
                            equalTo: "#pass1"
                        }

                    },
                    messages: {
                        "data[User][old_password]": "Please Enter Old password",
                        "data[User][new_password]": "Please Enter New password",
                        "data[User][cpassword]": {
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