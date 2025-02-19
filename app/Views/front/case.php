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
        
        <h2><?=$case['name']?>: <?=$case['info']?></h2>

        <?=$case['intro']?>

        <form method="POST" id="assignment_form">
			TEST
            <button type="submit">Opslaan</button>
        </form>
    </div>
</section>

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<script>
	$(document).ready(function() {
        $(document).ready(function () {
            $('#assignment_form').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                console.log(formData);
                $.ajax({
                    url: '<?=current_url().'/save'?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the response from the server
                        $('#responseMessage').html('<p>' + response.message + '</p>');
                    },
                    error: function(xhr, status, error) {
                        // Handle any error
                        $('#responseMessage').html('<p>An error occurred while submitting the form.</p>');
                    }
                });
            });
        });
    });
</script>

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
