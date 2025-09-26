<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2>Dashboard</h2>

  <!-- Cards -->
  <div class="row mb-4">
    <?php foreach ($provinceCounts as $item): ?>
      <div class="col-md-3 mb-2">
        <div class="card text-white bg-primary h-100">
          <div class="card-body">
            <h5 class="card-title"><?= esc($item['province']) ?></h5>
            <p class="card-text"><?= esc($item['total']) ?> Employees</p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Charts Row -->
  <div class="row mb-4">
    <!-- Province Chart -->
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-header">Employees per Province (Chart)</div>
        <div class="card-body">
          <canvas id="provinceChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Plantilla Position Chart -->
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-header">Employees per Plantilla Position</div>
        <div class="card-body">
          <canvas id="positionChart"></canvas>
        </div>
      </div>
    </div>
  </div>
<!-- Gender Count Card -->
<div class="row mb-4">
  <div class="col-md-6">
    <div class="card text-white bg-info">
      <div class="card-body text-center">
        <h5 class="card-title">Gender Distribution</h5>
        <p class="card-text h4">
          <span class="badge bg-primary"><?= esc($genderCounts['M'] ?? 0) ?> Male</span>
          <span class="badge bg-danger ms-2"><?= esc($genderCounts['F'] ?? 0) ?> Female</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Gender Chart -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header">Gender Distribution (Chart)</div>
      <div class="card-body">
        <canvas id="genderChart"></canvas>
      </div>
    </div>
  </div>
</div>
  <!-- Plantilla Table -->
  <div class="card mb-4">
    <div class="card-header">Employees per Plantilla Position (Table)</div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Plantilla Position</th>
            <th>Total Employees</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($positionCounts as $pos): ?>
            <tr>
              <td><?= esc($pos['plantilla_position']) ?></td>
              <td><?= esc($pos['total']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const provinceLabels = <?= json_encode(array_column($provinceCounts, 'province')) ?>;
  const provinceData = <?= json_encode(array_column($provinceCounts, 'total')) ?>;

  const ctx1 = document.getElementById('provinceChart');
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: provinceLabels,
      datasets: [{
        label: 'Employees',
        data: provinceData,
        backgroundColor: '#0d6efd'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } }
    }
  });

  const posLabels = <?= json_encode(array_column($positionCounts, 'plantilla_position')) ?>;
  const posData = <?= json_encode(array_column($positionCounts, 'total')) ?>;

  const ctx2 = document.getElementById('positionChart');
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: posLabels,
      datasets: [{
        data: posData,
        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1']
      }]
    },
    options: {
      responsive: true
    }
  });
</script>
<script>
  const genderLabels = <?= json_encode(['Male', 'Female']) ?>;
  const genderData   = <?= json_encode([$genderCounts['M'] ?? 0, $genderCounts['F'] ?? 0]) ?>;

  const ctx3 = document.getElementById('genderChart');
  new Chart(ctx3, {
    type: 'doughnut',
    data: {
      labels: genderLabels,
      datasets: [{
        data: genderData,
        backgroundColor: ['#0d6efd', '#dc3545']
      }]
    },
    options: { responsive: true }
  });
</script>
<?= $this->endSection() ?>
