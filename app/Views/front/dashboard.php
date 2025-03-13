<?php echo $header; ?>

<section class="main">
    <?=$sidebar?>

	<div class="content" style="background:transparent; padding:0;">
		<div class="dashboard_modules">
			<?php foreach( $dashboard_modules as $module ): ?>
				<article>
					<?=$module?>
				</article>
			<?php endforeach ?>
		</div>
	</div>
</section>

<?php echo $footer; ?>