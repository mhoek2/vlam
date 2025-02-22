<?php echo $header; ?>

<style>
	.grid-container {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
	}
	.grid-item {
		width: 100%;
		height: auto;
		background-color: lightgray;
		padding: 10px;
		text-align: center;
		border: 1px solid #ccc;
		cursor: move;
	}
	.grid-item p {
		margin: 0;
	}
	
	.entry[data-type="text_separator"] .properties-actions {
		display:none;
	}
	
	.entry[data-type="text_separator"] {
		border-left:4px solid orange;
	}
	.entry[data-type="text_input"] {
		border-left:4px solid purple;
	}
	.entry[data-type="mcq"] {
		border-left:4px solid cyan;
	}
</style>

<div class="breadcrumbs">
   	<ul>
		<li><a href="<?=base_url('admin/meetings')?>">Meetings</a></li>
		<li><a href="<?=base_url('admin/meeting/').$meeting['id']?>"><?=$meeting['info']?></a></li>
		<li><a href="<?=base_url('admin/assignments/').$assignment['id']?>"><?=$assignment['name']?>: <?=$assignment['info']?></a></li>
		<li><span><?=$case['name']?>: <?=$case['info']?></span></li>
	</ul>
</div>

<section class="main">
    <div class="content">
        <form id="edit_case" method="POST">
            <label>Name<lable>
            <input type="text" name="name" value="<?=$case["name"]?>">
            
			<label>Info<lable>
            <input type="text" name="info" value="<?=$case["info"]?>">

            <label>Intro<lable>
            <textarea name="intro" id="intro"><?=$case["intro"]?></textarea>
            
            <label>Outro<lable>
            <textarea name="outro" id="outro"><?=$case["outro"]?></textarea>
            
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <button type="submit">Opslaan</button>
        </form>
    </div>
</section>

<section class="main">
    <div class="content">

		<div class="grid-container" id="sortable">
			<?php foreach ($entries as $item) { ?>
				<?=view('admin/case_entry', $item);?>
			<?php }; ?>
		</div>
    
		<div class="entry-actions">
    		<input type="text" id="new-entry-name" placeholder="option">
    		<button class="add-entry">Add Entry</button>
		</div>
    </div>
</section>

<?=$text_editor->load_script()?>
<script {csp-script-nonce}>
    $(document).ready(function () {
	    <?=$text_editor->init_script()?>
	    <?=$text_editor->assign_editor('"#intro"')?>
	    <?=$text_editor->assign_editor('"#outro"')?>

		/* 
		CASE
		*/
        $(document).ready(function () {
            $('#edit_case').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?= site_url('admin/cases/'.$case["id"].'/save') ?>',
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

		/* 
		ENTRIES 
		*/
		$("#sortable").sortable({
			cancel: ':input,button,[contenteditable]',
			update: function(event, ui) {

				let ids = $("#sortable").sortable("toArray", { attribute: 'data-id' });
				saveEntrySortOrder(ids);
			}
		});
	
		function saveEntrySortOrder(ids) {
			$.ajax({
				url: '<?=current_url()?>/entries_save_order',
				method: 'POST',
				data: { sort_order: ids },
				success: function(response) {
					if (response.status === 'success') {
		
					}
				}
			});
		}
		
		$(document).on('change', '.entry-type-select', function() {
			const entryId = $(this).data('entry-id');
			const newType = $(this).val();
			const confirmation = confirm("Are you sure you want to change the type? This will reset the entry");

			if (confirmation) {
				$.ajax({
					url: '<?= current_url() ?>/update_entry_type',
					method: 'POST',
					data: {
						entry_id: entryId,
						type: newType
					},
					success: function(response) {
						if (response.status === 'success') {
							 $('.entry[data-entry-id="' + entryId + '"]').data('type', newType).attr('data-type', newType);
							loadProperties( entryId, newType);
						}
						else{
							alert("Er is iets mis gegaan! Vernieuw de pagina.");
						}
					}
				});
			}
		});
		
		$(document).off('blur', '.entry-name').on('blur', '.entry-name', function () {
			const entryId = $(this).data('entry-id');
			const newEntryName = $(this).text().trim();

			if (newEntryName !== "") {
				$.ajax({
					url: '<?=current_url()?>/update_entry_name',
					method: 'POST',
					data: {
						entry_id: entryId,
						entry_name: newEntryName
					},
					success: function (response) {
						if (response.status === 'success') {
							
						}
					}
				});
			}
		});		
		
		$(document).on('click', '.add-entry', function () {
			const newEntryName = $(this).siblings('#new-entry-name').val().trim();
			
			if (newEntryName !== "") {
				$.ajax({
					url: '<?=current_url()?>/add_entry',
					method: 'POST',
					data: {
						entry_name: newEntryName,
						case_id: <?=$case['id']?>,
					},
					success: function (response) {
						if (response.status === 'success') {
							$('.grid-container').append(response.html);
						}
					}
				});
			}
		});

		$(document).on('click', '.delete-entry', function () {
			const confirmation = confirm("Are you sure you want to delete this entry?");
			const entryId = $(this).closest('.entry').data('entry-id');

			if (confirmation) {
				$.ajax({
					url: '<?=current_url()?>/delete_entry',
					method: 'POST',
					data: {
						entry_id: entryId,
					},
					success: function (response) {
						if (response.status === 'success') {
							$(this).closest('.entry').remove();
						}
					}.bind(this)
				});
			}
		});
		
		/* 
		PROPERTIES 
		*/
		$(document).on('click', '.toggle-properties', function () {
			const entryId = $(this).closest('.entry').data('entry-id');
			const entryType = $(this).closest('.entry').data('type');
			$(`#properties-list-${entryId}`).parent().toggle();

			if ($(`#properties-list-${entryId}`).children().length === 0) {
				loadProperties( entryId, entryType);
			}
		});
		
		$(document).on('click', '.add-property', function () {
			const entryId = $(this).data('entry-id');
			const entryType = $(this).closest('.entry').data('type');
			const propertyContent = $(`#new-property-${entryId}`).val();

			if (propertyContent.trim()) {
				$.ajax({
					url: '<?=current_url()?>/add_property',
					method: 'POST',
					data: {
						entry_id: entryId,
						property_content: propertyContent
					},
					success: function (response) {
						if (response.status === 'success') {
							loadProperties( entryId, entryType );
							$(`#new-property-${entryId}`).val('');
						}
					}
				});
			}
		});	

        function loadProperties( entryId, entryType ) {
			$.ajax({
				url: '<?=current_url()?>/get_properties/' + entryId,
				method: 'GET',
				success: function (response) {
					const propertyList = $(`#properties-list-${entryId}`);
					propertyList.empty(); 
					response.forEach(function (property) {
						if (entryType === "mcq")
						{
							propertyList.append(`
								<li data-property-id="${property.id}">
									<input type="text" class="edit-property" data-property-id="${property.id}" value="${property.content}">
									<button class="save-property" data-property-id="${property.id}">Save</button>
									<button class="delete-property" data-property-id="${property.id}">Delete</button>
								</li>
							`);
						}
						else if(entryType === "text_separator")
						{
							textareaId = "ckeditor_" + property.id;

							propertyList.append(`
								<li data-property-id="${property.id}">
									<textarea id="${textareaId}" class="edit-property" data-property-id="${property.id}">${property.content}</textarea>
									<button class="save-property" data-property-id="${property.id}">Save</button>
								</li>
							`);

							<?=$text_editor->assign_editor('"#" + textareaId')?>
						}
					});
					
					if (entryType !== "mcq"){
						return;
					}
					
					propertyList.sortable({
						cancel: ':input,button,[contenteditable]',
						update: function(event, ui) {
							let ids = propertyList.sortable("toArray", { attribute: 'data-property-id' });
							savePropertySortOrder( entryId, ids);
						}
					});
				}
			});
		}
		
		function savePropertySortOrder( entryId, ids ) {
			$.ajax({
				url: '<?=current_url()?>/properties_save_order',
				method: 'POST',
				data: { 
					entry_id: entryId, 
					sort_order: ids 
				},
				success: function(response) {
					/*if (response.status === 'success') {
						alert('Sort order saved successfully!');
					}*/
				}
			});
		}
		
		$(document).on('click', '.save-property', function () {
			const entryType = $(this).closest('.entry').data('type');
			const propertyId = $(this).data('property-id');
			let newPropertyContent = $(this).siblings('.edit-property').val();

			// For CKEDITOR
			if(entryType === "text_separator") {
				textareaId = "#ckeditor_" + propertyId;
				newPropertyContent = <?=$text_editor->get('textareaId')?>
			}

			if (newPropertyContent.trim()) {
				$.ajax({
					url: '<?=current_url()?>/update_property',
					method: 'POST',
					data: {
						property_id: propertyId,
						property_content: newPropertyContent
					},
					success: function (response) {
						if (response.status === 'success') {
							alert('Property updated successfully!');
						}
					}
				});
			}
		});

		$(document).on('click', '.delete-property', function () {
			const propertyId = $(this).data('property-id');
			const confirmation = confirm("Are you sure you want to delete this property?");

			if (confirmation) {
				$.ajax({
					url: '<?=current_url()?>/delete_property/' + propertyId,
					method: 'GET',
					success: function (response) {
						if (response.status === 'success') {
							$(this).closest('li').remove(); 
						}
					}.bind(this)
				});
			}
		});		
	});
</script>