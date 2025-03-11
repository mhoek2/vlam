<?php echo $header; ?>

<div class="breadcrumbs">
    <ul>
		<li><a href="<?=base_url(route_to('admin.trainings'))?>">Trainingen</a></li>
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

            <?= csrf_field() ?>

			<div class="actions">
				<button type="submit" class="button-primary">
					<i class="fa-regular fa-floppy-disk"></i>Opslaan
				</button>
			</div>
        </form>

        <!-- why a form? -->
        <form id="member_adding" method="POST"> 
            <h3>Assign Users to Training</h3>

            <label for="user">Search for User:</label>
            <input type="text" id="search_member" name="user" placeholder="Search users...">

            <?= csrf_field() ?>
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
                            <td><?=$item['fullname']?></td>
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
		
		<label>Test knop om training te clonen:</label>
		<a class="button" href="<?=current_url()?>/start"><i class="fa-solid fa-meteor"></i> Start</a>
    </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
<script {csp-script-nonce}>
    $(document).ready(function () {

		<?=updateCSRFMeta() // csrf helper ?>
		
        function add_member( user_id )
        {
	        $.ajax({
		        url: '<?=current_url()?>/add_member',
		        method: 'POST',
		        data: {
			        user_id: user_id,
					<?=setCSRFPostData()?>
		        },
		        success: function (response) {
					updateCSRFMeta(response);
					
			        if (response.status === 'success') {
				        $(`#search_member`).val('');
                        location.reload();
			        }
		        }
	        });
        }

        $(document).on('click', '#delete_member', function () 
        {
			event.preventDefault();
			
            const member_id = $(this).data('member-id');
			const confirmation = confirm("Are you sure you want to delete this member?");

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_member',
		            method: 'POST',
		            data: {
			            member_id: member_id,
						<?=setCSRFPostData()?>
		            },
		            success: function (response) {
						updateCSRFMeta(response);
						
			            if (response.status === 'success') {
                            location.reload();
			            }
		            }
	            });
            }
        });

        $('#search_member').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= base_url(route_to('admin.find_user_autocomplete')); ?>',
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
                url: '<?=base_url(route_to('admin.training.save', $training["id"]))?>',
                type: 'POST',
                data: formData,
                success: function(response) {
					updateCSRFMeta(response);
					
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

<?php echo $footer; ?>
