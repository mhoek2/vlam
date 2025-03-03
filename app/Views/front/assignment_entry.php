<?php if($type == "text_separator"): ?>
	<?php foreach( $properties as $property ): ?>
		<?=$property['content']?>
	<?php endforeach ?>

<?php elseif($type == "mcq"): ?>
	<label><?=$name?></label>
	<select name="entries[<?=$id?>]">
		<?php foreach ($properties as $property): ?>
			<option value="<?= $property['id'] ?>" <?= $property['selected'] ? 'selected' : '' ?>><?= $property['content'] ?></option>
		<?php endforeach; ?>
	</select>

<?php elseif(preg_match('/^mcq-(\d+)$/', $type, $matches)): ?>
	<label><?=$name?></label>

	<div class="property-container" id="entry_<?=$id?>" data-max-selectable="<?= (int)$matches[1] ?>">
		<?php foreach ($properties as $property): ?>
			<div>
				<input type="checkbox" name="entries[<?=$id?>][]" class="entry-property" id="e_<?=$id?>_p_<?=$property['id']?>" value="<?=$property['id']?>" 
					<?= $property['selected'] ? 'checked' : '' ?>>
				<label for="e_<?=$id?>_p_<?=$property['id']?>"><?= $property['content'] ?></label>
			</div>
		<?php endforeach; ?>
	</div>

<?php elseif($type == "text_input"): ?>
	<label><?=$name?></label>
	<input type="text" name="entries[<?=$id?>]" value="<?=$value?>"/>

<?php else: ?>
	<h3><?=$name?></h3>

<?php endif ?>
