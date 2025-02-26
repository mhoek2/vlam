<?php echo $header; ?>

<div class="breadcrumbs">
   	<ul>
		<li><span>Meetings</span></li>
    </ul>
</div>

<section class="main">
    <div class="content">
        <ul>
        <?php foreach( $meetings as $item):?>
            <li><a href="<?=site_url()."admin/meeting/".$item['id']?>"><?=$item["name"]?>: <?=$item["info"]?></a></li>
        <?php endforeach?>
        </ul>
    </div>
</section>


<?php echo $footer; ?>