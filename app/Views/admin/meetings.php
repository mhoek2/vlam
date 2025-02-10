<?php echo $header; ?>

<!-- CONTENT -->

<section class="main">
    <div class="content">
   	    <ul>
		    <li><span>Meetings</span></li>
        </ul>

        <ul>
        <?php foreach( $meetings as $item):?>
            <li><a href="<?=site_url()."admin/meeting/".$item['id']?>"><?=$item["name"]?></a></li>
        <?php endforeach?>
        </ul>
    </div>
</section>


<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<!-- SCRIPTS -->

<script {csp-script-nonce}>
    document.getElementById("menuToggle").addEventListener('click', toggleMenu);
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

<!-- -->

</body>
</html>
