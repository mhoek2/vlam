<?php echo $header; ?>

<!-- CONTENT -->

<style>
	#case_entry_form {
		display: flex;
		flex-direction: column;
		min-height: 100%;
	}
    .case-entry {
		flex-grow: 1;
    }
		.case-entry .properties-container {
			display: flex;
			flex-direction: row;
		}
			.case-entry .properties-container .properties
			{
				margin:3em 0;
				display: flex;
				flex-direction: column;
			}
				.case-entry .properties-container .properties > div
				{
					margin:1em 0;
					padding:1em 1em;
					background:#fff;
					color:var(--secondary-color);
					border-radius:10px;
					font-weight: bold;
					cursor:pointer;
				}
				.case-entry .properties-container .properties > div.selected {
					background:var(--primary-color);
					color:#fff;
				}
			.case-entry .properties-aside {

			}
		.case-entry.optional > h2 {
			position: relative;
		}
		.case-entry.optional > h2::after {
			content: '*Optioneel';
			position: absolute;
			left: 0;
			bottom: -2.5em;
			font-weight: normal;
			font-size: 10px;
			color: var(--primary-color);
		}
	
	.case-progress {
        display: flex;
        align-items: center;
        gap: 10px;
		justify-content: space-between;
		margin-top:3em;
	}
		.case-progress button {
		}
		.case-progress .indicator {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap:30px;
		}
			.case-progress .indicator > div {
				width:60px;
				height:60px;
				border-radius:100%;
				line-height: 60px;
				text-align: center;
				font-size:32px;
				font-weight: bold;
				background:#fff;
				color:var(--primary-color);
			}
			.case-progress .indicator > div.selected {
				background:var(--primary-color);
				color:#fff;
			}
</style>

<section class="main">
    <?=$sidebar?>

    <div class="content">

		<form method="POST" id="case_entry_form">
			<div class="case-entry <?= (bool)$entry['optional'] ? 'optional' : '' ?>">
				<?php
					$mcq_multi = preg_match('/^mcq-(\d+)$/', $entry['type'], $matches);
					$max_selectable = $mcq_multi ? (int)$matches[1] : NULL;
	
					$mcq_has_selected = ( ($entry['type'] == "mcq" || $mcq_multi) && $entry['selected_count'] !== 0 );
				?>

				<?php if($entry['type'] == "text_separator"): ?>
					<?php foreach ($entry['properties'] as $property): ?>
						<?=$property['content']?>
					<?php endforeach ?>

				<?php elseif($entry['type'] == "mcq" || $mcq_multi): ?>
					<h2><?=$entry['name']?></h2>

					<div class="properties-container" <?= (bool)!$entry['optional'] ? 'data-required' : '' ?>>
						<div class="properties">
							<?php foreach ($entry['properties'] as $property): ?>
								<div class="<?= $property['selected'] ? 'selected' : '' ?>" id="property" data-property-id="<?=$property['id']?>">
									<?=$property['content']?>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="properties-aside">
						</div>
					</div>

				<?php elseif($entry['type'] == "text_input"): ?>
					<h2><?=$entry['name']?></h2>

				<?php else: ?>
					<h2><?=$entry['name']?></h2>

				<?php endif ?>
			</div>

			<div class="case-progress">

				<a class="button-primary" href="<?=$entry_prev_url?>">
					<i class="fa-solid fa-chevron-left"></i> Previous
				</a>

				<div class="indicator">
					<?php foreach ($entries as $i => $item): ?>
						<div class="<?= ($entry['id'] == $item['id']) ? 'selected' : '' ?>">
							<?=($i + 1)?>
						</div>
					<?php endforeach ?>
				</div>

				<button class="button-primary <?= ($is_input_type && (bool)!$entry['optional'] && !$mcq_has_selected) ? 'disabled' : '' ?>" type="submit" id="next_entry">
					Next <i class="fa-solid fa-chevron-right"></i>
				</button>
			</div>
		</form>
		
    </div>
</section>

<script>
	$(document).ready(function() {
		<?=updateCSRFMeta() // csrf helper ?>

		function set_next_entry_button_state( state )
		{
			$('#next_entry').toggleClass('disabled', !state);
		}
		
		function validate_mcq_properties()
		{
			const propertyContainer = $('.properties-container');
			
			if ( typeof propertyContainer.data('required') === 'undefined')
				return true;
			
			const checkedCount = propertyContainer.find('#property.selected').length;
			
			// Check if at least one checkbox is selected
			if ( checkedCount === 0 )
				return false;
			
			return true;
		}

		$('#case_entry_form').submit(function (event) {
			event.preventDefault();
			
			const validated = validate_mcq_properties();
			set_next_entry_button_state( validated );
			
			if ( !validated )
				return;
			
			window.location = '<?=$entry_next_url?>';
		});
		
		$(document).on('click', '#property', function(){
			let propertyId = $(this).data('property-id');

			<?php if ($mcq_multi): ?>
				// support for multiple selectables
				let addProperty = false;
				const selectedProperties = [];

				if ($(this).hasClass('selected'))
					$(this).removeClass('selected');
				else
					addProperty = true;

				$(this).closest('.properties-container').find('#property.selected').each(function() {
					selectedProperties.push($(this).data('property-id'));
				});

				if (addProperty) {
					if (selectedProperties.length < <?=$max_selectable?>) {
						$(this).addClass('selected')
						selectedProperties.push(propertyId);
					}
					else
						return;
				}

				propertyId = selectedProperties;
			<?php endif?>

			$.ajax({
				url: '<?=current_url().'/save'?>',
				type: 'POST',
				data: {
					entry_id: <?=$entry['id']?>,
					property_id: propertyId,
					<?=setCSRFPostData()?>
				},
				success: function(response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
						<?php if (!$mcq_multi): ?>
							$(this).siblings().removeClass('selected');
							$(this).addClass('selected');
						<?php endif ?>
					}
					else if (response.status === 'error') {
						<?php if ($mcq_multi): ?>
							$(this).removeClass('selected');
						<?php endif ?>
					}
			
					set_next_entry_button_state( validate_mcq_properties() );
				}.bind(this),
				error: function(xhr, status, error) {
					console.log(error);
				}
			})
		});
    });
</script>

<?php echo $footer; ?>