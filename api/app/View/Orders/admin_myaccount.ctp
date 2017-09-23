<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>User</h1>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="page_content">
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <tbody>
                                    <tr>
                                        <th>Id</th>
                                        <td><?php echo h($user['User']['id']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td><?php echo h($user['User']['role']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td><?php echo h($user['User']['username']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo h($user['User']['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>E-mail</th>
                                        <td><?php echo h($user['User']['email']); ?></td>
                                    </tr>
                                    <?php if($user['User']['accept_payment']){ ?>
                                    <tr>
                                        <th>Accept Payment Through</th>
                                        <td><?php echo h($user['User']['accept_payment']); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <?php if($user['User']['accept_payment']=='paypal'){ ?>
                                            <th>Paypal Email</th>
                                            <td><?php echo h($user['User']['paypal_email']); ?></td>
                                        <?php } ?>
                                        <?php if($user['User']['accept_payment']=='payfort'){ ?>
                                            <th>Paypal Email</th>
                                            <td><?php echo h($user['User']['payfort_email']); ?></td>
                                        <?php } ?>
                                        
                                    </tr>
                                    <tr>
                                        <th>Active</th>
                                        <td><?php echo h($user['User']['active']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td><?php echo h($user['User']['created']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Modified</th>
                                        <td><?php echo h($user['User']['modified']); ?></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div><!-- End Here -->
                    <div class="bottom_button">
                        <h3>Actions</h3>
                        <?php echo $this->Html->link('Change Password', array('action' => 'password', $user['User']['id']), array('class' => 'btn btn-default')); ?> 
                        <?php echo $this->Html->link('Edit Profile', array('controller'=>'users','action' => 'myaccount'), array('class' => 'btn btn-default')); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>