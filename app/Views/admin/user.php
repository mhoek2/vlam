<?php echo $header; ?>

<?php
$action = '';
$action_button = '';
$breadcrumb_title = '';

if (!empty($selected_user)){
	$action_button = 'Opslaan';
	$action = base_url(route_to('admin.user.update', $selected_user['id']));
	$breadcrumb_title = $selected_user['fullname'];	
}
else {
	$action_button = 'Nieuwe gebruiker aanmaken';
	$action = base_url(route_to('admin.user.new'));
	$breadcrumb_title = 'Nieuwe Gebruiker';
}
?>

<style>
	form {
		max-width:600px
	}
	
	<?php if(! empty($selected_user) ): ?>
		.edit-user-info {
			display: flex;
			align-items: center;
			background-color: #fff;
			border-radius: var(--secondary-border-radius);
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			padding: 10px 15px;
			margin: 10px 0 50px 0;
			margin: 10px auto 50px auto;
			width: 100%;
			max-width: 500px;
			font-family: 'Arial', sans-serif;
		}

			.edit-user-info .profile {
				width: 150px;
				height: 150px;
				border-radius: 50%;
				background-color: var(--header-user-dropdown-button-background);
				color: white;
				display: flex;
				justify-content: center;
				align-items: center;
				font-size: 4em;
				font-weight: bold;
				margin-right: 15px;
			}

		.edit-user-info .meta {
			display: flex;
			flex-direction: column;
		}

			.edit-user-info .meta span {
				color: #333;
				font-size: 14px;
				margin-bottom: 5px;
			}
			.edit-user-info .meta span.name {
				font-weight:600;
			}
			.edit-user-info .meta span.email {
				font-size: 13px;
				color: #555;
			}
	
		/*
		#change_password_form {
			padding: 1em;
			border: 1px solid rgb(245 218 227);
			border-radius: 3px;
			box-shadow: 0 2px 8px var(--button-alert-background-color);
		}*/
	
	<?php endif ?>
</style>

<div class="breadcrumbs">
   	<ul>
		<li><a href="<?=base_url(route_to('admin.users'))?>">Gebruikers</a></li>
		<li><span><?=$breadcrumb_title?></span></li>
    </ul>
</div>

<section class="main">
    <div class="content">

		<form action="<?=$action?>" method="post">
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
			
			<?php else: ?>
				<div class="edit-user-info">
					<div class="profile"><?=$selected_user['shortname']?></div>
					<div class="meta">
						<span class="name"><?=$selected_user['fullname']?></span>
						<span><?=$selected_user['username']?></span>
						<span class="email"><?=$selected_user['email']?></span>
					</div>
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
			
			<div class="request-response">
				<?php if (session('error') !== null) : ?>
						<p class="alert"><?= esc(session('error')) ?></p>
				<?php elseif (session('errors') !== null) : ?>
					<?php if (is_array(session('errors'))) : ?>
						<?php foreach (session('errors') as $error) : ?>
							<p class="alert"><?= esc($error) ?></p>
						<?php endforeach ?>
					<?php else : ?>
						<p class="alert"><?= esc(session('errors')) ?></p>
					<?php endif ?>
				<?php endif ?>
			</div>
			
			<?= csrf_field() ?>

			<div class="actions">
				<button type="submit" class="button-primary"><?=$action_button?></button>
			</div>
		</form>
		
		<?php if( !empty($selected_user) ): ?>
		<div class="alert-actions">
			<p>Speciale handelingen:</p>
			
			<a id="change_password" class="button-alert">
				<i class="fa-solid fa-key"></i> Wachtwoord wijzigen
			</a>
			<div style="display:none;">
				<form method="post" id="change_password_form">
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
					
					<?= csrf_field() ?>
					
					<div id="password_error_container" class="request-response"></div>
					
					<div class="actions">
						<button type="submit" class="button-alert">
							<i class="fa-regular fa-floppy-disk"></i>Wijzigen
						</button>
					</div>
				</form>
			</div>
			
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
		
		<?=updateCSRFMeta() // csrf helper ?>
		
		<?php if( !empty($selected_user) ): ?>
		
			$(document).on('click', '#change_password', function()
			{
				const confirmation = confirm('Weet je zeker dat je het wachtwoord wilt wijzigen?');
				
				if ( confirmation )
				{
					$('#change_password_form').parent().css('display', 'block');
				}
			});
		
            $('#change_password_form').submit(function (event) {
                event.preventDefault();
				
                var formData = $(this).serialize();

                $.ajax({
					url: '<?=base_url(route_to('admin.user.change_password', $selected_user['id']))?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
						updateCSRFMeta(response);
						$('#password_error_container').empty();
						
                       	if (response.status === 'success') {
							$('#password_error_container').append('<p class="success">' + response.message + '</p>');
							$(this).find('.form-group').remove();
							$(this).find('.actions').remove();
							return;
						}

						if (response.status === 'error' && response.errors) {
							$.each(response.errors, function(field, errorMessage) {
								$('#password_error_container').append('<p class="error">' + errorMessage + '</p>');
							});
						}
                    }.bind(this),
                    error: function(xhr, status, error) {
                        $('#change_password_form').parent().html('<p class="error">Er is iets mis gegaan!</p>');
                    }
                });
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
					csrfFieldToken.name = '<?= csrf_token() ?>';
					csrfFieldToken.value = '<?= csrf_hash() ?>';

					form.appendChild(csrfFieldToken);
					document.body.appendChild(form);
					form.submit();	
				}
			});
		<?php endif ?>
    });
</script>

<?php echo $footer; ?>