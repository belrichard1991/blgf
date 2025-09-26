<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="mb-4">
    <h2 class="fw-bold text-dark">SMV Monitoring Dashboard</h2>
    <p class="text-muted">Progress overview for all Provinces and Cities in the Caraga Region.</p>
  </div>

  <div class="row mb-4">
    <?php foreach ($topLocations as $location): ?>
      <?php $name = $location['name']; ?>
      <div class="col-md-4 mb-3">
        <a href="<?= site_url('rpvara/progress?location_id=' . $location['id']) ?>" class="text-decoration-none">
          <div class="card shadow-sm border-0 hover-shadow">
            <div class="card-body">
              <h5 class="card-title text-primary"><?= esc($name) ?></h5>
              <div class="progress mb-2" style="height: 20px;">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: <?= $progress[$name]['percentage'] ?? 0 ?>%;">
                  <?= $progress[$name]['percentage'] ?? 0 ?>%
                </div>
              </div>
              <p class="small text-muted mb-0">Overall SMV completion for this <?= esc($location['type']) ?>.</p>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="accordion" id="provinceAccordion">
    <?php foreach ($progress as $location_name => $location_data): ?>
      <div class="accordion-item mb-2">
        <h2 class="accordion-header" id="heading-<?= md5($location_name) ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapse-<?= md5($location_name) ?>" aria-expanded="false">
            <?= esc($location_name) ?> - <?= esc($location_data['percentage']) ?>%
          </button>
        </h2>
        <div id="collapse-<?= md5($location_name) ?>" class="accordion-collapse collapse"
             data-bs-parent="#provinceAccordion">
          <div class="accordion-body">
            <?php foreach ($location_data['cities'] as $city): ?>
              <div class="mb-4">
                <h6 class="fw-bold"><?= esc($city['name']) ?> - <?= esc($city['percentage']) ?>%</h6>
                <table class="table table-sm table-bordered align-middle bg-white">
                  <thead class="table-light">
                    <tr>
                      <th>Activity</th>
                      <th>Status</th>
                      <th>Date Completed</th>
                      <th>Remarks</th>
                      <th class="text-center" style="width: 120px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($city['activities'])): ?>
                      <?php foreach ($city['activities'] as $activity): ?>
                        <tr>
                          <td><?= esc($activity['activity']) ?></td>
                          <td>
                            <span class="badge <?= $activity['status'] === 'Completed' ? 'bg-success' : 'bg-secondary' ?>">
                              <?= esc($activity['status']) ?>
                            </span>
                          </td>
                          <td><?= esc($activity['date_completed'] ?: '-') ?></td>
                          <td><?= esc($activity['remarks'] ?: '-') ?></td>
                          <td class="text-center">
                            <form action="<?= site_url('smv/update_status/' . $activity['id']) ?>" method="post">
                              <select name="status" class="form-select form-select-sm mb-2">
                                <option value="Completed" <?= $activity['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Pending" <?= $activity['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                              </select>
                              <input type="text" name="remarks" value="<?= esc($activity['remarks']) ?>"
                                     class="form-control form-control-sm mb-2" placeholder="Remarks">
                              <button type="submit" class="btn btn-sm btn-primary w-100">Update</button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" class="text-center text-muted">No activities recorded yet.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?= $this->endSection() ?>
