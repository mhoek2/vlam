<?php echo $header; ?>

<style>

</style>

<div class="breadcrumbs">
   	<ul>
		<li><a href="<?=base_url(route_to('admin.meetings'))?>">Meetings</a></li>
		<li><a href="<?=base_url(route_to('admin.meeting', $meeting['id']))?>"><?=$meeting['info']?></a></li>
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
				Custom Action<br>
				<small><em>Optional: If questions are blank, this will serve as the landing page. Otherwise, it will run after completion.</em></small>
			</label>

			<select name="sub_assignment" id="sub_assignment">
				<?php foreach ($sub_assignments as $id => $item): ?>
					<option value="<?=$item['name'] ?>" <?= $item['selected'] ? 'selected' : '' ?>><?= $item['name'] ?></option>
				<?php endforeach; ?>
			</select>
            <?= csrf_field() ?>

			<div class="actions">
				<button type="submit" class="button-primary button-action save">
					<div class="icon"></div>
					<div class="text">Opslaan</div>
				</button>
			</div>
					

			<div id="form_response_container" class="request-response"></div>	
				
        </form>
    </div>
</section>

<section class="main">
    <div class="content">
		<h2>Cases</h2>
		<?=$cases_view?>
    </div>
</section>

<section class="main">
    <div class="content">
		<h2>Assignment Entries</h2>

		<div class="grid-container" id="sortable">
			<?php foreach ($entries as $item) { ?>
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




<?=$text_editor->load_script()?>
<script {csp-script-nonce}>
    $(document).ready(function () {
		<?=$text_editor->init_script()?>
		<?=$text_editor->assign_editor('"#intro"')?>
		<?=$text_editor->assign_editor('"#outro"')?>

		const entry_group_to_type = <?=json_encode($entry_type_to_group)?>;

		<?=updateCSRFMeta() // csrf helper ?>

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

                const formData = $(this).serialize();

				button_handler( event.originalEvent.submitter, BUTTON_LOADING );
				$('#form_response_container').empty();
				
                $.ajax({
					url: '<?= base_url(route_to('admin.assignment.save', $assignment["id"])) ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							$('#form_response_container').append('<p class="success">' + response.message + '</p>');

							button_handler( event.originalEvent.submitter, BUTTON_SUCCESS );

							if ( response.redirect != null ) {
								window.location.href = response.redirect;
							}
							
							setTimeout(function(){
								$('#form_response_container').html("");
							}, 1250);
							return;
						}

						if (response.status === 'error' && response.errors) {
							$.each(response.errors, function(field, errorMessage) {
								$('#form_response_container').append('<p class="error">' + errorMessage + '</p>');
							});

							button_handler( event.originalEvent.submitter, BUTTON_ERROR );
						}
	
						checkSubAssignmentType();
                    },
                    error: function(xhr, status, error) {
                        // Handle any error
						$('#form_response_container').append('<p class="error">An error occurred while submitting the form.</p>');

						button_handler( event.originalEvent.submitter, BUTTON_ERROR );
                    }
                });
            });
        });

		/*
		ENTRIES
		*/
		$('#sortable').sortable({
			handle: '.sortable-handle',
			cancel: ':input,button,[contenteditable]',
			update: function(event, ui) {
				const ids = $('#sortable').sortable('toArray', { attribute: 'data-id' });
				saveEntrySortOrder(ids);
			},
			placeholder: 'entry grid-item sortable-placeholder',
		});

		function saveEntrySortOrder(ids) {
			$.ajax({
				url: '<?=current_url()?>/entries_save_order',
				method: 'POST',
				data: {
					sort_order: ids,
					<?=setCSRFPostData()?>
				},
				success: function(response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {

					}
				}
			});
		}

		$(document).on('change', '[id^="entry_optional_checkbox_"]', function() {
			const entryId = $(this).data('entry-id');
			const is_optional = $(this).prop('checked') ? 1 : 0;

			$.ajax({
				url: '<?= current_url() ?>/update_entry_optional',
				method: 'POST',
				data: {
					entry_id: entryId,
					value: is_optional,
					<?=setCSRFPostData()?>
				},
				success: function(response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
					}
					else{
						alert('Er is iets mis gegaan! Vernieuw de pagina.');
					}
				}
			});
		});

		$(document).on('change', '.entry-type-select', function() {
			const entryId = $(this).data('entry-id');
			const newType = $(this).val();

			$.ajax({
				url: '<?= current_url() ?>/update_entry_type',
				method: 'POST',
				data: {
					entry_id: entryId,
					type: newType,
					<?=setCSRFPostData()?>
				},
				success: function(response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
						$('.entry[data-entry-id="' + entryId + '"]').data('type', newType).attr('data-type', newType);
						loadProperties(entryId, newType);
					}
					else{
						alert('Er is iets mis gegaan! Vernieuw de pagina.');
					}
				}
			});
		});

		$(document).off('blur', '.entry-name').on('blur', '.entry-name', function () {
			const entryId = $(this).data('entry-id');
			const newEntryName = $(this).text().trim();

			if (newEntryName !== '') {
				$.ajax({
					url: '<?=current_url()?>/update_entry_name',
					method: 'POST',
					data: {
						entry_id: entryId,
						entry_name: newEntryName,
						<?=setCSRFPostData()?>
					},
					success: function (response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {

						}
					}
				});
			}
		});

		$(document).on('click', '.add-entry', function () {
			const newEntryName = $(this).siblings('#new-entry-name').val().trim();
			const newType = $(this).siblings('#new-entry-type').val();

			if (newEntryName !== '') {
				$.ajax({
					url: '<?=current_url()?>/add_entry',
					method: 'POST',
					data: {
						entry_name: newEntryName,
						entry_type: newType,
						assignment_id: <?=$assignment['id']?>,
						<?=setCSRFPostData()?>
					},
					success: function (response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							$('.grid-container').append(response.html);
						}
					}
				});
			}
		});

		$(document).on('click', '.delete-entry', function (event) {
			const confirmation = confirm('Are you sure you want to delete this entry?');
			const entryId = $(this).closest('.entry').data('entry-id');

			if (confirmation) {
				button_handler( event.currentTarget, BUTTON_LOADING );
				
				$.ajax({
					url: '<?=current_url()?>/delete_entry',
					method: 'POST',
					data: {
						entry_id: entryId,
						<?=setCSRFPostData()?>
					},
					success: function (response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							button_handler( event.currentTarget, BUTTON_SUCCESS );
							
							setTimeout( function(){
								$(this).closest('.entry').remove();							
							}.bind(this), 1250 );
						}
						else {
							button_handler( event.currentTarget, BUTTON_ERROR );
						}
					}.bind(this),
                    error: function(xhr, status, error) {
						button_handler( event.currentTarget, BUTTON_ERROR );
					}
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
				loadProperties(entryId, entryType);
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
						property_content: propertyContent,
						<?=setCSRFPostData()?>
					},
					success: function (response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							loadProperties(entryId, entryType);
							$(`#new-property-${entryId}`).val('');
						}
					}
				});
			}
		});

        function loadProperties(entryId, entryType) {
			$.ajax({
				url: '<?=current_url()?>/get_properties/' + entryId,
				method: 'GET',
				success: function (response) {
					const entryTypeGroup = entry_group_to_type[entryType];
					const propertyList = $(`#properties-list-${entryId}`);

					propertyList.empty();
					response.forEach(function (property) {
						//if (entryType.startsWith("mcq"))
						if (entryTypeGroup === 'mcq')
						{
							let placeholder_state = parseInt(property.placeholder) === 1 ? BUTTON_PLACEHOLDER_AC : BUTTON_PLACEHOLDER;
							
							propertyList.append(`
								<li data-property-id="${property.id}">
									<div class="handle">
										<i class="fa-solid fa-grip-vertical"></i>
									</div>
									<input type="text" id="mcq-property" class="edit-property" data-property-id="${property.id}" value="${property.content}">
									<button class="placeholder-property button-action ${placeholder_state}" data-property-id="${property.id}">
										<div class="icon"></div>
									</button>
									<button class="save-property button-action save" data-property-id="${property.id}">
										<div class="icon"></div>
									</button>
									<button class="delete-property button-action trash" data-property-id="${property.id}">
										<div class="icon"></div>
									</button>
								</li>
							`);
						}
						else if(entryType === 'text_separator')
						{
							const textareaId = 'ckeditor_' + property.id;

							propertyList.append(`
								<li data-property-id="${property.id}">
									<div class="handle">
										<i class="fa-solid fa-grip-vertical"></i>
									</div>
									<textarea id="${textareaId}" class="edit-property" data-property-id="${property.id}">${property.content}</textarea>
									<button class="save-property button-action save" data-property-id="${property.id}">
										<div class="icon"></div>
									</button>
								</li>
							`);

							<?=$text_editor->assign_editor('"#" + textareaId')?>
						}
						else if(entryType === 'video_youtube')
						{
							propertyList.append(`
								<li data-property-id="${property.id}">
									<div class="handle">
										<i class="fa-solid fa-grip-vertical"></i>
									</div>
									<label class="property-label">Youtube URL</label>
									<input type="text" id="mcq-property" class="edit-property" data-property-id="${property.id}" value="${property.content}" placeholder="video ID">
									<button class="save-property button-action save" data-property-id="${property.id}">
										<div class="icon"></div>
									</button>
								</li>
							`);
						}
					});

					//if (!entryType.startsWith("mcq") )
					if (entryTypeGroup !== 'mcq')
						return;

					propertyList.sortable({
						cancel: ':input,button,[contenteditable]',
						update: function(event, ui) {
							const ids = propertyList.sortable('toArray', { attribute: 'data-property-id' });
							savePropertySortOrder(entryId, ids);
						},
						placeholder: 'sortable-placeholder',
					});
				}
			});
		}

		function savePropertySortOrder(entryId, ids) {
			$.ajax({
				url: '<?=current_url()?>/properties_save_order',
				method: 'POST',
				data: {
					entry_id: entryId,
					sort_order: ids,
					<?=setCSRFPostData()?>
				},
				success: function(response) {
					updateCSRFMeta(response);

					/*if (response.status === 'success') {
						alert('Sort order saved successfully!');
					}*/
				}
			});
		}

		function extractYouTubeID(url) {
			var regex = /(?:youtube\.com\/.*v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/;
			var match = url.match(regex);
			return match ? match[1] : null;
		}
		
		$(document).off('blur', '#mcq-property').on('blur', '#mcq-property', function () {
			const entryType = $(this).closest('.entry').data('type');
			const propertyId = $(this).data('property-id');

			let newPropertyContent = $(this).val();

			// For CKEDITOR
			if (entryType === 'text_separator') {
				const textareaId = '#ckeditor_' + propertyId;
				newPropertyContent = <?=$text_editor->get('textareaId')?>
			}
				
			if (entryType === 'video_youtube') {
				const videoId = extractYouTubeID( $(this).val() );
				
				if (videoId)
					$(this).val( videoId );
			}

			console.log('entryType: ' + entryType);
			console.log('propertyId: ' + propertyId);
			console.log('ewPropertyContent: ' + newPropertyContent);
		});

		$(document).on('click', '.placeholder-property', function (event) {
			const entryId = $(this).closest('.entry').data('entry-id');
			const entryType = $(this).closest('.entry').data('type');
			const entryTypeGroup = entry_group_to_type[entryType];
			const propertyId = $(this).data('property-id');

			if (entryTypeGroup !== 'mcq')
					return;

			button_handler( event.currentTarget, BUTTON_LOADING );

			$.ajax({
				url: '<?=current_url()?>/mark_as_placeholder/' + propertyId,
				method: 'POST',
				data: {
					entry_id: entryId,
					property_id: propertyId,
					<?=setCSRFPostData()?>
				},
				success: function (response) {
					updateCSRFMeta(response);

					if (response.status === 'success') {
						button_handler( event.currentTarget, BUTTON_SUCCESS );

						setTimeout( function(){
							// set all to not marked state
							const propertyList = $(`#properties-list-${entryId}`);
							propertyList.find('.placeholder-property').removeClass(BUTTON_PLACEHOLDER_AC).addClass(BUTTON_PLACEHOLDER);

							// set to new state
							let placeholder_state = parseInt(response.placeholder) ? BUTTON_PLACEHOLDER_AC : BUTTON_PLACEHOLDER;
							button_handler( event.currentTarget, placeholder_state );
						}, 500 );
					}
					else {
						button_handler( event.currentTarget, BUTTON_ERROR );
					}
				},
				error: function(xhr, status, error) {
					button_handler( event.currentTarget, BUTTON_ERROR );
				}
			});
		});
			
		$(document).on('click', '.save-property', function (event) {
			const entryType = $(this).closest('.entry').data('type');
			const propertyId = $(this).data('property-id');
			let newPropertyContent = $(this).siblings('.edit-property').val();

			// For CKEDITOR
			if(entryType === 'text_separator') {
				const textareaId = '#ckeditor_' + propertyId;
				newPropertyContent = <?=$text_editor->get('textareaId')?>
			}
				
			if (entryType === 'video_youtube') {
				console.log(2);
			}
				
			if (newPropertyContent.trim()) {
				button_handler( event.currentTarget, BUTTON_LOADING );

				$.ajax({
					url: '<?=current_url()?>/update_property',
					method: 'POST',
					data: {
						property_id: propertyId,
						property_content: newPropertyContent,
						<?=setCSRFPostData()?>
					},
					success: function (response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							button_handler( event.currentTarget, BUTTON_SUCCESS );
							
							setTimeout( function(){
								// reset to save icon
								button_handler( event.currentTarget, BUTTON_SAVE );
							}, 500 );
						}
						else {
							button_handler( event.currentTarget, BUTTON_ERROR );
						}
					},
                    error: function(xhr, status, error) {
						button_handler( event.currentTarget, BUTTON_ERROR );
					}
				});
			}
		});

		$(document).on('click', '.delete-property', function (event) {
			const propertyId = $(this).data('property-id');
			const confirmation = confirm('Are you sure you want to delete this property?');

			if (confirmation) {
				button_handler( event.currentTarget, BUTTON_LOADING );
				
				$.ajax({
					url: '<?=current_url()?>/delete_property/' + propertyId,
					method: 'POST',
					data: {
						<?=setCSRFPostData()?>
					},
					success: function (response) {
						updateCSRFMeta(response);

						if (response.status === 'success') {
							button_handler( event.currentTarget, BUTTON_SUCCESS );
							
							setTimeout( function(){
								$(this).closest('li').remove();								
							}.bind(this), 1250 );
						}
						else {
							button_handler( event.currentTarget, BUTTON_ERROR );
						}
					}.bind(this),
                    error: function(xhr, status, error) {
						button_handler( event.currentTarget, BUTTON_ERROR );
					}
				});
			}
		});
	});
</script>

<?php echo $footer; ?>