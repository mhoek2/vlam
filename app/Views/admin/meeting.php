<?php echo $header; ?>

<div class="breadcrumbs">
    <ul>
	    <li><a href="<?=base_url('admin/meetings')?>">Meetings</a></li>
	    <li><span><?=$meeting['info']?></span></li>
    </ul>
</div>

<section class="main">
    <div class="content">
        <form id="edit_meeting" method="POST">
            <label>Info<lable>
            <input type="text" name="info" value="<?=$meeting["info"]?>">

            <label>Intro<lable>
            <textarea name="intro" id="intro"><?=$meeting["intro"]?></textarea>

            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <button type="submit">Opslaan</button>
        </form>
    </div>
</section>

<section class="main">
    <div class="content">
    <h2>Assignments</h2>
    <?=$assignments_view?>
    </div>
</section>

<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<?=$text_editor->load_script()?>
<script {csp-script-nonce}>
    $(document).ready(function () {
	    <?=$text_editor->init_script()?>
	    <?=$text_editor->assign_editor('"#intro"')?>
		
        $(document).ready(function () {
            $('#edit_meeting').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?= site_url('admin/meeting/'.$current_meeting.'/save') ?>', // The URL of the controller method
                    type: 'POST', // Send POST request
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
