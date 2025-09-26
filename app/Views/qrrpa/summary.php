<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
$selectedYear = $_GET['year'] ?? array_key_first($summary);
$selectedQuarter = $_GET['quarter'] ?? 'ALL';
?>

<div class="container mt-4">
    <h2>QRRPA Monitoring Summary</h2>

    <!-- Filter Bar -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="yearSelect" class="form-label">Year</label>
            <select id="yearSelect" class="form-select">
                <?php foreach ($summary as $y => $_): ?>
                    <option value="<?= $y ?>" <?= $y == $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="quarterSelect" class="form-label">Quarter</label>
            <select id="quarterSelect" class="form-select">
                <option value="ALL" <?= $selectedQuarter === 'ALL' ? 'selected' : '' ?>>&lt;ALL&gt;</option>
                <?php foreach (range(1, 4) as $q): ?>
                    <option value="<?= $q ?>" <?= $selectedQuarter === (string)$q ? 'selected' : '' ?>>Q<?= $q ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <?php if (isset($summary[$selectedYear])): ?>
        <?php $yearData = $summary[$selectedYear]; ?>
        <?php foreach ($yearData as $quarter => $provinces): ?>
            <?php if ($selectedQuarter !== 'ALL' && $selectedQuarter != $quarter) continue; ?>

            <h4 class="mt-4">Year: <?= esc($selectedYear) ?> — Quarter: Q<?= esc($quarter) ?></h4>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5><?= $selectedQuarter === 'ALL' ? 'All Quarters' : "Q$quarter" ?></h5>
                <a href="<?= site_url("qrrpa/print?year=$selectedYear&quarter=$quarter") ?>"
                   class="btn btn-sm btn-outline-secondary" target="_blank">🖨️ Print Report</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Province</th>
                        <th>Evaluated</th>
                        <th>Total</th>
                        <th>Completion (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($provinces as $province => $data): ?>
                        <tr>
                            <td><?= esc($province) ?></td>
                            <td><?= $data['done'] ?? 0 ?></td>
                            <td><?= $data['total'] ?? 0 ?></td>
                            <td><?= $data['percent'] ?? 0 ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pie Charts -->
            <div class="d-flex flex-wrap gap-3 mb-5">
                <?php foreach ($provinces as $province => $data):
                    $chartId = 'chart_' . md5($selectedYear . $quarter . $province);
                    $done = $data['done'] ?? 0;
                    $total = $data['total'] ?? 0;
                    $remaining = max(0, $total - $done);
                ?>
                    <div style="width: 200px; text-align: center;">
                        <h6 style="font-size: 0.9rem;"><?= esc($province) ?></h6>
                        <canvas id="<?= $chartId ?>" width="200" height="200"></canvas>
                        <script>
                            const ctx<?= $chartId ?> = document.getElementById("<?= $chartId ?>").getContext("2d");
                            new Chart(ctx<?= $chartId ?>, {
                                type: "pie",
                                data: {
                                    labels: ["Evaluated", "Remaining"],
                                    datasets: [{
                                        data: [<?= $done ?>, <?= $remaining ?>],
                                        backgroundColor: ["#4caf50", "#f44336"]
                                    }]
                                },
                                options: {
                                    responsive: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: { boxWidth: 10, font: { size: 10 } }
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning">No data available for <?= esc($selectedYear) ?>.</div>
    <?php endif; ?>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Auto-submit filter -->
<script>
document.getElementById('yearSelect').addEventListener('change', reload);
document.getElementById('quarterSelect').addEventListener('change', reload);

function reload() {
    const y = document.getElementById('yearSelect').value;
    const q = document.getElementById('quarterSelect').value;
    window.location.search = `?year=${y}&quarter=${q}`;
}
</script>

<?= $this->endSection() ?>
