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
        
        <h2><?=$assignment['name']?>: <?=$assignment['info']?></h2>

        <?=$assignment['intro']?>

        <form method="POST" id="assignment_form">
		    <?php foreach ($entries as $item) { ?>
		    	<div class="assignment-entry">
			    	<?=view('front/assignment_entry', $item)?>
			    </div>
		    <?php }; ?>

            <button type="submit">Opslaan</button>
        </form>
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