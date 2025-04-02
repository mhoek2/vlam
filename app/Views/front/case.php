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
    	<div class="actions">
    		<?php if ( isset($prev_url) && !is_null($assignment) ): ?>
				<a class="button-primary small" href="<?=$prev_url?>">
					<i class="fa-solid fa-chevron-left"></i><?=$assignment['name']?>: <?=$assignment['info']?>
				</a>
			<?php endif ?>
		</div>
		
        <h2><?=$case['name']?>: <?=$case['info']?></h2>

        <?=$case['intro']?>

		<?php if (!is_null($start_url)):?>
			<a class="button-primary" href="<?=$start_url?>">Start</a>
		<?php endif ?>
    </div>
</section>

<script>
	$(document).ready(function() {
        $(document).ready(function () {
            $('#assignment_form').submit(function (event) {
                event.preventDefault();

                const formData = $(this).serialize();

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