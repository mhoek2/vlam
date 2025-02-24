<?php echo $header; ?>

<!-- CONTENT -->

<style>
    .case-entry {

    }

		.case-entry .properties-container {
			display: flex;
			flex-direction: row;
		}
	
			.case-entry .properties-container .properties 
			{
				margin:3em 0;
				display: flex;
				flex-direction: column;
			}

				.case-entry .properties-container .properties > div
				{
					margin:1em 0;
					padding:1em 1em;
					background:#fff;
					color:var(--secondary-color);
					border-radius:10px;
					font-weight: bold;
					cursor:pointer;
				}

				.case-entry .properties-container .properties > div.selected {
					background:var(--primary-color);
					color:#fff;
				}
	
			.case-entry .properties-aside {

			}
	
	.case-progress {
        display: flex;
        align-items: center;
        gap: 10px;
		justify-content: space-between;
		margin-top:3em;
	}
		.case-progress button {
		}
	
		.case-progress .indicator {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap:30px;
		}
			.case-progress .indicator > div {
				width:60px;
				height:60px;
				border-radius:100%;
				line-height: 60px;
				text-align: center;
				font-size:32px;
				font-weight: bold;
				background:#fff;
				color:var(--primary-color);
			}
			.case-progress .indicator > div.selected {
				background:var(--primary-color);
				color:#fff;
			}
</style>

<section class="main">
    <?=$sidebar?>

    <div class="content">
           
		<div class="case-entry">
			<?php if($entry['type'] == "text_separator"): ?>
				<?php foreach ($entry['properties'] as $property): ?>
					<?=$property['content']?>
				<?php endforeach ?>

			<?php elseif($entry['type'] == "mcq"): ?>
				<h2><?=$entry['name']?></h2>
				<div class="properties-container">
					<div class="properties">
						<?php foreach ($entry['properties'] as $property): ?>
							<div class="<?= $property['selected'] ? 'selected' : '' ?>" id="property" data-property-id="<?=$property['id']?>">
								<?=$property['content']?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="properties-aside">
					</div>
				</div>	
			<?php else: ?>
				<h3><?=$entry['name']?></h3>
			<?php endif ?>
		</div> 
       
        <div class="case-progress">
        
        	<a class="button" href="<?=$entry_prev_url?>"><i class="fa-solid fa-chevron-left"></i> Previous</a>
        	
        	<div class="indicator">
				<?php foreach ($entries as $i => $item): ?>
					<div class="<?= ($entry['id'] == $item['id']) ? 'selected' : '' ?>">
						<?=($i + 1)?>
					</div>
				<?php endforeach ?>
        	</div>
        	
         	<a class="button" href="<?=$entry_next_url?>">Next <i class="fa-solid fa-chevron-right"></i></a>
		</div>    
        
    </div>
</section>

<footer>
    <div class="environment">

        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>
</footer>

<script>
	$(document).ready(function() {
        $(document).ready(function () {
			
			$(document).on('click', '#property', function(){
				const propertyId = $(this).data('property-id');
				
                $.ajax({
                    url: '<?=current_url().'/save'?>',
                    type: 'POST',
                    data: {
						entry_id: <?=$entry['id']?>,
						property_id: propertyId
					},
                    success: function(response) {
						if (response.status === 'success') {
							$(this).siblings().removeClass('selected');
							$(this).addClass('selected');	
						}
                    }.bind(this),
                    error: function(xhr, status, error) {

                    }
                })
			});
			
            $('#assignment_form').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                console.log(formData);
                $.ajax({
                    url: '<?=current_url().'/save'?>',
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
    });
</script>

<script {csp-script-nonce}>
        // HEADER
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
