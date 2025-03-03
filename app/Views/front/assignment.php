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

		.assignment-entry .property-container {
			display: flex;
			flex-direction: column;
			background: #Fff;
			gap: 1em;
			padding: 1em;
		}
	
			.assignment-entry .property-container > div {
				display:flex;
				flex-direction: row;
				gap: 1em;
			}
	
			.assignment-entry .property-container > div label {
				padding:0;
				margin:0;
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
    		<?php if ( isset($prev_url) && !is_null($meeting) ): ?>
				<a class="button small" href="<?=$prev_url?>"><i class="fa-solid fa-chevron-left"></i> Terug naar bijeenkomst <?=$meeting['name']?></a>
			<?php endif ?>
		</div>
       
        <h2><?=$assignment['name']?>: <?=$assignment['info']?></h2>

        <?=$assignment['intro']?>

        <form method="POST" id="assignment_form">
		    <?php foreach ($entries as $item) { ?>
		    	<div class="assignment-entry">
			    	<?=view('front/assignment_entry', $item)?>
			    </div>
		    <?php }; ?>

            <button type="submit"><?=$sub_assignment ? 'Volgende' : 'Opslaan'?></button>
        </form>
    </div>
</section>

<script>
	$(document).ready(function() {
        $(document).ready(function () {
			$('.entry-property').on('change', function() {
                const propertyContainer = $(this).closest('.property-container');
				const checkedCount = propertyContainer.find('.entry-property:checked').length;
				
                if (checkedCount > propertyContainer.data('max-selectable')) {
                    $(this).prop('checked', false);
				}
			});
			
            $('#assignment_form').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                console.log(formData);
                $.ajax({
                    url: '<?=current_url().'/save'?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        window.location = '<?=$post_url?>';
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