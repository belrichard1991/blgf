<!DOCTYPE html>
<html>
<head>
    <title>QRRPA Report - <?= $year ?> Q<?= $quarter ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background: #f0f0f0; }
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
    <h2>QRRPA Monitoring Summary<br><?= $year ?> - Quarter <?= $quarter ?></h2>
    
    <button onclick="window.print()">🖨️ Print</button>

    <table>
        <thead>
            <tr>
                <th>Province</th>
                <th>Evaluated</th>
                <th>Total</th>
                <th>Progress (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stats as $province => $data): ?>
                <tr>
                    <td><?= esc($province) ?></td>
                    <td><?= $data['done'] ?></td>
                    <td><?= $data['total'] ?></td>
                    <td><?= $data['percent'] ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
