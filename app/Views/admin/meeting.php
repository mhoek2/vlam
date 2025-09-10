<?php echo $header; ?>

<div class="breadcrumbs">
    <ul>
	    <li><a href="<?=base_url(route_to('admin.meetings'))?>">Meetings</a></li>
	    <li><span><?=$meeting['info']?></span></li>
    </ul>
</div>

<section class="main">
    <div class="content">
        <form id="edit_meeting" method="POST">
			<h2>Bijeenkomst</h2>

            <label>Info<label>
            <input type="text" name="info" value="<?=$meeting["info"]?>">

            <label>Intro<label>
            <textarea name="intro" id="intro"><?=$meeting["intro"]?></textarea>

			<div id="form_response_container" class="request-response"></div>		
				
            <?= csrf_field() ?>

			<div class="actions">
				<button type="submit" class="button-primary button-action">
					<div class="icon"></div>
					<div class="text">Opslaan</div>
				</button>
			</div>
        </form>
    </div>
</section>

<section class="main">
    <div class="content">
    <h2>Assignments</h2>
    <?=$assignments_view?>
    </div>
</section>

<?=$text_editor->load_script()?>
<script {csp-script-nonce}>
    $(document).ready(function () {
	    <?=$text_editor->init_script()?>
	    <?=$text_editor->assign_editor('"#intro"')?>

		<?=updateCSRFMeta() // csrf helper ?>

        $(document).ready(function () {
            $('#edit_meeting').submit(function (event) {
                event.preventDefault();

                const formData = $(this).serialize();
				
				button_handler( event.originalEvent.submitter, BUTTON_LOADING );
				$('#form_response_container').empty();

                $.ajax({
                    url: '<?= base_url(route_to('admin.meeting.save', $current_meeting)) ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							$('#form_response_container').append('<p class="success">' + response.message + '</p>');

							button_handler( event.originalEvent.submitter, BUTTON_SUCCESS );

							if ( response.redirect != null ) {
								window.location.href = response.redirect;
							}
							return;
						}

						if (response.status === 'error' && response.errors) {
							$.each(response.errors, function(field, errorMessage) {
								$('#form_response_container').append('<p class="error">' + errorMessage + '</p>');
							});

							button_handler( event.originalEvent.submitter, BUTTON_ERROR );
						}
                    },
                    error: function(xhr, status, error) {
                        // Handle any error
						$('#form_response_container').append('<p class="error">An error occurred while submitting the form.</p>');

						button_handler( event.originalEvent.submitter, BUTTON_ERROR );
                    }
                });
            });
        });
    });
</script>

<?php echo $footer; ?>