<h2>Register</h2>
<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('email'); ?>
<?php echo $this->Form->input('password'); ?>
<?php echo $this->Form->input('confirm_password', array('type' => 'password')); ?>
<?php echo $this->Form->end('Register'); ?>
