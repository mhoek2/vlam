<?php echo $header; ?>

<style>
    
</style>

<section class="main">
    <?=$sidebar?>

    <div class="content">
    	<div class="actions">
    		<?php if ( isset($prev_url) && !is_null($meeting) ): ?>
				<a class="button small" href="<?=$prev_url?>"><i class="fa-solid fa-chevron-left"></i> Terug naar bijeenkomst <?=$meeting['name']?></a>
			<?php endif ?>
		</div>
       
        <?=$assignment['intro']?>
		
		<label>PODCAST ..</label>
    </div>
</section>

<script>
	$(document).ready(function() {

    });
</script>

<?php echo $footer; ?>