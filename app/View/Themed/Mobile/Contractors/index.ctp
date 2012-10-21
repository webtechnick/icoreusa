<div class="contractors index">
	<h2><?php echo __('Contractors'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>
				<?php echo $this->Paginator->sort('first_name','first'); ?>&nbsp;<?php echo $this->Paginator->sort('last_name','last'); ?>
			</th>
			<th>
				<?php echo $this->Paginator->sort('phone_number','phone'); ?>&nbsp;<?php echo $this->Paginator->sort('email'); ?>
			</th>
	</tr>
	<?php	foreach ($contractors as $contractor): ?>
	<?php $id = $contractor['Contractor']['id']; ?>
	<tr class="click" onclick="location.href='/contractors/view/<?php echo $id; ?>'">
		<td>
			<?php if(!empty($contractor['Image']['id'])): ?>
				<?php echo $this->FileUpload->image($contractor['Image']['name'], 100); ?><br />
			<?php endif; ?>
			<?php echo h($contractor['Contractor']['first_name']); ?>&nbsp;
			<?php echo h($contractor['Contractor']['last_name']); ?>
		</td>
		<td>
			<?php echo h($contractor['Contractor']['phone_number']); ?><br />
			<?php echo h($contractor['Contractor']['email']); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->element('pagination'); ?>
</div>