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
			background:#fff;
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
	<?php endif ?>
	
	@media (max-width: 1199px) {
		.container {
			display:block;
		}
	}
	
	.container.insight {
		
	}
		/* collapsing tree */ 
		.container.insight .tree {
			padding:0;
			background: var(--sidebar-background);
			width: 400px;
			border-radius: var(--primary-border-radius);
		}
	
		.container.insight .tree * {
			box-sizing: border-box
		}
	
		.container.insight .tree [type="checkbox"] {
			display: none;
		}
	
		/* hide nested items */
		.container.insight .tree [type="checkbox"] + .header + .sub,
		.container.insight .tree [type="checkbox"] + .header + ul.sub {
			display: none;
		}

		/* show nested items when checked */
		.container.insight .tree [type="checkbox"]:checked + .header + .sub,
		.container.insight .tree [type="checkbox"]:checked + .header + ul.sub {
			display: block;
		}
			.container.insight .tree .tree-group {
				position: relative;
				margin: 10px 20px;
			}
			.container.insight .tree .tree-group .header {
				cursor: pointer;
				font-weight: bold;
				padding: 5px;
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				align-items: center;
				gap: 10px;
			}
			.container.insight .tree .tree-group:not(.) .header {
				cursor: pointer;
				font-weight: bold;
				padding: 5px;
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				align-items: center;
				gap: 10px;
			}
			.container.insight .tree .tree-group:not(.meeting) .header:hover {
				background: rgba( 0, 0, 0, 0.08 );
			}
				.container.insight .tree .tree-group.meeting > .header {
					background: var(--sidebar-meeting-bg);
					padding: 10px 15px 10px 10px !important;
					border-radius: 10px;
				}
				.container.insight .tree .tree-group.meeting > .header > div  {
					display: flex;
					align-items: center;
					justify-content: center;
					gap: 15px;
				}
				.container.insight .tree .tree-group.meeting > .header > div > .name  {
					display: flex;
					justify-content: center;
					align-items: center;
					min-width: 30px;
					height: 30px;
					border-radius: 100%;
					border: 1px solid #f1f1f1;
					color: var(--primary-color);
					background: #fff;
					text-align: center;
					font-family: "Saira Stencil One", sans-serif;
					font-weight: 800;
					font-style: normal;
					font-size: 16px;
				}

			.container.insight .tree .tree-group .header .title {
				color: #fff;
				font-size: 14px;
				font-weight: 500;
				width: 100%;
			}
			.container.insight .tree .tree-group .header .info {
				color: #fff;
				font-size: 14px;
			}
			.container.insight .tree .tree-group .header label {
				margin:0;
			}
			.container.insight .tree .tree-group .header label::after {
				font-family: "Font Awesome 6 Free";
				font-weight: 900;
				font-size: 14px;
				color:#fff;
				width: 25px;
				height: 25px;
				line-height: 25px;
				text-align: center;
				cursor:pointer;
			}
			.container.insight .tree [type="checkbox"] + .header label::after {
				content: "\f078";
			}
			.container.insight .tree [type="checkbox"]:checked + .header label::after {
				content: "\f077";
			}

			.container.insight .tree .tree-group.cases::before {
				content: '';
				position: absolute;
				left: -15px;
				top: 0;
				width: 2px;
				height:100%;
				background: var(--sidebar-meeting-bg);
			}
			.container.insight .tree .tree-group.cases .title {
				font-size:12px;
			}
	
	/* result */
	.container.insight .result {
		background: #fff;
	}
	
	.container.insight .result .selected {
		font-weight: bold;
		color: var(--primary-color);
	}
	
	.container.insight .result .entry {
		
	}
	
	.container.insight .result .entry .properties {
		display:flex;
		flex-direction: column;
		gap:5px;
	    width: fit-content;
	}
	.container.insight .result .entry .properties > div {
		position: relative;
	}
	.container.insight .result .entry .properties > div.selected {
	
	}
	.container.insight .result .entry .properties > div::before {
		font-family: "Font Awesome 6 Free";
		font-weight: 900;
		font-size: 14px;
		color:#fff;
		width: 25px;
		height: 25px;
		line-height: 25px;
		text-align: center;
		cursor:pointer;
	}
	.container.insight .result .entry .properties > div::before {
		content: '\f0c8';
		color: #f1f1f1;
		margin-right: 10px;
	}
	.container.insight .result .entry .properties > div.selected::before {
		content: '\f14a';
		color: var(--primary-color);
	}
	.container.insight .result .entry .properties,
	.container.insight .result .entry .value {
		margin-left:20px;
	}
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
		
		<div class="container insight">
			<section class="tree">
				<div class="edit-user-info">
					<div class="profile"><?=$selected_user['shortname']?></div>
					<div class="meta">
						<span class="name"><?=$selected_user['fullname']?></span>
						<span><?=$selected_user['username']?></span>
						<span class="email"><?=$selected_user['email']?></span>
					</div>
				</div>
				
				<div class="program">
					<?php foreach ( $training_tree as $meeting_id => $meeting ) : ?>
						<div class="tree-group meeting">
							<input type="checkbox" id="meeting-<?=$meeting_id?>" class="toggle">
							<label class="header" for="meeting-<?=$meeting_id?>">
								<div data-meeting-id='<?=$meeting_id?>'>
									<span class="name"><?=$meeting['name']?></span>
									<span class="info"><?=$meeting['info']?></span>
								</div>
								<label for="meeting-<?=$meeting_id?>"></label>
							</label>

							<div class="tree-group sub">
								<?php foreach ($meeting['assignments'] as $assignment_id => $assignment) : ?>
									<div class="assignment">
										<input type="checkbox" id="assignment-<?=$assignment_id?>" class="toggle">
										<div class="header">
											<div class="title" data-assignment-id='<?=$assignment_id?>'><?=$assignment['assignment']?></div>
											<label for="assignment-<?=$assignment_id?>"></label>
										</div>

										<?php if (!empty($assignment['cases'])) : ?>
											<div class="tree-group sub cases">
												<?php foreach ($assignment['cases'] as $case_id => $case) : ?>
													<div class="case">
														<div class="header">
															<div class="title" data-case-id='<?=$case_id?>'><?=$case?></div>
														</div>
													</div>	
												<?php endforeach ?>
											</div>
										<?php endif ?>
									</div>
								<?php endforeach ?>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</section>
			
			<section class="result"></section>
		</div>
    </div>
</section>

<script {csp-script-nonce}>
    $(document).ready(function () {

		<?=updateCSRFMeta() // csrf helper ?>

		function set_result( result )
		{
			$('section.result').html( result );
		}
		
		function get_result( meeting_id, assignment_id, case_id )
		{
			$.ajax({
				url: '<?=base_url(route_to('admin.user.insight_result', $selected_user['id']))?>',
				type: 'POST',
				data: {
					'assignment_id':	assignment_id,
					'case_id':			case_id,
					<?=setCSRFPostData()?>
				},
				success: function(response) {
					updateCSRFMeta(response);
					
					if ( typeof response.html !== 'undefined') {
						set_result( response.html );
					}
				}
			});
		}
		
		$(document).on('click', '[data-case-id]', function( e )
		{
			e.stopPropagation();
			
			let case_id = $(this).attr('data-case-id');
			let assignment_id = $(this).closest('.assignment').find('[data-assignment-id]').attr('data-assignment-id');
			let meeting_id = $(this).closest('.meeting').find('[data-meeting-id]').attr('data-meeting-id');

			get_result( meeting_id, assignment_id, case_id);
		});
		
		$(document).on('click', '[data-assignment-id]', function( e ) 
		{
			e.stopPropagation();
			if (e.currentTarget !== this) return;

			let case_id = null;
			let assignment_id = $(this).attr('data-assignment-id');
			let meeting_id = $(this).closest('.meeting').find('[data-meeting-id]').attr('data-meeting-id');
			
			get_result( meeting_id, assignment_id, case_id );
		});
		
		
    });
</script>

<?php echo $footer; ?>