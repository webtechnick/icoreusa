<h2>Contractor</h2>
<?php echo $this->Form->create('Contractor', array('type' => 'file')); ?>
<?php echo $this->Form->input('Contractor.id'); ?>
<?php echo $this->Form->input('Contractor.user_id', array('type' => 'hidden', 'value' => $user['id'])); ?>
<?php echo $this->Form->input('Contractor.first_name'); ?>
<?php echo $this->Form->input('Contractor.last_name'); ?>
<?php echo $this->Form->input('Contractor.email', array('default' => $user['email'])); ?>
<?php echo $this->Form->input('Contractor.phone_number'); ?>
<?php echo $this->Form->input('Contractor.description'); ?>
<?php if(!empty($this->request->data['Image']['id'])): ?>
	<?php echo $this->FileUpload->image($this->request->data['Image']['name'], 100); ?>
<?php endif; ?>
<?php echo $this->Form->input('Image.file', array('type' => 'file')); ?>
<?php echo $this->Form->end('Update'); ?>

