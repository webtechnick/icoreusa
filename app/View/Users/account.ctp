<h2>Account</h2>
<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('email', array('label' => 'Login Email')); ?>
<?php echo $this->Form->end('Update'); ?>

