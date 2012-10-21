<h2>Contractor</h2>
<?php echo $this->Form->create('Contractor', array('type' => 'file')); ?>
<?php echo $this->Form->input('Contractor.id'); ?>
<?php echo $this->Form->input('Contractor.user_id', array('type' => 'hidden', 'value' => $user['id'])); ?>
<?php echo $this->Form->input('Contractor.first_name'); ?>
<?php echo $this->Form->input('Contractor.last_name'); ?>
<?php echo $this->Form->input('Contractor.company_name'); ?>
<?php echo $this->Form->input('Contractor.street'); ?>
<?php echo $this->Form->input('Contractor.street_2'); ?>
<?php echo $this->Form->input('Contractor.city'); ?>
<?php echo $this->Form->input('Contractor.state'); ?>
<?php echo $this->Form->input('Contractor.zip'); ?>
<?php echo $this->Form->input('Contractor.email', array('default' => $user['email'])); ?>
<?php echo $this->Form->input('Contractor.phone_number'); ?>
<?php echo $this->Form->input('Contractor.description'); ?>
<?php if(!empty($this->request->data['Image']['id'])): ?>
	<?php echo $this->FileUpload->image($this->request->data['Image']['name'], 200); ?>
<?php endif; ?>
<?php echo $this->Form->input('Image.id'); ?>
<?php echo $this->Form->input('Image.file', array('type' => 'file', 'label' => 'Profile Image')); ?>
<?php	$i = 0;	for(; $i<count($this->request->data['Upload']); $i++){
	echo $this->FileUpload->image($this->request->data['Upload'][$i]['name'], 200);
	echo $this->Html->link('Delete', array('controller' => 'uploads', 'action' => 'delete', $this->request->data['Upload'][$i]['id']), array(), 'Are you sure?');
}?>
<?php echo $this->Form->input("Upload.$i.file", array('type' => 'file', 'label' => 'Upload A New Photo')); ?>
<?php echo $this->Form->end('Update'); ?>
