<?php foreach( $entries as $entry ): ?>
		
			<?php if ($entry['type'] === 'text_separator') { ?>
				<div class="entry">
					<?php foreach( $entry['properties'] as $property ): ?>
						<h3><?php echo($property['content']); ?><h3>
					<?php endforeach ?>
				</div>
							
			<?php } else if ($entry['type'] === 'text_input') { ?>
				<div class="entry">
					<h3><?=$entry['name']?></h3>
					
					<div class="value"><?=$entry['value']?></div>
				</div>
							
			<?php } else { ?>
				<div class="entry ">
					<h3><?=$entry['name']?> <?=!empty($entry['optional']) ? '<div class="optional">*optioneel</div>' : ''?></h3>

					<div class="properties">
						<?php foreach( $entry['properties'] as $property ): ?>
							<div class="<?= $property['selected'] ? 'selected' : '' ?>"><?php echo($property['content']); ?></div>
						<?php endforeach ?>
					</div>
				</div>
			<?php } ?>
		
<?php endforeach ?>