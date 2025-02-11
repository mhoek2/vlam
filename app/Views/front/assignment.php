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
    <div class="meetings">
        <ul>
            <a href="<?= site_url('meeting/'.$meeting['id']) ?>">
                <li>
                    <span class="name"> <?=$meeting['name'];?></span>
                    <span class="info"> <?=$meeting['info'];?></span>
                </li>
            </a>
        <ul>
        <div class="assignments">
            <ul>
                <?php foreach( $assignments as $item ): ?>
                    <a href="<?= site_url('meeting/'.$meeting['id'].'/assignment/' . $item['id']) ?>">
                        <li><?=$item['name']?>: <?=$item['info']?></li>
                    </a>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

    <div class="content">
        
        <h2><?=$assignment['name']?>: <?=$assignment['info']?></h2>

        <?=$assignment['intro']?>

        <form method="POST">
		    <?php foreach ($entries as $item) { ?>
			    <?=view('front/assignment_entry', $item);?>
		    <?php }; ?>
        </form>
    </div>
</section>

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<script {csp-script-nonce}>
        // HEADER
        document.getElementById("menuToggle").addEventListener('click', toggleMenu);
        function toggleMenu() {
            var menuItems = document.getElementsByClassName('menu-item');
            for (var i = 0; i < menuItems.length; i++) {
                var menuItem = menuItems[i];
                menuItem.classList.toggle("hidden");
            }
        }
</script>

</body>
</html>
