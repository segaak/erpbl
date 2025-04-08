<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="..style.css">

	<title>Dashboard</title>


</head>

<body>


	<!-- SIDEBAR -->
	<?php include(__DIR__ . "/../parts/sidebar.php"); ?>

	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include(__DIR__ . "/../parts/navbar.php"); ?>

		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
				</div>
			</div>
			<ul class="box-info">
				<li>
					<div class="card-box">
						<div class="card">
							<div class="card-content">
								<div class="text">
									<p class="card-label">Total Pelanggan</p>
									<h2 class="card-number">100</h2>
								</div>
								<div class="card-icon">
									<i class='bx bxs-user-account'></i>
								</div>
							</div>
							<div class="card-footer">
								<i class='bx bx-trending-up'></i>
								<span class="percent">1.5%</span>
								<span class="status">Bertambah dari kemarin</span>
							</div>
						</div>
					</div>
				</li>
				<div class="card-box">
					<div class="card">
						<div class="card-content">
							<div class="text">
								<p class="card-label">Total Pelanggan</p>
								<h2 class="card-number">100</h2>
							</div>
							<div class="card-icon">
								<i class='bx bxs-user-account'></i>
							</div>
						</div>
						<div class="card-footer">
							<i class='bx bx-trending-up'></i>
							<span class="percent">1.5%</span>
							<span class="status">Bertambah dari kemarin</span>
						</div>
					</div>
				</div>
				</li>
				<div class="card-box">
					<div class="card">
						<div class="card-content">
							<div class="text">
								<p class="card-label">Total Pelanggan</p>
								<h2 class="card-number">100</h2>
							</div>
							<div class="card-icon">
								<i class='bx bxs-user-account'></i>
							</div>
						</div>
						<div class="card-footer">
							<i class='bx bx-trending-up'></i>
							<span class="percent">1.5%</span>
							<span class="status">Bertambah dari kemarin</span>
						</div>
					</div>
				</div>
				</li>
				<div class="card-box">
					<div class="card">
						<div class="card-content">
							<div class="text">
								<p class="card-label">Total Pelanggan</p>
								<h2 class="card-number">100</h2>
							</div>
							<div class="card-icon">
								<i class='bx bxs-user-account'></i>
							</div>
						</div>
						<div class="card-footer">
							<i class='bx bx-trending-up'></i>
							<span class="percent">1.5%</span>
							<span class="status">Bertambah dari kemarin</span>
						</div>
					</div>
				</div>
				</li>
			</ul>
			<div class="chart-card">
				<div class="chart-header">
					<h3>Detail Penjualan</h3>
					<select>
						<option>Maret</option>
						<option>April</option>
						<option>Mei</option>
					</select>
				</div>
				<canvas id="salesChart" height="100"></canvas>
			</div>


		</main>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="../script.js"></script>
	<script>
		const ctx = document.getElementById('salesChart').getContext('2d');

		new Chart(ctx, {
			type: 'line',
			data: {
				labels: ['100k', '200k', '300k', '400k', '500k', '600k', '700k', '800k', '900k', '1000k', '1100k', '1200k'],
				datasets: [{
					data: [22, 45, 38, 90, 47, 55, 22, 40, 78, 70, 65, 60],
					borderColor: '#3b82f6',
					backgroundColor: 'rgba(59, 130, 246, 0.1)',
					fill: true,
					tension: 0, // bikin patah-patah
					pointBackgroundColor: '#3b82f6',
					pointRadius: 4,
					pointHoverRadius: 6,
					pointBorderWidth: 2,
					borderWidth: 2,
				}]
			},
			options: {
				responsive: true,
				plugins: {
					tooltip: {
						callbacks: {
							label: function(context) {
								return `Rp ${context.raw.toLocaleString('id-ID')}`;
							}
						},
						backgroundColor: '#111827',
						titleColor: '#fff',
						bodyColor: '#fff',
					},
					legend: {
						display: false
					}
				},
				scales: {
					y: {
						min: 0,
						max: 100,
						ticks: {
							callback: function(value) {
								return value + '%';
							}
						},
						grid: {
							color: '#e5e7eb'
						}
					},
					x: {
						grid: {
							display: false
						}
					}
				}
			}
		});
	</script>
</body>

</html>