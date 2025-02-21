<style>
        .assignments-container {
            box-sizing: border-box;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .assignments-item {
            box-sizing: border-box;
            flex-basis: calc(20% - 10px);
            height: 175px;
            background-color: lightgray;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: move;
        }
        .assignments-item p {
            margin: 0;
        }	
</style>

<button id="add_assignment">
	<i class="fa-solid fa-circle-plus"></i> Add Assignment
</button>
            
<div class="assignments-container" id="assignments">
    <?php foreach ($assignments as $item) { ?>
        <div class="assignments-item" data-id="<?= $item['id'] ?>">
            <a href="<?=base_url('admin/assignments/')?><?=$item['id']?>"><?= $item['name'] ?></a>
            <p><?= esc($item['info']) ?></p>
            <div id="delete_assignment" data-assignment-id="<?=$item['id']?>">Delete</div>
        </div>
    <?php }; ?>
</div>

<script>
	$(document).ready(function() {

		$("#assignments").sortable({
			update: function(event, ui) {
				let ids = $("#assignments").sortable("toArray", { attribute: 'data-id' });
				saveSortOrder(ids);
			},
			placeholder: 'assignments-item sortable-placeholder',
		}).disableSelection();
		
		function saveSortOrder(ids) {
			$.ajax({
				url: '<?= base_url('admin/assignments/assignments_save_order') ?>',
				method: 'POST',
				data: { sort_order: ids },
				success: function(response) {
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
		            },
		            success: function (response) {
			            if (response.status === 'success') {
                            //location.reload();
			            }
		            }
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
					meeting_id: <?=$current_meeting?>
		        },
		        success: function (response) {
			        if (response.status === 'success') {
                        window.location = '<?=site_url()?>/admin/assignments/' + response.assignment_id;
			        }
		        }
	        });
        });		
		
	});		
</script>