<div class="contractors view">
<h2><?php echo h($contractor['Contractor']['first_name']); ?> <?php echo h($contractor['Contractor']['last_name']); ?></h2>
	<div class="contractor">
		<div class="image">
			<?php if(!empty($contractor['Image']['id'])): ?>
				<?php echo $this->Html->link($this->FileUpload->image($contractor['Image']['name'], 250), "/files/{$contractor['Image']['name']}", array('escape' => false, 'target' => '_blank')); ?><br />
			<?php endif; ?>
		</div>
		<div class="info">
			<br />
			<?php echo h($contractor['Contractor']['first_name']); ?> <?php echo h($contractor['Contractor']['last_name']); ?><br />
			<?php echo h($contractor['Contractor']['phone_number']); ?><br />
			<?php echo h($contractor['Contractor']['email']); ?><br /><br /><br />
			<h3>Bio</h3>
			<?php echo h($contractor['Contractor']['description']); ?>
		</div>
	</div>
</div>
