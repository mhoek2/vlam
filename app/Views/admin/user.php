<?php echo $header; ?>

<div class="breadcrumbs">
   	<ul>
		<li><span>Gebruikers</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">

		<?php
		$action = '';
		$action_button = '';

		if (!empty($selected_user)){
			$action_button = 'Opslaan';
			$action = base_url(route_to('admin.user.update', $selected_user['id']));
		}
		else {
			$action_button = 'Nieuwe gebruiker aanmaken';
			$action = base_url(route_to('admin.user.new'));
		}
		?>
		
		<form action="<?=$action?>" method="post">
			<?= csrf_field() ?>
			
			<?php if( empty($selected_user) ): ?>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" class="form-control" value="<?= old('username') ?>">
					<div class="text-danger">
						<?= \Config\Services::validation()->getError('username') ?>
					</div>
				</div>
			
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>">
					<div class="text-danger">
						<?= \Config\Services::validation()->getError('email') ?>
					</div>
				</div>
			

				<!-- Password -->
				<div class="form-group">
					<label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
					<input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
				</div>

				<!-- Password (Again) -->
				<div class="form-group">
					<label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
					<input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
				</div>
			<?php endif ?>
			
			<?php 
			$additional_fields = [
				['field' => 'firstname', 	'name' => "First name"],
				['field' => 'middlename', 	'name' => "Middle name"],
				['field' => 'lastname', 	'name' => "Last name"],
			];
	
			foreach( $additional_fields as $item ):
			?>
				<div class="form-group">
					<label for="name"><?=$item['name']?></label>
					<input type="text" id="<?=$item['field']?>" name="<?=$item['field']?>" class="form-control" value="<?= !empty($selected_user) ? $selected_user[$item['field']] : old($item['field']) ?>">
					<div class="text-danger">
						<?= \Config\Services::validation()->getError($item['field']) ?>
					</div>
				</div>
			<?php endforeach ?>
			
			<?php if (session('error') !== null) : ?>
				<div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
			<?php elseif (session('errors') !== null) : ?>
				<div class="alert alert-danger" role="alert">
					<?php if (is_array(session('errors'))) : ?>
						<?php foreach (session('errors') as $error) : ?>
							<?= esc($error) ?>
							<br>
						<?php endforeach ?>
					<?php else : ?>
						<?= esc(session('errors')) ?>
					<?php endif ?>
				</div>
			<?php endif ?>
			
			<div class="actions">
				<button type="submit" class="button-primary"><?=$action_button?></button>
			</div>
		</form>
		
		<?php if( !empty($selected_user) ): ?>
		<div class="alert-actions">
			<p>Speciale handelingen:</p>
			
			<a id="change_password" class="button-alert">
				<i class="fa-solid fa-ban"></i> Wachtwoord wijzigen
			</a>
			
			<?php if ($selected_user['id'] !== $user['id']): ?>
				<a id="delete_user" class="button-alert">
					<i class="fa-solid fa-ban"></i> Gebruiker verwijderen
				</a>
			<?php endif ?>
		</div>
		<?php endif ?>
    </div>
</section>

<script {csp-script-nonce}>
    $(document).ready(function () {
		<?php if( !empty($selected_user) ): ?>
		
			change_password
			$(document).on('click', '#change_password', function()
			{
				const confirmation = confirm('This is not implemented yet!');
				
			});
		
			$(document).on('click', '#delete_user', function()
			{
				const confirmation = confirm('Are you sure you want to remove this user?');

				if ( confirmation ) {
					window.location = '<?=base_url(route_to('admin.user.delete', $selected_user['id']))?>';

					//
					// Use a form to perform this action
					// allows to make use of csrf tokenization and redirect back functionalities
					// 

					var form = document.createElement('form');
					form.method = 'POST';
					form.action = '<?= base_url(route_to('admin.user.delete', $selected_user['id'])) ?>';

					var csrfFieldToken = document.createElement('input');
					csrfFieldToken.type = 'hidden';
					csrfFieldToken.name = '<?= csrf_token() ?>'; ;
					csrfFieldToken.value = '<?= csrf_hash() ?>';;

					form.appendChild(csrfFieldToken);
					document.body.appendChild(form);
					form.submit();	
				}
			});
		<?php endif ?>
    });
</script>

<?php echo $footer; ?>