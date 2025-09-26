<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
  $year = $year ?? date('Y');
  $quarter = $quarter ?? ceil(date('n') / 3);
?>

<div class="container mt-4">
  <h2>QRRPA Monitoring</h2>

  <!-- Filter Form -->
  <form action="<?= site_url('qrrpa') ?>" method="get" id="filterForm">
    <div class="row mb-3">
      <div class="col-md-3">
        <label for="year" class="form-label">Year</label>
        <select name="year" id="year" class="form-select" onchange="document.getElementById('filterForm').submit();">
          <?php 
            $currentYear = date('Y');
            for ($y = $currentYear; $y >= $currentYear - 5; $y--): ?>
              <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label for="quarter" class="form-label">Quarter</label>
        <select name="quarter" id="quarter" class="form-select" onchange="document.getElementById('filterForm').submit();">
          <?php for ($q = 1; $q <= 4; $q++): ?>
            <option value="<?= $q ?>" <?= $quarter == $q ? 'selected' : '' ?>>Q<?= $q ?></option>
          <?php endfor; ?>
        </select>
      </div>
    </div>
  </form>

  <!-- Evaluation Form -->
  <form action="<?= site_url('qrrpa/result') ?>" method="post">
    <input type="hidden" name="year" value="<?= esc($year) ?>">
    <input type="hidden" name="quarter" value="<?= esc($quarter) ?>">

    <?php foreach ($grouped as $province => $munis): ?>
      <div class="card mb-3">
        <div class="card-header"><strong><?= esc($province) ?></strong></div>
        <div class="card-body">
          <div class="row">
            <?php foreach ($munis as $m): ?>
              <div class="col-md-3">
                <div class="form-check">
                  <input class="form-check-input" 
                         type="checkbox" 
                         name="evaluated[]" 
                         id="muni<?= $m['id'] ?>" 
                         value="<?= $m['id'] ?>"
                         <?= in_array($m['id'], $evaluatedIds ?? []) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="muni<?= $m['id'] ?>">
                    <?= esc($m['name']) ?>
                  </label>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary">Calculate Progress</button>
  </form>
</div>

<?= $this->endSection() ?>
