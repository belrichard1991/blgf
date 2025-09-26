<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2>RPVARA Progress Report</h2>

  <!-- Location Selector -->
  <form method="get" action="<?= site_url('rpvara/progress') ?>" class="mb-4 text-center">
    <label for="location_id" class="me-2 fw-bold">Select Location:</label>
    <select name="location_id" id="location_id" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
      <?php foreach ($locations as $loc): ?>
        <option value="<?= $loc['id'] ?>" <?= $loc['id'] == $location_id ? 'selected' : '' ?>>
          <?= esc($loc['name']) ?> (<?= esc($loc['type'] ?? 'Unknown') ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <!-- Location Info -->
  <div class="rpvara-title text-center mb-3">
    <h2 class="mb-0 text-uppercase">Location: <?= esc($location_name ?? '—') ?></h2>
  </div>

  <div class="text-center small text-muted mb-3">
    <span><strong>Posting:</strong> <?= $posting_dates ? date('F j, Y', strtotime($posting_dates)) : '—' ?></span>
    &nbsp;•&nbsp;
    <span><strong>Public Hearing:</strong> <?= $hearing_dates ? date('F j, Y', strtotime($hearing_dates)) : '—' ?></span>
  </div>

  <!-- Overall Progress -->
  <div class="mb-4">
    <label class="fw-bold">Overall Completion:</label>
    <div class="progress">
      <div class="progress-bar" role="progressbar"
           style="width: <?= $progress['percent'] ?>%;"
           aria-valuenow="<?= $progress['percent'] ?>"
           aria-valuemin="0" aria-valuemax="100">
        <?= $progress['percent'] ?>%
      </div>
    </div>
  </div>

  <!-- Activities Grouped by Category -->
  <?php if (!empty($sections)): ?>
    <?php foreach ($sections as $section): ?>
      <table class="table table-bordered table-striped align-middle mt-4">
        <thead>
          <tr class="table-light fw-bold">
            <td colspan="5"><?= esc($section['title']) ?></td>
          </tr>
          <tr>
            <th>Activity</th>
            <th>Status</th>
            <th>Date Completed</th>
            <th>Remarks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($section['items'] as $item): ?>
            <tr>
              <form action="<?= site_url('rpvara/update/' . $item['id']) ?>" method="post">
               <td><?= esc($item['activity_name'] ?? '—') ?></td>

                <!-- Editable status -->
                <td class="text-center">
                  <select name="status" class="form-select form-select-sm">
                    <option value="Completed" <?= $item['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="Pending" <?= $item['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                  </select>
                </td>

                <!-- Editable date -->
                <td>
                  <input type="date" name="date_completed" class="form-control form-control-sm"
                         value="<?= esc($item['date_completed']) ?>">
                </td>

                <!-- Editable remarks -->
                <td>
                  <input type="text" name="remarks" class="form-control form-control-sm"
                         value="<?= esc($item['remarks']) ?>">
                </td>

                <td class="text-center">
                  <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </td>
              </form>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-warning text-center">No activities found for this location.</div>
  <?php endif; ?>
</div>
<a href="<?= site_url('rpvara/print_progress?location_id=' . $location_id) ?>" target="_blank" class="btn btn-outline-secondary">
  🖨️ Print Clean Report
</a>
<?= $this->endSection() ?>
