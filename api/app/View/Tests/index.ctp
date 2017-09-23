<div style="clear:both">
<?php $i=1;
foreach($IndexDetail as $value){
echo '<strong>['.$i.']. '.$value['description'].'</strong><br>';
echo $value['url'].'<br>';
echo '<i><b>Parameters</b><br>'.$value['parameters'].'</i><br><br>';
$i++;
}
?>
</div>