<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Profile</h1>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="page_content">
                    <div class="restaurants index">
                        <?php echo $this->Form->create('User',array('type'=>'file')); ?>
                        <?php echo $this->Form->input('id'); ?>
                        <?php echo $this->Form->input('name', array('class' => 'form-control','required' => true)); ?>
                        <?php //echo $this->Form->input('username', array('class' => 'form-control','required' => true)); ?>
        
                        <?php
                            echo $this->Html->Image('/files/profile_pic/' . $this->request->data['User']['image'], array('width' => 100, 'height' => 100, 'alt' => 'User Image', 'class' => 'image'));
                            echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control'));
                        ?>
                        <div class="input select">
                        <?php echo $this->Form->select('gender',array('male'=>'Male','female'=>'Female'), array('class' => 'form-control','required' => true,'empty'=>false)); ?>
                        </div>
                        <?php
                            echo $this->Form->input('address', array('class' => 'form-control','required' => true));
                            echo $this->Form->input('city', array('class' => 'form-control','required' => true));
                            echo $this->Form->input('state', array('class' => 'form-control','required' => true));
                            echo $this->Form->input('country', array('class' => 'form-control','required' => true));
                            echo $this->Form->input('phone', array('class' => 'form-control','required' => true,'type'=>'number'));
                            echo $this->Form->select('accept_payment',array('paypal'=>'Paypal','payfort'=>'Payfort'),array('class' => 'form-control','label'=>'Accept Payment Through','empty'=>'Select Payment method to accept payment '));
                            echo $this->Form->input('paypal_email', array('class' => 'form-control','type'=>'email','style'=>'display:none','label'=>'','placeholder'=>'Paypal Email'));
                            echo $this->Form->input('payfort_email', array('class' => 'form-control','type'=>'email','style'=>'display:none','label'=>'','placeholder'=>'Payfort Email'));
                            ?>
                        
                        
           
                        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $("#UserAcceptPayment").on('change', function() {
            console.log( this.value );
            if(this.value=='paypal'){
                $("#UserPayfortEmail").hide();
                $("#UserPaypalEmail").show();
            }else{
                $("#UserPayfortEmail").show();
                $("#UserPaypalEmail").hide();
            }
          })
    })
</script>