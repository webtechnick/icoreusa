<?php
$modulus = isset($modulus) ? $modulus : 6;
$show = isset($show) ? $show : true;
$options = isset($options) ? $options : array('escape' => false);
if(isset($filter)){
	$options = array_merge(array('url' => array($filter)), $options);
}
$this->Paginator->options($options);
?>
<?php if ($show && ($this->Paginator->hasPrev() || $this->Paginator->hasNext())): ?>
	<br />
	<p><?php	echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'))); ?></p>
	<div class="paging">
		<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
	<br />
<?php endif; ?>
<div class="clear"></div>