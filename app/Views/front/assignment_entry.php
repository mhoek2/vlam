<div class="assignment-entry <?= (bool)$optional ? 'optional' : '' ?>" data-entry-id="<?=$id?>">
	<?php if($type == "text_separator"): ?>
		<?php foreach( $properties as $property ): ?>
			<?=$property['content']?>
		<?php endforeach ?>
	
	<?php elseif($type == "video_youtube"): ?>
		<?php foreach( $properties as $property ): ?>
			<?php if ( empty($property['content']) ) continue;?>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$property['content']?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
	
		<?php endforeach ?>
	
	<?php elseif($type == "mcq"): ?>
		<label><?=$name?></label>

		<select name="entries[<?=$id?>]" <?= (bool)!$optional ? 'required' : '' ?>>
			<?php foreach ($properties as $property): ?>
				<option value="<?= $property['id'] ?>" <?= $property['selected'] ? 'selected' : '' ?>><?= $property['content'] ?></option>
			<?php endforeach; ?>
		</select>

	<?php elseif(preg_match('/^mcq-(\d+)$/', $type, $matches)): ?>
		<label><?=$name?></label>

		<div class="property-container" id="entry_<?=$id?>" data-max-selectable="<?= (int)$matches[1] ?>" <?= (bool)!$optional ? 'data-required' : '' ?>>
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

		<!--<input type="text" name="entries[<?=$id?>]" value="<?=$value?>" <?= (bool)!$optional ? 'required' : '' ?>/>-->
		<textarea name="entries[<?=$id?>]" <?= (bool)!$optional ? 'required' : '' ?>><?=$value?></textarea>
	<?php else: ?>
		<h3><?=$name?></h3>

	<?php endif ?>
</div>