<section class="main-sec">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-center">
                <div class="login_outer">
                    <div class="user_avtar">
                        <img src="<?php echo $this->webroot; ?>img/registration.png">
                    </div>
                    <div class="login_frm">
                        <h3>Login Here</h3>
                            <?php echo $this->Form->create('User', array('action' => 'login')); ?>
                            <?php echo $this->Form->input('username', array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
                            <?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
                            <?php echo $this->Form->button('Login', array('class' => 'btn btn-primary')); ?>
                            <?php echo $this->Form->end(); ?>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>