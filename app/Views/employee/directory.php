<?= $this->extend('layout') ?>

<?= $this->section('actions') ?>
<div class="d-flex gap-2 mb-3 flex-wrap">
  <a href="<?= site_url('employee/export?' . http_build_query($_GET)) ?>" class="btn btn-success">
    <i class="bi bi-file-earmark-excel"></i> Export Excel
  </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<form method="get" class="row g-2 mb-4">
  <div class="col-md-3">
    <label class="form-label">Province</label>
    <select name="province" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($provinces as $p): ?>
        <option value="<?= esc($p['province']) ?>"
          <?= (isset($_GET['province']) && $_GET['province'] === $p['province']) ? 'selected' : '' ?>>
          <?= esc($p['province']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label">Municipality</label>
    <select name="municipality" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($municipalities as $m): ?>
        <option value="<?= esc($m['municipality']) ?>"
          <?= (isset($_GET['municipality']) && $_GET['municipality'] === $m['municipality']) ? 'selected' : '' ?>>
          <?= esc($m['municipality']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label">Position</label>
    <select name="plantilla_position" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($positions as $pos): ?>
        <option value="<?= esc($pos['plantilla_position']) ?>"
          <?= (isset($_GET['plantilla_position']) && $_GET['plantilla_position'] === $pos['plantilla_position']) ? 'selected' : '' ?>>
          <?= esc($pos['plantilla_position']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label">Designation</label>
    <select name="designation" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($designations as $d): ?>
        <option value="<?= esc($d['designation']) ?>"
          <?= (isset($_GET['designation']) && $_GET['designation'] === $d['designation']) ? 'selected' : '' ?>>
          <?= esc($d['designation']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Filter</button>
    <a href="<?= site_url('employee/directory') ?>" class="btn btn-secondary">Clear</a>
  </div>
</form>

<div class="card">
  <div class="card-body table-responsive">

    <style>
        #directoryTable td, 
        #directoryTable th {
            text-transform: uppercase;
        }
    </style>

    <table class="table table-bordered table-hover align-middle" id="directoryTable">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Province</th>
          <th>Municipality</th>
          <th>Designation</th>
          <th>Position</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Photo</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($employees)): ?>
          <?php foreach ($employees as $emp): ?>
            <tr>
              <td><?= esc($emp['id']) ?></td>
              <td><?= esc($emp['first_name'] . ' ' . $emp['middle_name'] . ' ' . $emp['last_name']) ?></td>
              <td><?= esc($emp['province']) ?></td>
              <td><?= esc($emp['municipality']) ?></td>
              <td><?= esc($emp['designation']) ?></td>
              <td><?= esc($emp['plantilla_position']) ?></td>
              <td><?= esc($emp['email']) ?></td>
              <td><?= esc($emp['contact_no']) ?></td>
              <td>
                <?php if (!empty($emp['Photo']) && file_exists(FCPATH . 'uploads/' . $emp['Photo'])): ?>
                  <img src="<?= base_url('uploads/' . $emp['Photo']) ?>" width="50" height="50"
                       style="object-fit:cover; border-radius:50%;">
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center">No employee records found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- ✅ Record count display -->
    <div class="mt-3 text-end">
      <strong>Total Records: <?= count($employees) ?></strong>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
