<section class="admin_main-sec">
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('View Staticpage'); ?></h1>
                </div>
			</div>
<div class="col-sm-9"> 
<table class="table-striped table-bordered table-condensed table-hover">
    <tr>
        <td>Position</td>
        <td> <?php echo h($staticpage['Staticpage']['position']); ?></td>
    </tr>

    <tr>
        <td>Title</td>
        <td> <?php echo h($staticpage['Staticpage']['title']); ?></td>
    </tr>

    <tr>
        <td>Image</td>
        <td>  <?php echo $this->Html->image('../files/staticpage/'.$staticpage['Staticpage']['image'],
                           array('alt'=>'Staticpage Image','style'=>'height:150px;')); ?></td>  
    </tr>
    <tr>
        <td>Description</td>
        <td>
             <?php echo htmlspecialchars(strip_tags($staticpage['Staticpage']['description'])); ?> 
            </td>
    </tr>
    <tr>
        <td>Created</td>
        <td><?php echo h($staticpage['Staticpage']['created']); ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td><?php  if($staticpage['Staticpage']['status']==1) { echo 'Active';}else{echo "Deactive";} ?></td>
    </tr>

</table>

</div> 
</div>
	</div>
</section>
  