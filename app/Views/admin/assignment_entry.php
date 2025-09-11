<div class="entry grid-item" data-id="<?= $id ?>" data-entry-id="<?= $id ?>" data-type="<?= $type ?>">
	<div class="details">
		<div class="sortable-handle">
			<i class="fa-solid fa-grip-vertical"></i>
		</div>
		
		<div class="type"><?=$type_short?></div>
		
		<div class="separator"></div>
		
		<h3 class="entry-name contenteditable" data-entry-id="<?= $id ?>" contenteditable="true"><?= $name ?></h3>

		<?php if ( $is_multi_type_group ): ?>
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
		
			<div class="separator"></div>
		<?php endif ?>
		
		<?php if ( $is_input ): ?>
			<div class="entry-optional">
				<label for="entry_optional_checkbox_<?=$id?>">*Optioneel</label>
				<input id="entry_optional_checkbox_<?=$id?>"  data-entry-id="<?= $id ?>" type="checkbox" <?= (bool)$optional ? 'checked' : '' ?>/>
			</div>
		<?php endif ?>
		
		<div class="separator"></div>
		
		<button class="delete-entry button-action trash" data-entry-id="<?= $id ?>">
			<div class="icon"></div>
		</button>
		
		<button class="toggle-properties <?php echo ($type == 'text_input') ? 'disabled' : '' ?>">
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