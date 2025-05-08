<?php echo $header; ?>

<style>
	.container {
		display:flex;
		flex-direction: row;
		gap:20px;
	}
		.container .block {
			background-color: #fff;
			border-radius: var(--secondary-border-radius);
			padding: 10px 15px;
			width: 100%;
			max-width:450px;
			height: max-content;
		}
		.container > section:nth-child(2) {
			flex:2
		}

	<?php if(! empty($selected_user) ): ?>
		.edit-user-info {
			display: flex;
			align-items: center;
			padding: 10px 15px;
			margin: 10px 0;
			width: 100%;
		}
			.edit-user-info .profile {
				width: 150px;
				height: 150px;
				border-radius: 50%;
				background-color: var(--header-user-dropdown-button-background);
				color: white;
				display: flex;
				justify-content: center;
				align-items: center;
				font-size: 4em;
				font-weight: bold;
				margin-right: 15px;
			}
			.edit-user-info .meta {
				display: flex;
				flex-direction: column;
			}
				.edit-user-info .meta span {
					color: #333;
					font-size: 14px;
					margin-bottom: 5px;
				}
				.edit-user-info .meta span.name {
					font-weight:600;
				}
				.edit-user-info .meta span.email {
					font-size: 13px;
					color: #555;
				}

	@media (max-width: 1199px) {
		.container {
			display:block;
		}
	}
	<?php endif ?>
</style>

<div class="breadcrumbs">
   	<ul>
		<li><a href="<?=base_url(route_to('admin.users'))?>">Gebruikers</a></li>
		<li><a href="<?=base_url(route_to('admin.user', $selected_user['id']))?>"><?=$selected_user['fullname']?></a></li>
		<li><span>Inzicht training</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">

		<div class="container">
			<section class="block">
					<div class="edit-user-info">
						<div class="profile"><?=$selected_user['shortname']?></div>
						<div class="meta">
							<span class="name"><?=$selected_user['fullname']?></span>
							<span><?=$selected_user['username']?></span>
							<span class="email"><?=$selected_user['email']?></span>
						</div>
					</div>
			</section>
		</div>
    </div>
</section>

<script {csp-script-nonce}>
    $(document).ready(function () {

		<?=updateCSRFMeta() // csrf helper ?>

    });
</script>

<?php echo $footer; ?>