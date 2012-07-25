<?php echo $this->Form->create('User', array('method' => 'post', 'class' => 'form-horizontal', 'type' => 'file', 'id' => 'fileupload')); ?>
	
	<fieldset>
		<legend>Adicionar</legend>
		
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
					<p class="help-block">Senha contendo no mínimo 6 caracteres</p>
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


<?php /* OU USE ESTE FORM */ ?>

<?php /* echo $this->Admin->formCreate('User', 'post') ?>
	
	<fieldset>
		<legend>Adicionar</legend>
		<?php echo $this->Form->hidden('id'); ?>
		<?php echo $this->Admin->input('name', array('label' => 'Nome', 'help' => 'Nome do usuário')) ?>
		<?php echo $this->Admin->input('email', array('label' => 'E-mail', 'help' => 'E-mail válido')) ?>
		<?php echo $this->Admin->input('password', array('label' => 'Senha', 'type' => 'password', 'help' => 'Senha contendo no mínimo 8 caracteres')) ?>
		<?php echo $this->Admin->input('cpassword', array('label' => 'Confirme a senha', 'type' => 'password', 'help' => 'Digite novamente a senha')) ?>
	</fieldset>
	
	<div class="form-actions">
		<?php echo $this->Form->submit('Salvar', array('class' => 'btn btn-primary btn-large', 'div' => false)); ?>
		<a class="btn btn-large" href="<?php echo Router::url('/admin/users')?>">Cancelar</a>
	</div>
	
<?php echo $this->Form->end(); */ ?>
