<?php echo $header; ?>

<!-- CONTENT -->

<style>
	.assignment-container {
		display:flex;
		flex-direction: column;
		gap:15px;
		margin-bottom: 15px;
	}
		.assignment-container .assignment-entry {
			display: flex;
			flex-direction: row;
			align-items: center;
			gap: 15px;
		}
			.assignment-container .assignment-entry > label {
				position: relative;
				min-width: 250px;
				width: 250px;
			}
				.assignment-container .assignment-entry.optional > label::after {
					content: '*Optioneel';
					position: absolute;
					left: 0;
					bottom: -1.5em;
					font-weight: normal;
					font-size: 10px;
					color: var(--primary-color);
				}
			.assignment-container .assignment-entry .property-container {
				display: flex;
				flex-direction: column;
				background: var(--input-background-color-default);
				border-radius: var(--secondary-border-radius);
				border: 1px solid var(--input-border-color-default);
				gap: 1em;
				padding: 1em;
			}
			.assignment-container .assignment-entry .property-container:hover {
				border-color: var(--input-border-color-hover);
			}

				.assignment-container .assignment-entry .property-container > div {
					display:flex;
					flex-direction: row;
					gap: 1em;
				}

				.assignment-container .assignment-entry .property-container > div label {
					padding:0;
					margin:0;
					min-width: 250px;
					width: 250px;
				}
</style>

<section class="main">
    <?=$sidebar?>
	
    <div class="content">
    	<div class="actions">
    		<?php if ( isset($prev_url) && !is_null($meeting) ): ?>
				<a class="button-primary small" href="<?=$prev_url?>"><i class="fa-solid fa-chevron-left"></i> Terug naar bijeenkomst <?=$meeting['name']?></a>
			<?php endif ?>
		</div>
       
        <h2><?=$assignment['name']?>: <?=$assignment['info']?></h2>

        <?=$assignment['intro']?>

        <form method="POST" id="assignment_form">
			<div class="assignment-container">
				<?php foreach ($entries as $item) { ?>
					<?=view('front/assignment_entry', $item)?>
				<?php }; ?>
			</div>
			
			<?= csrf_field() ?>
			
            <button class="button-primary" type="submit"><?=$sub_assignment ? 'Volgende' : 'Opslaan'?></button>
        </form>
    </div>
</section>

<script>
	$(document).ready(function() {
		<?=updateCSRFMeta() // csrf helper ?>

		$('.entry-property').on('change', function() {
			const propertyContainer = $(this).closest('.property-container');
			const checkboxes = propertyContainer.find('input[type="checkbox"]');
			const checkedCount = propertyContainer.find('.entry-property:checked').length;

			if (checkedCount > propertyContainer.data('max-selectable')) {
				$(this).prop('checked', false);
			}
			
			// reset because browsers can prevent form submissions if a form was previousely marked invalid.
			checkboxes.each(function() {
				this.setCustomValidity('');
			});
		});

		// Validate if mcq-* type. where multiple options are asked. (check if at least one is selected)
		function validate_mcq_properties()
		{
			let isValid = true;

			$('.property-container').each(function() {
				const propertyContainer = $(this);
				
				if ( typeof propertyContainer.data('required') === 'undefined')
					return true;
				
				const checkboxes = propertyContainer.find('input[type="checkbox"]');
				const checkedCount = propertyContainer.find('.entry-property:checked').length;
				
				// Check if at least one checkbox is selected
				if ( checkedCount === 0 ) {
					const checkbox = checkboxes.first();
					checkbox[0].setCustomValidity('Please select at least one option.');
					checkbox[0].reportValidity();
					
					isValid = false;
				} 
			});

			return isValid;
		}
		
		$('#assignment_form').submit(function (event) {
			event.preventDefault();
			
			if ( !validate_mcq_properties() )
				return;
			
			const formData = $(this).serialize();

			$.ajax({
				url: '<?=current_url().'/save'?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					updateCSRFMeta(response);
					window.location = '<?=$post_url?>';
				},
				error: function(xhr, status, error) {
					// Handle any error
					$('#responseMessage').html('<p>An error occurred while submitting the form.</p>');
				}
			});
		});
    });
</script>

<?php echo $footer; ?>