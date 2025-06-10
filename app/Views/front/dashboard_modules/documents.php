<style>
	.documents {
		display:flex;
		flex-direction: column;
		background: var(--accent-color) !important;
		color: var(--secondary-color);
	}
		.documents .title {
			text-transform: uppercase;
			font-size: 24px;
			line-height: 35px;
			padding: 0 0 10px 10px;
			border-bottom: 1px solid #ccc;
			font-weight: 600;
		}
	
		.documents .items {
			display: flex;
			flex-direction: column;
			gap: 5px;
		}
		.documents .items .item {
			display: flex;
			flex-direction: row;
			gap:10px;
			border-bottom: 1px solid #ccc;
			padding-left: 10px;
		}
			.documents .items .item .icon {
				font-weight: bold;
				font-size: 14px;
				padding: 5px 0;
			}
			.documents .items .item .details {
				display: flex;
				flex-direction: row;
				align-items: center;
				gap:25px;
			}
</style>

<div class="title">Documenten</div>
<div class="items">
	<?php foreach($documents as $file): ?>
		<a class="item" href="<?=base_url(route_to('front.download', $file['path']))?>">
			<div class="icon">
				<i class="fa-solid fa-paperclip"></i>
			</div>
			<div class="details"><?=$file['filename']?></div>
		</a>
	<?php endforeach ?>
</div>