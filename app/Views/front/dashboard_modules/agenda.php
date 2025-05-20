<style>
	.agenda {
		display:flex;
		flex-direction: column;
		background: var(--accent-color) !important;
		color: var(--secondary-color);
	}
		.agenda .title {
			text-transform: uppercase;
			font-size: 24px;
			line-height: 35px;
			padding: 0 0 10px 10px;
			border-bottom: 1px solid #ccc;
			font-weight: 600;
		}
		.agenda .title span {
			font-weight: bold;
		}
		.agenda .items {
			display: flex;
			flex-direction: column;
			gap: 5px;
		}
		.agenda .items .item {
			border-bottom: 1px solid #ccc;
			padding:0 0 10px 10px;
		}
			.agenda .items .item .date {
				font-weight: bold;
				font-size: 14px;
				padding: 5px 0;
			}
			.agenda .items .item .details {
				display: flex;
				flex-direction: row;
				align-items: center;
				gap:25px;
			}
				.agenda .items .item .details .time {
					border-left: 4px solid var(--secondary-color);
					font-weight: bold;
					font-size: 10px;
					padding-left:10px;
				}
				.agenda .items .item .details .name {
					font-weight: bold;
					font-size: 12px;
				}
</style>

<div class="title"><span>Mijn</span> agenda</div>
<div class="items">
	<?php foreach($schedule as $item): ?>
		<div class="item">
			<div class="date"><?=$item['date_char']?></div>
			<div class="details">
				<div class="time"><?=$item['time']?></div>
				<div class="name"><?=$item['title']?></div>
			</div>
		</div>
	<?php endforeach ?>
</div>