<div id="good-flash">
  <?php echo $message; ?>
</div>
<?php $this->Js->get('#flash-message')->event('click', $this->Js->get('#flash-message')->effect('fadeOut')); ?>