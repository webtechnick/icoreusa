<div class="contractors index">
	<h2><?php echo __('Contractors'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('phone_number'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('is_full'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($contractors as $contractor): ?>
	<tr>
		<td><?php echo h($contractor['Contractor']['id']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['phone_number']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['email']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['description']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['is_full']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['created']); ?>&nbsp;</td>
		<td><?php echo h($contractor['Contractor']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contractor['Contractor']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contractor['Contractor']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contractor['Contractor']['id']), null, __('Are you sure you want to delete # %s?', $contractor['Contractor']['id'])); ?>
		</td>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Contractor'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
