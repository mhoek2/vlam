<?php echo $header; ?>

<div class="breadcrumbs">
   	<ul>
		<li><span>Gebruikers</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>Gebruiker</th>
                    <th width="150">Gebruikersgroep</th>
                    <th width="150">Training</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $users as $id => $item):?>
                    <tr>
                        <td><a href="<?=base_url(route_to('admin.user', $item['id']))?>"><?=$item['fullname']?></a></td>
                        <td><?=$item['group']?></td>
                        <td>
							<?php if ( !is_null($item['training_id'])): ?>
								<a href="<?=base_url(route_to('admin.training', $item['training_id']))?>"><?=$item['training_name']?></a>
							<?php endif ?>
						</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
		
		<div class="actions left">
            <a class="button-primary" href="<?=base_url(route_to('admin.user.new'))?>">
                <i class="fa-solid fa-circle-plus"></i> Nieuwe gebruiker
            </a>
		</div>
    </div>
</section>

<script {csp-script-nonce}>
    $(document).ready(function () {
    });
</script>

<?php echo $footer; ?>