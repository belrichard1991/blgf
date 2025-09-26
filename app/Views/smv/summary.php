<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container my-4">
  <h2 class="fw-bold mb-3">Summary of Accomplishments – SMV Monitoring</h2>
  <p class="text-muted">Generated on <?= date('F j, Y') ?></p>

  <table class="table table-bordered table-striped">
    <thead class="table-light">
      <tr>
        <th>Location</th>
        <th>Type</th>
        <th>Posting Date</th>
        <th>Public Hearing</th>
        <th>Total Activities</th>
        <th>Completed</th>
        <th>Pending</th>
        <th>Completion %</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($summary as $row): ?>
        <tr>
          <td><?= esc($row['name']) ?></td>
          <td><?= esc($row['type']) ?></td>
          <td><?= $row['posting_date'] ? date('M d, Y', strtotime($row['posting_date'])) : '—' ?></td>
          <td><?= $row['hearing_date'] ? date('M d, Y', strtotime($row['hearing_date'])) : '—' ?></td>
          <td><?= $row['total'] ?></td>
          <td><?= $row['completed'] ?></td>
          <td><?= $row['pending'] ?></td>
          <td class="fw-bold text-danger"><?= $row['percentage'] ?>%</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <hr class="my-4">

<h4 class="fw-bold">Visual Summary</h4>
<canvas id="summaryChart" height="100"></canvas>

<script>
  const ctx = document.getElementById('summaryChart').getContext('2d');
  const summaryChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($chartData, 'label')) ?>,
      datasets: [{
        label: 'Completion %',
        data: <?= json_encode(array_column($chartData, 'value')) ?>,
        backgroundColor: '#198754'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          max: 100,
          ticks: {
            stepSize: 10
          },
          title: {
            display: true,
            text: 'Completion Percentage'
          }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => `${ctx.raw}% completed`
          }
        }
      }
    }
  });
</script>

</div>

<?= $this->endSection() ?>
