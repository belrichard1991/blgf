<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2>QRRPA Monitoring Results</h2>

  <div class="mb-4">
    <p><strong>Year:</strong> <?= esc($year) ?> &nbsp;&nbsp;
       <strong>Quarter:</strong> Q<?= esc($quarter) ?></p>
  </div>

  <?php foreach ($stats as $province => $data): ?>
    <div class="card mb-3">
      <div class="card-header"><strong><?= esc($province) ?></strong></div>
      <div class="card-body">
        <p><strong>Evaluated:</strong> <?= $data['done'] ?> / <?= $data['total'] ?></p>
        <div class="progress">
          <div class="progress-bar" role="progressbar" 
               style="width: <?= $data['percent'] ?>%;" 
               aria-valuenow="<?= $data['percent'] ?>" 
               aria-valuemin="0" aria-valuemax="100">
            <?= $data['percent'] ?>%
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <a href="<?= site_url("qrrpa?year={$year}&quarter={$quarter}") ?>" class="btn btn-secondary mt-3">Go Back</a>
</div>

<?= $this->endSection() ?>
