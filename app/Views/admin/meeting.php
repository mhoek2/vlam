<?php echo $header; ?>

<!-- CONTENT -->

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

<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
<script {csp-script-nonce}>
    $(document).ready(function () {
	    const {
		    ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font,
            Heading,
            Link,
            BlockQuote,
            CodeBlock,
            List,
            TodoList,
	    } = CKEDITOR;
	    ClassicEditor
		    .create( document.querySelector( '#intro' ), {
			    licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzA0MjIzOTksImp0aSI6IjdiNzA0MzZhLWE2MDMtNGI2Yi1hOGQxLTJmYzk3MWEzYmIxYyIsImxpY2Vuc2VkSG9zdHMiOlsiMTI3LjAuMC4xIiwibG9jYWxob3N0IiwiMTkyLjE2OC4qLioiLCIxMC4qLiouKiIsIjE3Mi4qLiouKiIsIioudGVzdCIsIioubG9jYWxob3N0IiwiKi5sb2NhbCJdLCJ1c2FnZUVuZHBvaW50IjoiaHR0cHM6Ly9wcm94eS1ldmVudC5ja2VkaXRvci5jb20iLCJkaXN0cmlidXRpb25DaGFubmVsIjpbImNsb3VkIiwiZHJ1cGFsIl0sImxpY2Vuc2VUeXBlIjoiZGV2ZWxvcG1lbnQiLCJmZWF0dXJlcyI6WyJEUlVQIiwiQk9YIl0sInZjIjoiZDYwZjUzMDUifQ.z2QBK-JsDzcivBdrBMos8JHYhKbS4nUDXdFJkRtnmpyThmyA9JEfG5mFfGjIN8pZCdtrTYrirVWdxKcm5Ptkhw',
                plugins: [ Essentials, Paragraph, Bold, Font, Heading, Link, Italic, BlockQuote, CodeBlock, List, TodoList, ],
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|',
                        'heading',
                        '|',
                        'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        '|',
                        'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                        '|',
                        'link', 'uploadImage', 'blockQuote', 'codeBlock',
                        '|',
                        'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: false
                }
		    } )
		    .then( editor => {
			    window.editor = editor;
		    } )
		    .catch( error => {
			    console.error( error );
		    } );

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
