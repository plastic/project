<div class="expand-10">
	<div class='box_info'>
		
		<div class='box_info_content'>
			<?php echo $this->Form->create('User', array('class' => 'loginController form-horizontal')); ?>
			
			<fieldset>
				<legend>Acesso ao sistema</legend>
				<div class="control-group">
					<label class="control-label" for="input01">Login</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-envelope"></i></span><?php echo $this->Form->input('email', array('class' => 'input-xlarge', 'label' => false, 'div' => false)); ?>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="input01">Senha</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-asterisk"></i></span><?php echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'input-xlarge')); ?>
						</div>
					</div>
				</div>
				
			</fieldset>
			
			<div class="form-actions">
				<?php echo $this->Form->submit('Entrar', array('class' => 'btn btn-primary btn-large', 'div' => false)); ?>
			</div>
			
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>