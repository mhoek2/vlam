<?php echo $header; ?>

<style>
	.dashboard_modules {
		  display: grid;
		  grid-template-columns: repeat(4, 1fr);
		  gap: 16px;
	}
		.dashboard_modules article {
			background:#f1f1f1;
			border-radius: 10px;
			overflow: hidden;
			word-wrap: break-word;
			padding: 10px;
		}
		.dashboard_modules article.wide {
			grid-column: span 2;
		}
</style>

<section class="main">
    <?=$sidebar?>

	<div class="content" style="background:transparent; padding:0;">
		<div class="dashboard_modules">
			<?php foreach( $dashboard_modules as $module ): ?>
				<article class="<?=$module->getCssClass()?>">
					<?=$module->index()?>
				</article>
			<?php endforeach ?>
		</div>
	</div>
</section>

<?php echo $footer; ?>