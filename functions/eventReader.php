<?php
function readEvents($csvFilePath, $eventName) {
	$eventIndex = eventColumn($eventName, $csvFilePath);
	if ($eventIndex) {
		$tmp = array_map('str_getcsv', file($csvFilePath));
		$data = array_combine(array_column($tmp, 0), array_column($tmp, $eventIndex));
		$event = array_shift($data);
		$title = array_shift($data);
		$summery = array_shift($data);
		$total = array_sum(array_values($data));
		return [
			"event" => $event,
			"title" => $title,
			"summery" => $summery,
			"total" => $total,
			"data" => $data,
		];
	}
	return false;
}

function topDonor($donors, $count = 5) {
	arsort($donors);
	return array_slice($donors, 0, $count, true);
}

function eventColumn($eventName, $csvFilePath) {
	// Check if the file exists
	if (!file_exists($csvFilePath)) {
		return false;
	}

	// Open the CSV file for reading
	$file = fopen($csvFilePath, 'r');

	// Read the header row to get column names
	$header = fgetcsv($file);

	// Find the index of the specified event column
	$eventIndex = array_search($eventName, $header);

	return $eventIndex > 1 ? $eventIndex : false;
}

function donorTable($donors) {
?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">S.N</th>
					<th scope="col">Name</th>
					<th scope="col">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$serial = 1;
				foreach ($donors as $person => $amount) {
				?>
					<tr>
						<th scope="row"><?= $serial++; ?></th>
						<td><?= $person; ?></td>
						<td><?= $amount; ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
<?php
}
