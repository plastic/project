<?php echo $this->Admin->formCreate('User', 'post'); ?>
	
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
	
<?php echo $this->Form->end(); ?>
