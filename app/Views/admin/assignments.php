<style>
        .assignments-container {
            box-sizing: border-box;
			display: grid;
			grid-template-columns: repeat(5, 1fr);
            gap: 15px;
			justify-content: flex-start;
        }
        .assignments-item {
			position:relative;
            box-sizing: border-box;
            flex-basis: calc(20% - 10px);
            height: 175px;
            background-color: #fff;
            padding: 10px;
            text-align: center;
            border: 1px solid #f1f1f1;
			border-radius: var(--secondary-border-radius);
            
        }
		.assignments-item:not(.disabled) {
			box-shadow: 0px 2px 8px 1px #f1f1f1;
		}
			.assignments-item .details {
				display:flex;
				flex-direction: column;
				justify-content: center;
				height: 100%;
			}
				.assignments-item .details a {
					font-size: 20px;
					color:#000;
					text-decoration: none;
				}	
				.assignments-item .details p {
					margin: 0;
				}
			.assignments-item #delete_assignment {
				position: absolute;
				right: 10px;
				bottom: 10px;
				cursor: pointer;
			}
			.assignments-item:not(:hover) #delete_assignment {
				display: none;
			}
			.assignments-item .sortable-handle {
				position: absolute;
				left: 10px;
				top: 10px;
				cursor: move;
			}
		.assignments-item.add_assignment {
			background:var(--button-background-color);
			opacity: 0.5;
		}
		.assignments-item.add_assignment:hover {
			opacity: 0.9;
		}
			.assignments-item.add_assignment button {
				all:unset;
				display: flex;
				width: 100%;
				flex-direction: column;
				align-items: center;
				justify-content: space-around;
				gap: 20px;
				height: 100%;
				cursor:pointer;
			}
				.assignments-item.add_assignment button i {
					font-size: 38px;
					width: 75px;
					height: 75px;
					text-align: center;
					line-height: 75px;
					border-radius: 100%;
					border: 2px solid var(--button-text-color);
					color: var(--button-text-color);
				}	
</style>
            
<div class="assignments-container" id="assignments">
    <?php foreach ($assignments as $item) { ?>
        <div class="assignments-item" data-id="<?= $item['id'] ?>">
            <div class="sortable-handle">
				<i class="fa-solid fa-grip-vertical"></i>
			</div>
			<div class="details">
				<a href="<?=base_url(route_to('admin.assignment', $item['id']))?>"><?= $item['name'] ?></a>
				<p><?= esc($item['info']) ?></p>
       		</div>
            <div id="delete_assignment" data-assignment-id="<?=$item['id']?>">
				<i class="fa-regular fa-trash-can"></i>
			</div>
        </div>
    <?php }; ?>
    
	<div class="assignments-item disabled add_assignment">
		<button id="add_assignment" >
			<i class="fa-solid fa-plus"></i>
		</button>
	</div>
</div>

<script>
	$(document).ready(function() {
		<?=updateCSRFMeta() // csrf helper ?>
		
		$("#assignments").sortable({
			handle: '.sortable-handle',
			cancel: ':input,button,[contenteditable]', // not used.
			update: function(event, ui) {
				let ids = $("#assignments").sortable("toArray", { attribute: 'data-id' });
				saveSortOrder(ids);
			},
			placeholder: 'assignments-item sortable-placeholder',
		}).disableSelection();
		
		function saveSortOrder(ids) {
			$.ajax({
				url: '<?= base_url(route_to('admin.assignments.save_order')) ?>',
				method: 'POST',
				data: { 
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
		
        $(document).on('click', '#delete_assignment', function () 
        {
            const assignment_id = $(this).data('assignment-id');
			const confirmation = confirm("Are you sure you want to remove this assignment");

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_assignment',
		            method: 'POST',
		            data: {
			            assignment_id: assignment_id,
						<?=setCSRFPostData()?>
		            },
		            success: function (response) {
						updateCSRFMeta(response);
						
			            if (response.status === 'success') {
                            $(this).closest('.assignments-item').remove();
			            }
		            }.bind(this)
	            });
            }
        });	
		
	    $(document).on('click', '#add_assignment', function () 
        {
            $.ajax({
				url: '<?=current_url()?>/add_assignment',
		        method: 'POST',
		        data: {
					name: 'Opdracht',
					meeting_id: <?=$current_meeting?>,
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