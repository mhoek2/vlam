<?php echo $header; ?>

<div class="breadcrumbs">
    <ul>
	    <li><a href="<?=base_url('admin/trainings')?>">Trainings</a></li>
	    <li><span><?=$training['name']?></span></li>
    </ul>
</div>

<style>
.members {
    margin-top:2em;
}
</style>

<section class="main">
    <div class="content">
        <form id="edit_training" method="POST">
            <label>Name<lable>
            <input type="text" name="name" value="<?=$training["name"]?>">

            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <button type="submit">Opslaan</button>
        </form>

        <!-- why a form? -->
        <form id="member_adding" method="POST"> 
            <h3>Assign Users to Training</h3>

            <label for="user">Search for User:</label>
            <input type="text" id="search_member" name="user" placeholder="Search users...">
            <input type="submit" value="Assign">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
        </form>

        <div class="members">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $item): ?>
                        <tr>
                            <td><?= $item['firstname'] . ' ' . $item['middlename'] . ' ' . $item['lastname']; ?></td>
                            <td>
                                <button id="delete_member" data-member-id="<?=$item['id']?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
<script {csp-script-nonce}>
    $(document).ready(function () {

        function add_member( user_id )
        {
	        $.ajax({
		        url: '<?=current_url()?>/add_member',
		        method: 'POST',
		        data: {
			        user_id: user_id,
		        },
		        success: function (response) {
			        if (response.status === 'success') {
				        //loadProperties( entryId, entryType );
				        $(`#search_member`).val('');
                        location.reload();
			        }
		        }
	        });
        }

        $(document).on('click', '#delete_member', function () 
        {
            const member_id = $(this).data('member-id');
			const confirmation = confirm("Are you sure you want to delete this member?");

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_member',
		            method: 'POST',
		            data: {
			            member_id: member_id,
		            },
		            success: function (response) {
			            if (response.status === 'success') {
				            //loadProperties( entryId, entryType );
				            $(`#search_member`).val('');
                            location.reload();
			            }
		            }
	            });
            }
        });

        $('#search_member').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= site_url('admin/training/getUsersForAutocomplete'); ?>',
                    method: 'GET',
                    data: {
                        query: request.term // Send the typed query term
                    },
                    success: function(data) {
                        // Map the data to display in the autocomplete dropdown
                        response($.map(data, function(item) {
 
                            return {
                                label: item.firstname + ' ' + item.middlename + ' ' + item.lastname, 
                                value: item.id // Store user ID (to be used when the form is submitted)
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                // Optionally handle the selection of a user from the autocomplete list
                console.log(ui);
                console.log("User selected: " + ui.item.label);
                add_member(ui.item.value);
            }
        });
        
        $('#edit_training').submit(function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '<?= site_url('admin/training/'.$training["id"].'/save') ?>',
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
