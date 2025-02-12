<div class="assignment-entry">
	<?php if($type == "text_separator"): ?>
		<?php foreach( $properties as $property ): ?>
			<?=$property['content']?>
		<?php endforeach ?>

	<?php elseif($type == "mcq"): ?>
		<label><?=$name?></label>
		<select name="entries[<?=$id?>]">
			<?php foreach ($properties as $property): ?>
				<option value="<?= $property['content'] ?>" <?= $property['selected'] ? 'selected' : '' ?>><?= $property['content'] ?></option>
			<?php endforeach; ?>
		</select>

	<?php else: ?>
		<h3><?=$name?></h3>
	<?php endif ?>
</div>