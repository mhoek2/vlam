<div class="meetings">
	<div class="inner">
		<?php if (!is_null($meeting)):?>
		<ul>
			<a href="<?= site_url('meeting/'.$meeting['id']) ?>">
				<li>
					<span class="name"><?=$meeting['name'];?></span>
					<span class="info"><?=$meeting['info'];?></span>
				</li>
			</a>
		</ul>
		<?php else: ?>
		   <?php if (!is_null($meetings)):?>
				<ul>
					<?php foreach( $meetings as $item ): ?>
					<a href="<?= site_url('meeting/'.$item['id'].'/') ?>">
						<li>
							<span class="name"><?=$item['name'];?></span>
							<span class="info"><?=$item['info'];?></span>
						</li>
					</a>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
		<?php endif ?>

		<?php if (!is_null($assignments)):?>
		<div class="assignments">
			<ul>
				<?php foreach( $assignments as $item ): ?>
					<a href="<?= site_url('meeting/'.$meeting['id'].'/assignment/' . $item['id']) ?>">
						<li class="<?=(!is_null($assignment) && $assignment['id'] === $item['id']) ? 'active' : ''?>">
							<?=$item['name']?>: <?=$item['info']?>
						</li>
					</a>
				<?php endforeach ?>
			</ul>
		</div>
		<?php endif ?>

		<?php if (!is_null($cases)):?>
		<div class="cases">
			<ul>
				<?php foreach( $cases as $item ): ?>
					<a href="<?= site_url('meeting/'.$meeting['id'].'/assignment/'.$assignment['id'].'/case/' . $item['id']) ?>">
						<li><?=$item['name']?></li>
					</a>
				<?php endforeach ?>
			</ul>
		</div> 
		<?php endif ?> 	
	</div>
</div>