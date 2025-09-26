<!DOCTYPE html>
<html>
<head>
    <title>QRRPA Monitoring Report - <?= esc($year) ?> Q<?= esc($quarter) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 40px; }
        th, td { padding: 8px; border: 1px solid #ccc; }
        th { background: #f5f5f5; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨️ Print</button>
    <br><br>
</div>

<h1>QRRPA Monitoring Report</h1>
<p><strong>Year:</strong> <?= esc($year) ?> &nbsp;&nbsp; <strong>Quarter:</strong> Q<?= esc($quarter) ?></p>

<?php foreach ($grouped as $province => $munis): ?>
    <h2><?= esc($province) ?></h2>
    <table>
        <thead>
            <tr>
                <th>Municipality</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($munis as $m): ?>
                <tr>
                    <td><?= esc($m['name']) ?></td>
                    <td><?= $m['is_evaluated'] ? '✅ Evaluated' : '❌ Not Evaluated' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>

</body>
</html>
