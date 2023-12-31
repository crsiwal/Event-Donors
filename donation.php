<?php
$data = readEvents(BASEPATH . "csv/" . $dataFile . ".csv", $eventName);
if (is_array($data) && isset($data["event"])) {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title><?= $data["title"]; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>

	<body>
		<div class="container mt-3">
			<h1 class="fw-bold"><?= $data["title"]; ?></h1>
			<p class="h5 lh-lg mt-3"><?= $data["summery"]; ?></p>

			<div class="mt-4 text-center">
				<?= donationButton($data["paymentUrl"]); ?>
			</div>

			<!-- Total amount -->
			<h2 class="mt-5">
				<div class="fs-3"><?= _t("TARGETAMOUNT"); ?>:</div>
				<span class="fs-1"><?= formatCurrency($data["targetAmount"]); ?></span>
			</h2>

			<!-- Total amount -->
			<?php
			$receivedPercentage = percentage($data["targetAmount"], $data["total"]);
			?>
			<h2 class="mt-5">
				<div class="fs-3"><?= _t("TOTALAMOUNT"); ?>:</div>
				<span class="fs-1"><?= formatCurrency($data["total"]); ?></span>
				<span class="fs-3 text-<?= $receivedPercentage > 100 ? 'success' : 'danger'; ?>">(<?= $receivedPercentage; ?>%)</span>
			</h2>

			<!-- Top 5 donors of this event -->
			<h3 class="mt-5"><?= _t("TOPFIVEUSER"); ?></h3>
			<?php
			$topDonor = array_slice($data["data"], 0, 5, true);
			donorTable($topDonor, true);

			// Get the remaining donor list and show them
			$remainingDonor = array_slice($data["data"], 5);
			if (count($remainingDonor) > 0) {
			?>
				<h3 class="mt-3"><?= _t("DONORLIST"); ?></h3>
			<?php
				donorTable($remainingDonor);
			}
			?>
			<div class="my-4 text-center">
				<?= donationButton($data["paymentUrl"]); ?>
			</div>
		</div>
	</body>

	</html>
<?php
}
?>