<style>
        .grid-container {
            box-sizing: border-box;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .grid-item {
            box-sizing: border-box;
            flex-basis: calc(20% - 10px);
            height: 175px;
            background-color: lightgray;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            cursor: move;
        }
        .grid-item p {
            margin: 0;
        }	
</style>

<div class="grid-container" id="sortable">
    <?php foreach ($assignments as $item) { ?>
        <div class="grid-item" data-id="<?= $item['id'] ?>">
            <a href="<?=base_url('admin/assignments/')?><?=$item['id']?>"><?= $item['name'] ?></a>
            <p><?= esc($item['info']) ?></p>
        </div>
    <?php }; ?>
</div>

<script>
	$(document).ready(function() {

		$("#sortable").sortable({
			update: function(event, ui) {
				let ids = $("#sortable").sortable("toArray", { attribute: 'data-id' });
				saveSortOrder(ids);
			}
		});
		
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
	});		
</script>