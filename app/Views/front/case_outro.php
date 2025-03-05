<?php echo $header; ?>

<!-- CONTENT -->

<style>
    .assignment-entry {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .assignment-entry label {
        width: 150px; /* Adjust the label width */
    }

    select {
        padding: 5px;
        width: 200px;
    }
</style>

<section class="main">
    <?=$sidebar?>

    <div class="content">
        
        <?=$case['outro']?>

		<div class="actions">
			<a class="button-primary small" href="<?=$case_reset_url?>">
				Opnieuw proberen
			</a>
			<a class="button-primary small" href="<?=$case_complete_url?>">
				Afronden
			</a>
		</div>
    </div>
</section>

<script>
	$(document).ready(function() {
        $(document).ready(function () {
            $('#assignment_form').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                console.log(formData);
                $.ajax({
                    url: '<?=current_url().'/save'?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the response from the server
                        $('#responseMessage').html('<p>' + response.message + '</p>');
                    },
                    error: function(xhr, status, error) {
                        // Handle any error
                        $('#responseMessage').html('<p>An error occurred while submitting the form.</p>');
                    }
                });
            });
        });
    });
</script>

<?php echo $footer; ?>