<div class="container">

	<?php if (SessionHelper::check('Message.success')) : ?>
		<div class="alert alert-success">
			<a class="close" data-dismiss="alert">×</a> 
			<h4 class="alert-heading">Parabéns!</h4>
			<?php echo SessionHelper::flash('success') ?>
		</div>
	<?php endif; ?>

	<?php if (SessionHelper::check('Message.error')): ?>
		<div class="alert alert-error">
			<a class="close" data-dismiss="alert">×</a> 
			<h4 class="alert-heading">Atenção!</h4>
			<?php echo SessionHelper::flash('error') ?>
		</div>
	<?php endif; ?>

</div>