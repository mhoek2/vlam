<?php echo $header; ?>

<style>
	.grid-container {
		display: flex;
		flex-wrap: wrap;
		gap: 15px;
	}
		.grid-container .entry {
			position: relative;
			width: 100%;
			height: auto;
			background-color: #ffffff;
			text-align: center;
			border: 1px solid #f1f1f1;
			border-radius: var(--secondary-border-radius);
			box-shadow: 0px 2px 8px 1px #f1f1f1;
			opacity: 0.7;
		}
		.grid-container .entry:hover {
			opacity: 1.0;
		}
			.grid-container .entry.sortable-placeholder {
				min-height:100px;
			}
	
			.grid-container .entry .details  {
				display: flex;
				flex-direction: row;
			}
				.grid-container .entry .details .sortable-handle {
					font-size: 18px;
					width: 50px;
					background: #f7f8f9;
					display: flex;
					justify-content: center;
					align-items: center;
					cursor: move;
				}
				.grid-container .entry .details h3 {
					flex:1;
					text-align: left;
					margin-left: 20px;
				}
				.grid-container .entry .details select {
					border: 0;
					height: 20px;
					margin: auto 0;
					background:#fff;
					border-color:#fff;
				}
				.grid-container .entry .details .toggle-properties {
					all:unset;
					font-size: 18px;
					width: 50px;
					cursor:pointer;
					/*position:absolute;
					top:10px;
					right:10px;*/
				}
				.grid-container .entry .details .delete-entry {
					all:unset;
					font-size: 18px;
					width: 50px;
					cursor:pointer;
				}
				.grid-container .entry .details .delete-entry:hover {
					color:#EC1C5D;
				}
			.grid-container .entry .properties {

			}
				.grid-container .entry .properties ul[id^="properties-list"] {
					list-style: none;
					padding: 10px 10px 10px 50px;
					margin: 0;
				}
				.grid-container .entry .properties ul[id^="properties-list"] .sortable-placeholder {
					min-height:50px;
				}
				.grid-container .entry .properties ul[id^="properties-list"] li {
					display: flex;
					flex-direction: row;
					gap: 5px;
					margin:5px 0;
					background: #fff;
					padding: 3px;
					border: 1px solid #f1f1f1;
				}
					.grid-container .entry .properties ul[id^="properties-list"] li .handle {
						font-size: 18px;
						width: 50px;
						display: flex;
						justify-content: center;
						align-items: center;
						cursor: move;
					}
					.grid-container .entry .properties ul[id^="properties-list"] li .delete-property,
					.grid-container .entry .properties ul[id^="properties-list"] li .save-property {
						all:unset;
						font-size: 18px;
						width: 50px;
						cursor:pointer;
					}
					.grid-container .entry .properties ul[id^="properties-list"] li .delete-property:hover {
						color:#EC1C5D;
					}
					.grid-container .entry .properties ul[id^="properties-list"] li .save-property:hover {
						color:#1CEC81;
					}
					.grid-container .entry .properties ul[id^="properties-list"] li input {
						border: 0;
					}
	
			.grid-container .entry .properties-actions {
				display: flex;
				flex-direction: row;
				padding: 1em;
			}
				.grid-container .entry .properties-actions .add-property {
					all:unset;
					font-size: 18px;
					width: 50px;
					cursor:pointer;
				}
	
			.grid-container .entry[data-type="text_separator"] .properties-actions,
			.grid-container .entry[data-type="text_separator"] .handle {
				display:none !important;
			}
			.grid-container .entry[data-type="text_separator"] li {
				border:initial !important;
			}
	
			.grid-container .entry[data-type="text_input"] .properties-actions {
				display:none;
			}

			.grid-container .entry[data-type="text_separator"] {
				border-left:4px solid orange;
			}
			.grid-container.entry[data-type="text_input"] {
				border-left:4px solid purple;
			}
			.grid-container .entry[data-type^="mcq"] {
				border-left:4px solid cyan;
			}
	
	.entry-actions {
		display: flex;
		flex-direction: row;
		background:#fff;
		border-radius: var(--secondary-border-radius);
		overflow: hidden;
	}
		.entry-actions .add-entry:hover {
			background: var(--button-hover-color);
		}
		.entry-actions #new-entry-name {
			border-width: 0 1px 0 0;
			margin-right: 10px;
		}
		.entry-actions select {
			border: 0;
			height: 20px;
			margin: auto 0;
			background:#fff;
			border-color:#fff;
		}
</style>

<div class="breadcrumbs">
   	<ul>
		<li><a href="<?=base_url('admin/meetings')?>">Meetings</a></li>
		<li><a href="<?=base_url('admin/meeting/').$meeting['id']?>"><?=$meeting['info']?></a></li>
		<li><span><?=$assignment['name']?>: <?=$assignment['info']?></span></li>
	</ul>
</div>

<section class="main">
    <div class="content">
        <form id="edit_assignment" method="POST">
			<h2>Assignment</h2>
			
            <label>Name<label>
            <input type="text" name="name" value="<?=$assignment["name"]?>">
            
			<label>Info<label>
            <input type="text" name="info" value="<?=$assignment["info"]?>">

            <label>Intro<label>
            <textarea name="intro" id="intro"><?=$assignment["intro"]?></textarea>

			<div id="intro_container">
				<label>Outro<label>
				<textarea name="outro" id="outro"><?=$assignment["outro"]?></textarea>	
			</div>
				
			<label>
				Post tailor action<br>
				<small><em>If there are no entries, this will be the landing.</em></small>
			<label>
			
			<select name="sub_assignment" id="sub_assignment">
				<?php foreach ($sub_assignments as $id => $item): ?>
					<option value="<?=$item['name'] ?>" <?= $item['selected'] ? 'selected' : '' ?>><?= $item['name'] ?></option>
				<?php endforeach; ?>
			</select>
				
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
			
			<div class="actions">
				<button type="submit" class="button-primary">
					<i class="fa-regular fa-floppy-disk"></i>Opslaan
				</button>
			</div>
        </form>
    </div>
</section>

<section class="main">
    <div class="content">
		<h2>Entries</h2>
		
		<div class="grid-container" id="sortable">
			<?php foreach ($entries as $item) { ?>
				<?php $item['entry_type_group_counts'] = $entry_type_group_counts; ?>
				<?=view('admin/assignment_entry', $item);?>
			<?php }; ?>
		</div>
    
		<label>Toevoegen</label>
		<div class="entry-actions">
    		<input type="text" id="new-entry-name" placeholder="option">
			<select id="new-entry-type">
				<?php foreach($entry_types as $entry_type): ?>
					<option value="<?=$entry_type["type"]?>">
						<?=$entry_type['name']?>
					</option>
				<?php endforeach ?>
			</select>
    		<button class="add-entry button-primary">
				<i class="fa-solid fa-plus"></i> Toevoegen
			</button>
		</div>
    </div>
</section>


<section class="main">
    <div class="content">
		<h2>Cases</h2>
		<?=$cases_view?>
    </div>
</section>

<?=$text_editor->load_script()?>
<script {csp-script-nonce}>
    $(document).ready(function () {
		<?=$text_editor->init_script()?>
		<?=$text_editor->assign_editor('"#intro"')?>
		<?=$text_editor->assign_editor('"#outro"')?>

		const entry_group_to_type = <?=json_encode($entry_type_to_group)?>;
		
		/* 
		ASSIGNMENT
		*/
        $(document).ready(function () {
			
	        function checkSubAssignmentType() {
				const selectedValue = $('#sub_assignment').val();

				$('#intro_container').hide();
				
				if (selectedValue === 'OutroController') {
					$('#intro_container').show();
				}
			}
			
			checkSubAssignmentType();
			
            $('#edit_assignment').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?= site_url('admin/assignments/'.$assignment["id"].'/save') ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the response from the server
                        $('#responseMessage').html('<p>' + response.message + '</p>');
						checkSubAssignmentType();
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
			handle: '.sortable-handle',
			cancel: ':input,button,[contenteditable]',
			update: function(event, ui) {

				let ids = $("#sortable").sortable("toArray", { attribute: 'data-id' });
				saveEntrySortOrder(ids);
			},
			placeholder: 'entry grid-item sortable-placeholder',
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
			const newType = $(this).siblings('#new-entry-type').val();
			
			if (newEntryName !== "") {
				$.ajax({
					url: '<?=current_url()?>/add_entry',
					method: 'POST',
					data: {
						entry_name: newEntryName,
						entry_type: newType,
						assignment_id: <?=$assignment['id']?>,
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
					const entryTypeGroup = entry_group_to_type[entryType];
					const propertyList = $(`#properties-list-${entryId}`);
					
					propertyList.empty(); 
					response.forEach(function (property) {
						//if (entryType.startsWith("mcq"))
						if (entryTypeGroup === "mcq")
						{
							propertyList.append(`
								<li data-property-id="${property.id}">
									<div class="handle">
										<i class="fa-solid fa-grip-vertical"></i>
									</div>
									<input type="text" id="mcq-property" class="edit-property" data-property-id="${property.id}" value="${property.content}">
									<button class="save-property" data-property-id="${property.id}">
										<i class="fa-regular fa-floppy-disk"></i>
									</button>
									<button class="delete-property" data-property-id="${property.id}">
										<i class="fa-regular fa-trash-can"></i>
									</button>
								</li>
							`);
						}
						else if(entryType === "text_separator")
						{
							let textareaId = "ckeditor_" + property.id;

							propertyList.append(`
								<li data-property-id="${property.id}">
									<div class="handle">
										<i class="fa-solid fa-grip-vertical"></i>
									</div>
									<textarea id="${textareaId}" class="edit-property" data-property-id="${property.id}">${property.content}</textarea>
									<button class="save-property" data-property-id="${property.id}">
										<i class="fa-regular fa-floppy-disk"></i>
									</button>
								</li>
							`);

							<?=$text_editor->assign_editor('"#" + textareaId')?>
						}
					});
					
					//if ( !entryType.startsWith("mcq") )
					if (entryTypeGroup !== "mcq")
						return;
					
					propertyList.sortable({
						cancel: ':input,button,[contenteditable]',
						update: function(event, ui) {
							let ids = propertyList.sortable("toArray", { attribute: 'data-property-id' });
							savePropertySortOrder( entryId, ids);
						},
						placeholder: 'sortable-placeholder',
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
		
		
		
		$(document).off('blur', '#mcq-property').on('blur', '#mcq-property', function () {
			const entryType = $(this).closest('.entry').data('type');
			const propertyId = $(this).data('property-id');
			
			let newPropertyContent = $(this).val();

			// For CKEDITOR
			if(entryType === "text_separator") {
				let textareaId = "#ckeditor_" + propertyId;
				newPropertyContent = <?=$text_editor->get('textareaId')?>
			}
				
			console.log( 'entryType: ' + entryType);
			console.log( 'propertyId: ' + propertyId);
			console.log( 'ewPropertyContent: ' + newPropertyContent);
		});
			
		$(document).on('click', '.save-property', function () {
			const entryType = $(this).closest('.entry').data('type');
			const propertyId = $(this).data('property-id');
			let newPropertyContent = $(this).siblings('.edit-property').val();

			// For CKEDITOR
			if(entryType === "text_separator") {
				let textareaId = "#ckeditor_" + propertyId;
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
				
<?php echo $footer; ?>