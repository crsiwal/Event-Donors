<?php
function readEvents($csvFilePath, $eventName) {
	$eventIndex = eventColumn($eventName, $csvFilePath);
	if ($eventIndex) {
		$tmp = array_map('str_getcsv', file($csvFilePath));
		$data = array_combine(array_column($tmp, 0), array_column($tmp, $eventIndex));
		$event = array_shift($data);
		$title = array_shift($data);
		$summery = array_shift($data);
		$targetAmount = array_shift($data);
		$paymentUrl = array_shift($data);
		$total = array_sum(array_values($data));
		arsort($data);
		return [
			"event" => $event,
			"title" => $title,
			"summery" => $summery,
			"targetAmount" => $targetAmount,
			"paymentUrl" => $paymentUrl,
			"total" => $total,
			"data" => $data,
		];
	}
	return false;
}

function percentage($estimatedAmount, $receivedAmount) {
	return ($estimatedAmount != 0) ? number_format(($receivedAmount / $estimatedAmount) * 100, 2) : 0;
}

function topDonor($donors, $count = 5) {
	// arsort($donors);
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
	$header = array_map('strtolower', fgetcsv($file));;

	// Find the index of the specified event column
	$eventIndex = array_search(strtolower($eventName), $header);

	return $eventIndex > 1 ? $eventIndex : false;
}

function donorTable($donors, $boldName = false) {
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
						<td class="<?= $boldName ? 'fw-bold' : ''; ?>"><?= $person; ?></td>
						<td><?= formatCurrency(empty($amount) ? 0 : $amount); ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
}

function donationButton($link) {
	if (!empty($link)) {
	?>
		<a class="btn btn-outline-danger fw-bold px-5 btn-lg" href="<?= $link; ?>">>> <?= _t("YOURCONTRIBUTE"); ?></a>
<?php
	}
}

function formatCurrency($amount) {
	return '₹ ' . str_replace(',', ',', number_format($amount, 2, '.', ','));
};
