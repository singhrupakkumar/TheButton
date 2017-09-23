<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Change Your Password</h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<label class="user_name">Username : <?php echo $this->Form->value('User.username'); ?></label>
                    	<?php echo $this->Form->create('User');?>
				        <?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
				        <?php echo $this->Form->input('password', array('class' => 'form-control', 'value' => '')); ?>
				        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary'));?>
				        <?php echo $this->Form->end();?>
                    </div><!-- End Here -->
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>