<html>
	<head>
		<link rel="stylesheet" href="/table.css">
	</head>
	<body>
		<table>
			<thead>
				<tr>
					<th></th>
					<th>Site</th>
					<th>Contest</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($contests as $contest): ?>
				<tr>
					<td><img src = "<?php print $contest['img_site']              ?>" width = 20 height = 20></td>
					<td><?php echo $contest['name_site']                          ?></td>
					<td><?php echo $contest['name_contest']                       ?></td>
					<td><?php echo date("M d Y H:i:s", $contest['date_start']);   ?></td>
					<td><?php echo date("M d Y H:i:s", $contest['date_end']);     ?></td>
					<td><?php echo $contest['description']                        ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>
