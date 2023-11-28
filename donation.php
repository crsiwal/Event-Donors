<!DOCTYPE html>
<html lang="en">

<head>
	<title>Donation Management Tool</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<?php
	$data = readEvents(BASEPATH . "csv/" . $dataFile . ".csv", $eventName);
	if (is_array($data) && isset($data["event"])) {
	?>
		<div class="container mt-3">
			<h2><?= $data["title"]; ?></h2>
			<p><?= $data["summery"]; ?></p>

			<h3>Top 5 users of this event</h3>
			<?= donorTable(topDonor($data["data"], 2)); ?>

			<h3>All user list</h3>
			<?= donorTable($data["data"]); ?>
		</div>
	<?php
	}
	?>
</body>

</html>