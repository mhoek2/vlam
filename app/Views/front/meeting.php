<?php echo $header; ?>

<section class="main">
	<?=$sidebar?>

    <div class="content">
    	<div class="actions">
    		<?php if ( isset($prev_url)): ?>
				<a class="button-primary small" href="<?=$prev_url?>"><i class="fa-solid fa-chevron-left"></i> Terug naar home</a>
			<?php endif ?>
		</div>
       
        <h1 class="name"> <?=$meeting['info'];?></h1>
		
        <div class="ck-content">
			<?=$meeting['intro'];?>
		</div>
    </div>
</section>

<?php echo $footer; ?>