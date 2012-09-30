<h2>Login</h2>
<?php echo $this->Form->create('User', array('action' => 'login')); ?>
<?php echo $this->Form->input('email'); ?>
<?php echo $this->Form->input('password'); ?>
<?php echo $this->Form->end('Login'); ?>
