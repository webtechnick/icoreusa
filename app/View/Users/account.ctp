<h2>Account</h2>
<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('email', array('label' => 'Login Email')); ?>

<h2>Contractor</h2>
<?php echo $this->Form->input('Contractor.first_name'); ?>
<?php echo $this->Form->input('Contractor.last_name'); ?>
<?php echo $this->Form->input('Contractor.email', array('default' => $this->request->data['User']['email'])); ?>
<?php echo $this->Form->input('Contractor.phone_number'); ?>
<?php echo $this->Form->input('Contractor.description'); ?>

<?php echo $this->Form->end('Update'); ?>
