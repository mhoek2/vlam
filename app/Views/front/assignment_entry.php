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

<?php elseif($type == "text_input"): ?>
	<label><?=$name?></label>
	<input type="text" name="entries[<?=$id?>]" value="<?=$value?>"/>

<?php else: ?>
	<h3><?=$name?></h3>

<?php endif ?>
