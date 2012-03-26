<div class="expand-10">
	
	<!-- <h2 class="title-grid">Usuário</h2> -->
	<?php
	$this->Html->addCrumb('Usuários', '/admin/users');
	$this->Html->addCrumb('Editar', false, array('class' => 'active'));
	?>
	
	<ul class="breadcrumb">
		<?php echo $this->Html->getCrumbs(' <span class="divider">/</span> '); ?>
	</ul>
	
	<div class="content-grid">
		
		<?php echo $this->Form->create('User', array('method' => 'put', 'class' => 'form-horizontal')); ?>
			
			<fieldset>
				<legend>Alterar</legend>
				<?php echo $this->Form->hidden('id') ?>
				
				<div class="control-group">
					<label class="control-label" for="input01">Nome</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><?php echo $this->Form->input('name', array('class' => 'input-xlarge', 'label' => false, 'div' => false)); ?>
							<p class="help-block">Nome do usuário</p>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="input01">E-mail</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-envelope"></i></span><?php echo $this->Form->input('email', array('class' => 'input-xlarge', 'label' => false, 'div' => false)); ?>
							<p class="help-block">E-mail válido</p>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="input01">Senha</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-asterisk"></i></span><?php echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'input-xlarge')); ?>
							<p class="help-block">Senha contendo no mínimo 6 carasteres</p>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="input01">Confirme a senha</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-asterisk"></i></span><?php echo $this->Form->input('cpassword', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'input-xlarge')); ?>
							<p class="help-block">Digite novamente a senha</p>
						</div>
					</div>
				</div>
				
			</fieldset>
			
			<div class="form-actions">
				<?php echo $this->Form->submit('Salvar', array('class' => 'btn btn-primary btn-large', 'div' => false)); ?>
				<a class="btn btn-large">Cancelar</a>
			</div>
			
		<?php echo $this->Form->end(); ?>
		
	</div>
</div>