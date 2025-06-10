<?php echo $header; ?>

<!-- CONTENT -->

<section class="main">
    <div class="content">
		<?php foreach ($errors as $error): ?>
			<li><?= esc($error) ?></li>
		<?php endforeach ?>
		
		<?php if ( isset($success)): ?>
			<div class="success">
				<?=$success?>	
			<div>
		<?php endif ?>

		<?= form_open_multipart(base_url(route_to('admin.files_upload'))) ?>
			<input type="file" name="userfile" size="20">
			<br><br>
			<input type="submit" value="upload">
		</form>
			
	
		<table>
			<thead>
				<tr>
					<th>Bestand</th>
					<th width="150">Type</th>
					<th width="150">Geupload</th>
					<th width="150">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $uploads as $file):?>
					<tr>
						<td><a href=""></a><?=$file['filename']?></td>
						<td><?=$file['extension']?></td>
						<td><?=$file['created_at']?></td>
						<td>
							<button id="delete_file" data-file-id="<?=$file['id']?>" data-filename="<?=$file['filename']?>">
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

        $(document).on('click', '#delete_file', function ()
        {
            const file_id = $(this).data('file-id');
			const confirmation = confirm(`Are you sure you want to remove ${$(this).data('filename')}` );

			if (confirmation) {
                $.ajax({
		            url: '<?=base_url(route_to('admin.files_delete'))?>',
		            method: 'POST',
		            data: {
			            file_id: file_id,
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
	});
	</script>

<?php echo $footer; ?>