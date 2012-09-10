<div class="container">

	<?php if ($this->Session->check('Message.success')) : ?>
		<div class="alert alert-success">
			<a class="close" data-dismiss="alert">×</a> 
			<h4 class="alert-heading">Parabéns!</h4>
			<?php echo $this->Session->flash('success') ?>
		</div>
	<?php endif; ?>

	<?php if ($this->Session->check('Message.error')): ?>
		<div class="alert alert-error">
			<a class="close" data-dismiss="alert">×</a> 
			<h4 class="alert-heading">Atenção!</h4>
			<?php echo $this->Session->flash('error') ?>
		</div>
	<?php endif; ?>

</div>