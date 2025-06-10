<?php echo $header; ?>

<div class="breadcrumbs">
    <ul>
		<li><a href="<?=base_url(route_to('admin.trainings'))?>">Trainingen</a></li>
	    <li><span><?=$training['name']?></span></li>
    </ul>
</div>

<style>
	.container {
		display:flex;
		flex-direction: row;
		gap:20px;
	}

		.container .block {
			background-color: #fff;
			border-radius: var(--secondary-border-radius);
			padding: 10px 15px;
			width: 100%;
			max-width:450px;
			height: max-content;
		}

		.container > section:nth-child(2) {
			flex:2
		}

	.users-table {
		margin-top:2em;
	}

	.users-table .user-meta {
		display:flex;
		flex-direction: row;
	}
		.users-table .user-meta .profile {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background-color: var(--header-user-dropdown-button-background);
			color: white;
			display: flex;
			justify-content: center;
			align-items: center;
			font-size: 1em;
			font-weight: bold;
			margin-right: 15px;
		}
		.users-table .user-meta a {
			display:flex;
			align-items: center;
		}

	.meeting-schedule {
		display: flex;
		flex-direction: column;
		gap:10px;
		max-width:450px;
		margin: 1em 0;
	}
		.meeting-schedule .empty {
			min-height: 300px;
			display: flex;
			text-align: center;
			align-items: center;
			justify-content: center;
		}
		.meeting-schedule > div {
			display: flex;
			flex-direction: row;
			gap:15px;
		}
			.meeting-schedule > div input {
				flex: 1;
			}
			.meeting-schedule > div label {
				flex: 2;
				display:flex;
				flex-direction: row;
				gap:20px;
			}
				.meeting-schedule > div label span {
					display: flex;
					align-items: center;
				}
				.meeting-schedule > div label span:nth-child(1) {
					justify-content: center;
					min-width: 40px;
					height: 40px;
					border-radius: 100%;
					border: 1px solid #fff;
					border-color: var(--button-background-color);
					background: var(--button-background-color);
					color: var(--button-text-color);

				}
	#search_member {
		max-width:300px;
	}

	@media (max-width: 1199px) {
		.container {
			display:block;
		}
	}
</style>

<section class="main">
    <div class="content">
        <form id="edit_training" method="POST">
			<div class="container">
				<section class="block">
					<div class="meeting-schedule">
						<h3>Agenda</h3>
						<?php if ( !$training_started && empty($meetings) ) {?>
							<div class="empty">
								Beschikbaar wanneer de training wordt gestart.
							</div>
						<?php } ?>
						<?php foreach($meetings as $item): ?>
							<div>
								<label for="meeting-<?= $item['id'] ?>">
									<span><?= $item['name'] ?></span>
									<span><?= $item['info'] ?></span>
								</label>
								<input type="hidden" name="meeting_ids[]" value="<?= $item['id'] ?>" />
								<input type="text" name="meeting_dates[<?= $item['id'] ?>]" id="meeting-<?= $item['id'] ?>" class="datetime-picker" placeholder="Select a date", value="<?= isset($meeting_schedule[$item['id']]) ? $meeting_schedule[$item['id']] : '' ?>"  />
							</div>
						<?php endforeach; ?>
					</div>
				</section>

				<section>
					<h2>Training</h2>

					<label>Name<label>
					<input type="text" name="name" value="<?=$training["name"]?>">
				</section>
			</div>

			<?= csrf_field() ?>

			<div class="actions">
				<button type="submit" class="button-primary">
					<i class="fa-regular fa-floppy-disk"></i>Opslaan
				</button>
			</div>
        </form>
   </div>
</section>

<section class="main">
	<div class="content">
		<h3>Deelnemers</h3>

		<label for="user">Deelnemer toevoegen:</label>
		<input type="text" id="search_member" placeholder="Search users...">

		<table class="users-table">
			<thead>
				<tr>
                    <th width="150">Gebruikersnaam</th>
                    <th>Naam</th>
                    <th width="150">Email</th>
                    <th width="150">Rol</th>
					<th width="150">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($members as $item): ?>
					<tr>
                        <td class="user-meta">
							<div class="profile">
								<?=$item['shortname']?>
							</div>
							<a href="<?=base_url(route_to('admin.user', $item['user_id']))?>">
								<?=$item['username']?>
							</a>
						</td>
                        <td><?=$item['fullname']?></td>
                        <td><?=$item['email']?></td>
                        <td><?=$item['group']?></td>
						<td>
							<button id="delete_member" data-member-id="<?=$item['id']?>">
								<i class="fa-solid fa-trash-can"></i>
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
   </div>
</section>

<section class="main">
	<div class="content">

		<div class="alert-actions">
			<p>Speciale handelingen:</p>

			<label>
				Info:<br>
				<?php if (!$training_started): ?>
					<ul>
						<li><em>Starten: De laatste versie van het online lesprogramma wordt voor deze training vastgelegd.</em></li>
					</ul>
				<?php elseif (!$training_stopped): ?>
					<ul>
						<li><em>Stoppen: De deelnemers kunnen geen opdrachten meer wijzigen. Alles wordt vast gezet.</em></li>
						<li><em>Reset: Alle deelnemersgegevens worden gewist! De training kan daarna worden herstart</em></li>
					</ul>
				<?php else:?>
					<em>De training is afgerond.</em>
				<?php endif ?>
			</label>

			<?php if (!$training_started): ?>
				<a class="button-primary" id="start_training">
					<i class="fa-solid fa-circle-play"></i> Starten
				</a>

			<?php elseif (!$training_stopped): ?>
				<a class="button-alert" id="stop_training">
					<i class="fa-solid fa-circle-stop"></i> Stoppen
				</a>

				<a class="button-alert" id="force_reset_training">
					<i class="fa-solid fa-plug-circle-exclamation"></i> Geforceerd RESET
				</a>
			<?php endif ?>
		</div>
   </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
<script {csp-script-nonce}>
    $(document).ready(function () {

		<?=updateCSRFMeta() // csrf helper ?>

		$('.datetime-picker').datetimepicker({
			format: 'Y-m-d H:i', // Format (YYYY-MM-DD HH:mm)
			step: 15,            // Step in minutes (15-minute intervals)
			minDate: 0,          // Prevent selecting past dates
			closeOnDateSelect: true, // Close the picker after date selection
		});

        function add_member(user_id)
        {
	        $.ajax({
		        url: '<?=current_url()?>/add_member',
		        method: 'POST',
		        data: {
			        user_id: user_id,
					<?=setCSRFPostData()?>
		        },
		        success: function (response) {
					updateCSRFMeta(response);

			        if (response.status === 'success') {
				        $('#search_member').val('');
                        location.reload();
			        }
		        }
	        });
        }

        $(document).on('click', '#delete_member', function ()
        {
			event.preventDefault();

            const member_id = $(this).data('member-id');
			const confirmation = confirm('Are you sure you want to delete this member?');

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_member',
		            method: 'POST',
		            data: {
			            member_id: member_id,
						<?=setCSRFPostData()?>
		            },
		            success: function (response) {
						updateCSRFMeta(response);

			            if (response.status === 'success') {
                            location.reload();
			            }
		            }
	            });
            }
        });

        $('#search_member').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= base_url(route_to('admin.find_user_autocomplete')); ?>',
                    method: 'GET',
                    data: {
                        query: request.term // Send the typed query term
                    },
                    success: function(data) {
                        // Map the data to display in the autocomplete dropdown
                        response($.map(data, function(item) {

                            return {
                                label: item.firstname + ' ' + item.middlename + ' ' + item.lastname,
                                value: item.id // Store user ID (to be used when the form is submitted)
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                // Optionally handle the selection of a user from the autocomplete list
                console.log(ui);
                console.log('User selected: ' + ui.item.label);
                add_member(ui.item.value);
            }
        });

        $('#edit_training').submit(function (event) {
            event.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '<?=base_url(route_to('admin.training.save', $training['id']))?>',
                type: 'POST',
                data: formData,
                success: function(response) {
					updateCSRFMeta(response);

                    // Handle the response from the server
                    $('#responseMessage').html('<p>' + response.message + '</p>');
                },
                error: function(xhr, status, error) {
                    // Handle any error
                    $('#responseMessage').html('<p>An error occurred while submitting the form.</p>');
                }
            });
        });

		function training_post_action(post_url)
		{
	        $.ajax({
		        url: post_url,
		        method: 'POST',
		        data: {
					<?=setCSRFPostData()?>
		        },
		        success: function (response) {
					updateCSRFMeta(response);

			        if (response.status === 'success') {
                        location.reload();
			        }
		        }
	        });
		}

		$(document).on('click', '#start_training', function ()
		{
			const confirmation = confirm('Weet je zeker dat je de training wilt starten');

			if (!confirmation)
				return;

			$.ajax({
				url: '<?=base_url(route_to('admin.training.start', $current_training))?>',
				method: 'POST',
				data: {
					<?=setCSRFPostData()?>
				},
				success: function (response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
						location.reload();
					}
				}
			});
		});

		$(document).on('click', '#stop_training', function ()
					   {
			const confirmation = confirm('Weet je zeker dat je de training wilt stoppen');

			if (!confirmation)
				return;

			$.ajax({
				url: '<?=base_url(route_to('admin.training.stop', $current_training))?>',
				method: 'POST',
				data: {
					<?=setCSRFPostData()?>
				},
				success: function (response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
						location.reload();
					}
				}
			});
		});

		$(document).on('click', '#force_reset_training', function ()
					   {
			const confirmation = confirm('Weet je het zeker? Alle deelnemersgegevens worden gewist');

			if (!confirmation)
				return;

			$.ajax({
				url: '<?=base_url(route_to('admin.training.force_reset', $current_training))?>',
				method: 'POST',
				data: {
					<?=setCSRFPostData()?>
				},
				success: function (response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
						location.reload();
					}
				}
			});
		});
    });
</script>

<?php echo $footer; ?>
