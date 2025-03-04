<div class="entry grid-item" data-id="<?= $id ?>" data-entry-id="<?= $id ?>" data-type="<?= $type ?>">
	<div class="details">
		<div class="sortable-handle">
			<i class="fa-solid fa-grip-vertical"></i>
		</div>

		<h3 class="entry-name contenteditable" data-entry-id="<?= $id ?>" contenteditable="true"><?= $name ?></h3>

		<?php if (!is_null($type_group) && $entry_type_group_counts[$type_group] > 1): ?>
			<select class="entry-type-select" data-entry-id="<?= $id ?>">
				<?php foreach($entry_types as $entry_type): ?>
					<?php 
					// filter types based on group
					if ( $type_group !== $entry_type["group"] ) continue; 
					?>
				
					<option value="<?=$entry_type["type"]?>" <?= $type == $entry_type['type'] ? 'selected' : '' ?>>
						<?=$entry_type['name']?>
					</option>
				<?php endforeach ?>
			</select>
		<?php endif ?>
		
		<button class="delete-entry" data-entry-id="<?= $id ?>">
			<i class="fa-regular fa-trash-can"></i>
		</button>

		<button class="toggle-properties">
			<i class="fa-solid fa-bars"></i>
		</button>
	</div>
	
	<div class="properties" style="display: none;">
		<ul id="properties-list-<?= $id ?>"></ul>
		
		<div class="properties-actions">
			<input type="text" id="new-property-<?= $id ?>" placeholder="option">
			<button class="add-property" data-entry-id="<?= $id ?>">
				<i class="fa-solid fa-plus"></i>
			</button>
		</div>
	</div>
</div>