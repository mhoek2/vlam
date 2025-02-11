<div class="entry grid-item" data-id="<?= $id ?>" data-entry-id="<?= $id ?>" data-type="<?= $type ?>">
	<h3 class="entry-name" data-entry-id="<?= $id ?>" contenteditable="true"><?= $name ?></h3>
					
	<select class="entry-type-select" data-entry-id="<?= $id ?>">
		<?php foreach($entry_types as $entry_type): ?>
			<option value="<?=$entry_type["type"]?>" <?= $type == $entry_type['type'] ? 'selected' : '' ?>>
				<?=$entry_type['name']?>
			</option>
		<?php endforeach ?>
	</select>

	<button class="toggle-properties">Show/Hide</button>
                
	<div class="properties" style="display: none;">
		<ul id="properties-list-<?= $id ?>"></ul>
		<div class="properties-actions">
			<input type="text" id="new-property-<?= $id ?>" placeholder="option">
			<button class="add-property" data-entry-id="<?= $id ?>">Add Option</button>
		</div>
	</div>
</div>