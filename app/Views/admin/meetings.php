<?php echo $header; ?>

<style>
    .meetings {
		box-sizing: border-box;
		display: grid;
		grid-template-columns: repeat(3, 1fr);
        gap: 15px;
		justify-content: flex-start;
        padding: 0;
        list-style: none;
    }

		.meetings li {
			background: white;
			border-radius: var(--secondary-border-radius);
			box-shadow: 0px 2px 8px 1px #f1f1f1;
			transition: transform 0.2s, box-shadow 0.2s;
			overflow: hidden;
			display: flex;
			align-items: center;
		}

		.meetings li:hover {
			box-shadow: 0px 6px 12px 1px #f1f1f1;
		}

			.meetings li a {
				display: flex;
				align-items: center;
				text-decoration: none;
				color: black;
				width: 100%;
				padding: 15px;
			}

				.meetings li a .name {
					width: 40px;
					height: 40px;
					background: var(--button-background-color);
					color: var(--button-text-color);
					font-size: 18px;
					font-weight: bold;
					border-radius: 50%;
					display: flex;
					justify-content: center;
					align-items: center;
					margin-right: 15px;
					flex-shrink: 0;
				}

				.meetings li a .info {
					font-size: 18px;
					color: #333;
				}
</style>

<div class="breadcrumbs">
   	<ul>
		<li><span>Meetings</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">
        <ul class="meetings">
        <?php foreach( $meetings as $item):?>
            <li>
            	<a href="<?=base_url(route_to('admin.meeting', $item['id'] ))?>">
            		<div class="name"><?=$item["name"]?></div>
            		<div class="info"><?=$item["info"]?></div>
            	</a>
            </li>
        <?php endforeach?>
        </ul>
    </div>
</section>


<?php echo $footer; ?>