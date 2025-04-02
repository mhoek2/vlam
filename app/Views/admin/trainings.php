<?php echo $header; ?>

<div class="breadcrumbs">
   	<ul>
		<li><span>Trainingen</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">

		<div class="actions left" style="margin-bottom:25px;">
            <button class="button-primary" id="add_training">
                <i class="fa-solid fa-circle-plus"></i> Training aanmaken
            </button>
		</div>

        <table>
            <thead>
                <tr>
                    <th>Training</th>
                    <th width="150">Leden</th>
                    <th width="150">Start</th>
                    <th width="150">Einde</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $trainings as $id => $item):?>
                    <tr>
                        <td><a href="<?=base_url(route_to('admin.training', $item['id']))?>"><?=!empty($item['name']) ? $item['name'] : '-'?></a></td>
                        <td><?=$item['member_count']?></td>
                        <td><?=$item['started']?></td>
                        <td><?=$item['stopped']?></td>
                        <td>
                            <button id="delete_training" data-training-id="<?=$item['id']?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script {csp-script-nonce}>
    $(document).ready(function () {
		<?=updateCSRFMeta() // csrf helper ?>

        $(document).on('click', '#delete_training', function ()
        {
            const training_id = $(this).data('training-id');
			const confirmation = confirm('Are you sure you want to remove this training');

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_training',
		            method: 'POST',
		            data: {
			            training_id: training_id,
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

        $(document).on('click', '#add_training', function ()
        {
            $.ajax({
		        url: '<?=current_url()?>/add_training',
		        method: 'POST',
		        data: {
					<?=setCSRFPostData()?>
		        },
		        success: function (response) {
					updateCSRFMeta(response);

			        if (response.status === 'success') {
						window.location = response.redirect_url;
			        }
		        }
	        });
        });
    });
</script>

<?php echo $footer; ?>