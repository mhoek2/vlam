<?php echo $header; ?>

<!-- CONTENT -->

<style>
    .assignment-entry {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .assignment-entry label {
        width: 150px; /* Adjust the label width */
    }

    select {
        padding: 5px;
        width: 200px;
    }
</style>

<section class="main">
    <?=$sidebar?>

    <div class="content">
        
        <?=$case['outro']?>

		<div class="actions">
			<a class="button-primary small" href="<?=$case_reset_url?>">
				Opnieuw proberen
			</a>
			<a class="button-primary small" href="<?=$case_complete_url?>">
				Afronden
			</a>
		</div>
    </div>
</section>

<?php echo $footer; ?>