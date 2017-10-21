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
				<div id = "tab_data">
				<?php foreach($contests as $contest): ?>
				<tr>
					<td><img src = "<?php print $contest['img_site']              ?>" width = 20 height = 20></td>
					<td><?php echo $contest['name_site']                          ?></td>
					<td><a href = <?php echo $contest['site']?>><?php echo $contest['name_contest']?></a></td>
					<td><?php echo date("M d Y H:i:s", $contest['date_start']);   ?></td>
					<td><?php echo $contest['date_end'] ? date("M d Y H:i:s", $contest['date_end']) : 'unknown';     ?></td>
					<td><?php echo $contest['description']                        ?></td>
				</tr>
				<?php endforeach; ?>
				</div>
			</tbody>
		</table>
        <script>
            fetch('/contests.php')
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                });
        </script>
	</body>
</html>
