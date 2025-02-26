<style>
        .case-container {
            box-sizing: border-box;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .case-item {
            box-sizing: border-box;
            flex-basis: calc(20% - 10px);
            height: 175px;
            background-color: lightgray;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: move;
        }
        .case-item p {
            margin: 0;
        }	
</style>

<button id="add_case">
	<i class="fa-solid fa-circle-plus"></i> Add Case
</button>
            
<div class="case-container" id="cases">
    <?php foreach ($cases as $item) { ?>
        <div class="case-item" data-id="<?= $item['id'] ?>">
            <a href="<?=base_url('admin/cases/')?><?=$item['id']?>"><?= $item['name'] ?></a>
            <p><?= esc($item['info']) ?></p>
            <div id="delete_case" data-case-id="<?=$item['id']?>">Delete</div>
        </div>
    <?php }; ?>
</div>

<script>
	$(document).ready(function() {

		$("#cases").sortable({
			update: function(event, ui) {
				let ids = $("#cases").sortable("toArray", { attribute: 'data-id' });
				saveSortOrder(ids);
			},
			placeholder: 'case-item sortable-placeholder',
		}).disableSelection();
		
		function saveSortOrder(ids) {
			$.ajax({
				url: '<?= base_url('admin/cases/cases_save_order') ?>',
				method: 'POST',
				data: { sort_order: ids },
				success: function(response) {
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
		            },
		            success: function (response) {
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
					assignment_id: <?=$assignment['id']?>
		        },
		        success: function (response) {
			        if (response.status === 'success') {
                        window.location = '<?=site_url()?>/admin/cases/' + response.case_id;
			        }
		        }
	        });
        });		
		
	});		
</script>