<div class="contractors index">
	<h2><?php echo __('Contractors'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('phone_number'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
	</tr>
	<?php
	foreach ($contractors as $contractor): ?>
	<tr>
		<td><?php echo h($contractor['Contractor']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['phone_number']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['email']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['description']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
