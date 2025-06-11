<table>
	<thead>
		<tr>
			<th>Bestand</th>
			<th width="150">Grootte</th>
			<th width="150">Geupload</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $uploads as $file):?>
			<tr>
				<td>
					<a href="<?=download_url( $file['path'] )?>" target="_blank"><?=$file['filename']?></a>
				</td>
				<td><?=readable_filesize($file['bytes'])?></td>
				<td><?=$file['created_at']?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>	