<?php echo $header; ?>

<div class="breadcrumbs">
   	<ul>
		<li><span>Trainings</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">
            <button id="add_training">
                <i class="fa-solid fa-circle-plus"></i> Nieuwe training
            </button>
        <table>
            <thead>
                <tr>
                    <th>Training</th>
                    <th width="150">Leden</th>
                    <th width="150">Start</th>
                    <th width="150">Einde</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $trainings as $id => $item):?>
                    <tr>
                        <td><a href="<?=site_url()."admin/training/".$item['id']?>">Training #<?=($id+1)?></a></td>
                        <td><?=$item['member_count']?></td>
                        <td><?=$item['started']?></td>
                        <td><?=$item['stopped']?></td>
                        <td>
                            <button id="delete_training" data-training-id="<?=$item['id']?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<script {csp-script-nonce}>
    $(document).ready(function () {
        $(document).on('click', '#delete_training', function () 
        {
            const training_id = $(this).data('training-id');
			const confirmation = confirm("Are you sure you want to remove this training");

			if (confirmation) {
                $.ajax({
		            url: '<?=current_url()?>/delete_training',
		            method: 'POST',
		            data: {
			            training_id: training_id,
		            },
		            success: function (response) {
			            if (response.status === 'success') {
                            location.reload();
			            }
		            }
	            });
            }
        });

        $(document).on('click', '#add_training', function () 
        {
            $.ajax({
		        url: '<?=current_url()?>/add_training',
		        method: 'POST',
		        data: {
		        },
		        success: function (response) {
			        if (response.status === 'success') {
                        window.location = '<?=site_url()?>/admin/training/' + response.training_id;
			        }
		        }
	        });
        });
    });
</script>

<script {csp-script-nonce}>
    document.getElementById("menuToggle").addEventListener('click', toggleMenu);
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

</body>
</html>
