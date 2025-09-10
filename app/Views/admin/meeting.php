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
				
                $.ajax({
                    url: '<?= base_url(route_to('admin.meeting.save', $current_meeting)) ?>',
                    type: 'POST', // Send POST request
                    data: formData,
                    success: function(response) {
						updateCSRFMeta(response);

                        // Handle the response from the server
                        $('#responseMessage').html('<p>' + response.message + '</p>');
						
						button_handler( event.originalEvent.submitter, BUTTON_SUCCESS );
                    },
                    error: function(xhr, status, error) {
                        // Handle any error
                        $('#responseMessage').html('<p>An error occurred while submitting the form.</p>');
						
						button_handler( event.originalEvent.submitter, BUTTON_ERROR );
                    }
                });
            });
        });
    });
</script>

<?php echo $footer; ?>