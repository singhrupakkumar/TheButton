<h2>Admin Edit User</h2>

<br />

<div class="row">
    <div class="col-sm-4">
    <div class="add_dish">

        <?php echo $this->Form->create('User');?>
        <?php echo $this->Form->input('id'); ?>
        <?php echo $this->Form->input('role', array('class' => 'form-control', 'options' => array('admin' => 'admin', 'customer' => 'customer','rest_admin'=>'Restaurant Admin'),'default'=> $this->request->data['User']['role'] )); ?>
        <br />
        <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
        <br />
        <?php echo $this->Form->input('username', array('class' => 'form-control')); ?>
        <br />
		<h4>Permission</h4>		
		<?php foreach($controllerLists as $controllerList){
                    if(isset($authorized_pages)){
                       if(in_array($controllerList['name'],$authorized_pages)){ ?>
                        <div class="prcheck" style='float:left;width: 100%;'><input checked type="checkbox" name="data[Userpermission][view_pages][]" value="<?php echo $controllerList['name']; ?>"><label><?php echo $controllerList['displayName']; ?></label></div>
                    <?php }else{
                    ?>
		<div class="prcheck" style='float:left;width: 100%;'><input type="checkbox" name="data[Userpermission][view_pages][]" value="<?php echo $controllerList['name']; ?>"><label><?php echo $controllerList['displayName']; ?></label></div>
                <?php } 
                    }else{ ?>
                     <div class="prcheck" style='float:left;width: 100%;'><input type="checkbox" name="data[Userpermission][view_pages][]" value="<?php echo $controllerList['name']; ?>"><label><?php echo $controllerList['displayName']; ?></label></div>   
                <?php    }
                    } ?>

		<br/>
		<div class="check_box">
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
        </div>
                <img src="../../../../../../Users/Ashutosh/AppData/Local/Temp/dot.gif" alt=""/>
        <br />
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
		
        <?php echo $this->Form->end(); ?>
</div>
    </div> 
</div>
<style>
.prcheck > label {
    float: left;
    margin-left: 5px;
    width: auto;
}
.prcheck > input {
    float: left;
}
</style>