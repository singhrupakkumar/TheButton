<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>View User</h1>
                </div>
            </div>
                <div class="page_content">
                <div class="col-sm-5">
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <td><?php echo h($user['User']['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?php echo h($user['User']['role']); ?></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo h($user['User']['name']); ?></td>
                                </tr>

                                <tr>
                                    <th>Image</th>
                                    <td><?php
            echo  $this->Html->image("../files/profile_pic/".$user['User']['image'],array('style'=>"width:100px;height:100px;"));
            // echo $this->webroot."files/profile_pic".h($user['User']['image']); ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo h($user['User']['username']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo h($user['User']['email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td><?php echo h($user['User']['gender']); ?></td>
                                </tr>
                                <tr>
                                    <th>Dob</th>
                                    <td><?php echo h($user['User']['dob']); ?></td>
                                </tr>
                                <tr>
                                    <th>Referral Code</th>
                                    <td><?php echo h($user['User']['referral_code']); ?></td>
                                </tr>
                                <tr>
                                    <th>Used Referral Code</th>
                                    <td><?php echo h($user['User']['used_referral_code']); ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo h($user['User']['address']); ?></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo h($user['User']['state']); ?></td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td><?php echo h($user['User']['country']); ?></td>
                                </tr>
                                <tr>
                                    <th>Zip</th>
                                    <td><?php echo h($user['User']['zip']); ?></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td><?php echo h($user['User']['phone']); ?></td>
                                </tr>
                                <?php if($user['User']['fb_id'] != null && !empty($user['User']['fb_id'])){ ?>
                                <tr>
                                    <th>Facebook ID</th>
                                    <td><?php echo h($user['User']['fb_id']); ?></td>
                                </tr>
                                <? } ?>
    <?php if($user['User']['twitter_id'] != null && !empty($user['User']['twitter_id'])){ ?>
    <tr>
                                    <th>Twitter ID</th>
                                    <td><?php echo h($user['User']['twitter_id']); ?></td>
                                </tr>
                                <? } ?>
    
    <?php if($user['User']['google_id'] != null && !empty($user['User']['google_id'])){ ?>
                                <tr>
                                    <th>Google ID</th>
                                    <td><?php echo h($user['User']['google_id']); ?></td>
                                </tr>
                            <? } ?>
                                <tr>
                                    <th>Platform</th>
                                    <td><?php if(empty($user['User']['platform'])){
                echo "Desktop";
            }else{
                echo h($user['User']['platform']);
            }
            ?></td>
                                </tr>
                                <tr>
                                    <th>Active</th>
                                    <td><?php echo h($user['User']['active']); ?></td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td><?php echo h($user['User']['created']);?></td>
                                </tr>
                                <tr>
                                    <th>Modified</th>
                                    <td><?php echo h($user['User']['modified']); ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- End Here -->



                                        <div class="restaurants index">
                                        <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Multiple Addresses</h1>
                </div>
                <?php foreach($addresses as $address){ ?>
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <td><?php echo $address['Address']['title']; ?></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $address['Address']['name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td><?php echo $address['Address']['phone']; ?></td>
                                </tr>

                                <tr>
                                    <th>Recipent Mobile</th>
                                    <td><?php echo $address['Address']['recipent_mobile']; ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo $address['Address']['address']; ?></td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td><?php echo $address['Address']['created']; ?></td>
                                </tr>
                                <tr>
                                    <th>Modified</th>
                                    <td><?php echo $address['Address']['modified']; ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- End Here -->
 <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>