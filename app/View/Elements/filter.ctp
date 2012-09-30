<div id="admin_filter">
<?php
$model = isset($model) ? $model : false;
$url = isset($url) ? $url : null;

if($model){
	echo $this->Form->create($model, array('url' => $url, 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->input('filter', array('label' => false, 'value' => "", 'class' => 'clear_default'));
	echo $this->Form->submit('Search', array('div' => false, 'class' => 'button green'));
	echo $this->Form->end();
}
?>
</div>