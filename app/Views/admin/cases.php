<style>
        .case-container {
            box-sizing: border-box;
			display: grid;
			grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }
        .case-item {
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
		.case-item:not(.disabled) {
			box-shadow: 0px 2px 8px 1px #f1f1f1;
		}
			.case-item .details {
				display:flex;
				flex-direction: column;
				justify-content: center;
				height: 100%;
			}
				.case-item .details a {
					font-size: 20px;
					color: #000;
					text-decoration: none;
				}
				.case-item .details p {
					margin: 0;
				}
			.case-item #delete_case {
				position: absolute;
				right: 10px;
				bottom: 10px;
				cursor: pointer;
			}
			.case-item:not(:hover) #delete_case {
				display: none;
			}
			.case-item .sortable-handle {
				position: absolute;
				left: 10px;
				top: 10px;
				cursor: move;
			}
		.case-item.add {
			background:var(--button-background-color);
			opacity: 0.5;
		}
		.case-item.add:hover {
			opacity: 0.9;
		}
			.case-item.add button {
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
				.case-item.add button i {
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

<div class="case-container" id="cases">
    <?php foreach ($cases as $item) { ?>
        <div class="case-item" data-id="<?= $item['id'] ?>">
            <div class="sortable-handle">
				<i class="fa-solid fa-grip-vertical"></i>
			</div>
			<div class="details">
				<a href="<?=base_url(route_to('admin.case', $item['id']))?>"><?= $item['name'] ?></a>
				<p><?= esc($item['info']) ?></p>
			</div>
            <div id="delete_case" data-case-id="<?=$item['id']?>">
				<i class="fa-regular fa-trash-can"></i>
			</div>
        </div>
    <?php }; ?>

	<div class="case-item add disabled">
		<button id="add_case" >
			<i class="fa-solid fa-plus"></i>
		</button>
	</div>
</div>

<script>
	$(document).ready(function() {
		<?=updateCSRFMeta() // csrf helper ?>

		$("#cases").sortable({
			handle: '.sortable-handle',
			cancel: ':input,button,[contenteditable]', // not used.
			update: function(event, ui) {
				let ids = $("#cases").sortable("toArray", { attribute: 'data-id' });
				saveSortOrder(ids);
			},
			items: '.case-item:not(.disabled)',
			placeholder: 'case-item sortable-placeholder',
		}).disableSelection();

		function saveSortOrder(ids) {
			$.ajax({
				url: '<?= base_url(route_to('admin.cases.save_order')) ?>',
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

        $(document).on('click', '#delete_case', function ()
        {
            const case_id = $(this).data('case-id');
			const confirmation = confirm("Are you sure you want to remove this case");

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_case',
		            method: 'POST',
		            data: {
			            case_id: case_id,
						<?=setCSRFPostData()?>
		            },
		            success: function (response) {
						updateCSRFMeta(response);

			            if (response.status === 'success') {
                            $(this).closest('.case-item').remove();
			            }
		            }.bind(this)
	            });
            }
        });

	    $(document).on('click', '#add_case', function ()
        {
            $.ajax({
				url: '<?=current_url()?>/add_case',
		        method: 'POST',
		        data: {
					name: 'Casus',
					assignment_id: <?=$assignment['id']?>,
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