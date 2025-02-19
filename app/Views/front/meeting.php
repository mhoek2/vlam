<?php echo $header; ?>

<!-- CONTENT -->

<section class="main">
	<?=$sidebar?>

    <div class="content">
        <h1 class="name"> <?=$meeting['info'];?></h1>
        <p> <?=$meeting['intro'];?></p>
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
