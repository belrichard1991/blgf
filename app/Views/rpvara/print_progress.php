<!DOCTYPE html>
<html>
<head>
  <title>RPVARA Progress Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11pt;
      margin: 20px;
      color: #000;
    }

    h2, h3 {
      margin-bottom: 5px;
    }

    .meta {
      font-size: 10pt;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      border: 1px solid #000;
      padding: 6px;
      text-align: left;
    }

    th {
      background-color: #f0f0f0;
    }

    .section-title {
      background-color: #e0e0e0;
      font-weight: bold;
      text-transform: uppercase;
    }

    .footer {
      font-size: 9pt;
      text-align: right;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <h2>RPVARA Progress Report</h2>
  <h3>Location: <?= esc($location_name ?? '—') ?></h3>
  <!-- <pre><?php print_r($sections); ?></pre> -->

  <div class="meta">
    <strong>Posting:</strong> <?= $posting_dates ? date('F j, Y', strtotime($posting_dates)) : '—' ?> &nbsp; | &nbsp;
    <strong>Public Hearing:</strong> <?= $hearing_dates ? date('F j, Y', strtotime($hearing_dates)) : '—' ?> &nbsp; | &nbsp;
    <strong>Completion:</strong> <?= $progress['percent'] ?? 0 ?>%
  </div>

  <?php if (!empty($sections)): ?>
    <?php foreach ($sections as $section): ?>
      <table>
        <thead>
          <tr class="section-title">
            <td colspan="4"><?= esc($section['title']) ?></td>
          </tr>
          <tr>
            <th>Activity</th>
            <th>Status</th>
            <th>Date Completed</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($section['items'] as $item): ?>
            <tr>
              <td><?= esc($item['activity'] ?? '—') ?></td>
              <td><?= esc($item['status'] ?? '—') ?></td>
              <td><?= esc($item['date_completed'] ?? '—') ?></td>
              <td><?= esc($item['remarks'] ?? '—') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No activities found for this location.</p>
  <?php endif; ?>

  <div class="footer">
    Printed on <?= date('F j, Y g:i A') ?>
  </div>

</body>
</html>
