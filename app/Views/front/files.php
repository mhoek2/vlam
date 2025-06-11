<?php echo $header; ?>

<section class="main">
	<?=$sidebar?>

    <div class="content">
    	<div class="actions">
    		<?php if ( isset($prev_url) && !is_null($meeting) ): ?>
				<a class="button-primary small" href="<?=$prev_url?>"><i class="fa-solid fa-chevron-left"></i> Terug naar bijeenkomst <?=$meeting['name']?></a>
			<?php endif ?>
		</div>
       
		<?php foreach ($errors as $error): ?>
			<li><?= esc($error) ?></li>
		<?php endforeach ?>

		<?php if ( isset($success)): ?>
			<div class="success">
				<?=$success?>	
			<div>
		<?php endif ?>
		
		<div class="upload-container">
			<?= form_open_multipart(base_url(route_to('front.files_upload', $meeting['id']))) ?>
				<label for="file-upload" class="drop-area" id="drop-area">
					<i class="fas fa-cloud-upload-alt"></i>
					<p>Plaats het bestand dat je wilt uploaden</p>
				</label>

				<input type="file" id="file-upload" name="userfile"/>
				<button type="submit" class="button-primary">Uploaden</button>
			</form>

			<p id="file-name"></p>
		</div>		
	
		<table>
			<thead>
				<tr>
					<th>Bestand</th>
					<th width="150">Geupload</th>
					<th width="150">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $uploads as $file):?>
					<tr>
						<td>
							<a href="<?=download_url( $file['path'] )?>" target="_blank"><?=$file['filename']?></a>
						</td>
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
	
<script>
	$(document).ready(function() {
		<?=updateCSRFMeta() // csrf helper ?>
		
		var $fileInput = $('#file-upload');
		var $dropArea = $('#drop-area');
		var $fileName = $('#file-name');

		$fileInput.on('change', function() 
					  {
			var file = this.files[0];
			if (file) {
				$fileName.text('Selected file: ' + file.name);
			} else {
				$fileName.text('');
			}
		});

		$dropArea.on('dragenter dragover', function(e) 
					 {
			e.preventDefault();
			e.stopPropagation();
			$(this).addClass('highlight');
		});

		$dropArea.on('dragleave', function(e) 
					 {
			e.preventDefault();
			e.stopPropagation();
			$(this).removeClass('highlight');
		});

		$dropArea.on('drop', function(e) 
		{
			e.preventDefault();
			e.stopPropagation();
			$(this).removeClass('highlight');

			var files = e.originalEvent.dataTransfer.files;
			if (files.length > 0) {
				$fileInput[0].files = files;
				// Trigger change event to update filename display
				$fileInput.trigger('change');
			}
		});
		
        $(document).on('click', '#delete_file', function ()
        {
            const file_id = $(this).data('file-id');
			const confirmation = confirm(`Are you sure you want to remove ${$(this).data('filename')}` );

			if (confirmation) {
                $.ajax({
		            url: '<?=base_url(route_to('front.files_delete', $meeting['id']))?>',
		            method: 'POST',
		            data: {
			            file_id: file_id,
						<?=setCSRFPostData()?>
		            },
		            success: function (response) {
						updateCSRFMeta(response);

			            if (response.status === 'success') {
                            location.href = "<?=base_url(route_to('front.files', $meeting['id']))?>";
			            }
		            }
	            });
            }
        });
	});
</script>
	
<?php echo $footer; ?>