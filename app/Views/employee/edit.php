<?php
// edit.php
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
  <h2 class="mt-4 mb-4 text-center text-warning">
    <i class="fas fa-user-edit me-2"></i>Edit Employee
  </h2>
  <div class="card">
    <div class="card-body">
      <form action="<?= site_url('employee/update/' . $employee['id']) ?>" method="post" enctype="multipart/form-data">
        <div class="form-section-title">Personal Information</div><hr>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?= esc($employee['first_name']) ?>" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middle_name" value="<?= esc($employee['middle_name']) ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?= esc($employee['last_name']) ?>" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Ext.</label>
            <input type="text" class="form-control" name="ext" value="<?= esc($employee['ext']) ?>">
          </div>

          <div class="col-md-3">
            <label class="form-label">Gender</label>
            <select class="form-select" name="gender">
              <option value="Male" <?= $employee['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $employee['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?= esc($employee['birthdate']) ?>">
          </div>

          <div class="col-md-3">
            <label class="form-label">Age</label>
            <input type="number" class="form-control" name="age" id="age" value="<?= esc($employee['age']) ?>" readonly>
          </div>

          <div class="col-md-3">
            <label class="form-label">Civil Status</label>
            <select name="civil_status" class="form-select" required>
              <option value="">-- Select Civil Status --</option>
              <?php foreach(['Single','Married','Widowed','Separated','Divorced'] as $status): ?>
                <option value="<?= $status ?>" <?= (old('civil_status', $employee['civil_status']) == $status) ? 'selected' : '' ?>>
                  <?= $status ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <hr><div class="form-section-title">Employment Details</div><hr>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Province</label>
            <select class="form-select" id="province-select" required>
              <option value="">-- Select Province --</option>
            </select>
            <input type="hidden" name="province" id="province-name">
          </div>

          <div class="col-md-3">
            <label class="form-label">Municipality</label>
            <select class="form-select" name="municipality" id="municipality-select" required>
              <option value="">-- Select Municipality --</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Region</label>
            <input type="text" class="form-control" name="region" value="Caraga" readonly>
          </div>

          <div class="col-md-3">
            <label class="form-label">Designation</label>
            <input type="text" class="form-control" name="designation" value="<?= esc($employee['designation']) ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label">Plantilla Position</label>
            <select class="form-select" name="plantilla_position" required>
              <option value="">-- Select Position --</option>
              <?php foreach(['Permanent','Casual','J.O.'] as $pos): ?>
                <option value="<?= $pos ?>" <?= $employee['plantilla_position'] === $pos ? 'selected' : '' ?>>
                  <?= $pos ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label">Salary Grade</label>
            <input type="number" class="form-control" name="salary_grade" value="<?= esc($employee['salary_grade']) ?>">
          </div>

          <div class="col-md-3">
            <label class="form-label">Retirement Year</label>
            <input type="number" class="form-control" name="retirement_year" value="<?= esc($employee['retirement_year']) ?>">
          </div>

          <div class="col-md-3">
            <label class="form-label">IPCR Rating</label>
            <input type="text" class="form-control" name="ipcr_rating" value="<?= esc($employee['ipcr_rating']) ?>">
          </div>
        </div>

        <hr><div class="form-section-title">License & Appraisal</div><hr>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Real Estate Appraiser?</label>
            <select class="form-select" name="is_real_estate_appraiser">
              <option value="0" <?= !$employee['is_real_estate_appraiser'] ? 'selected' : '' ?>>No</option>
              <option value="1" <?= $employee['is_real_estate_appraiser'] ? 'selected' : '' ?>>Yes</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">License No</label>
            <input type="text" class="form-control" name="license_no" value="<?= esc($employee['license_no']) ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label">Date of License Registration</label>
            <input type="date" class="form-control" name="date_of_license_registration" value="<?= esc($employee['date_of_license_registration']) ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label">Date of License Expiration</label>
            <input type="date" class="form-control" name="date_of_license_expiration" value="<?= esc($employee['date_of_license_expiration']) ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label">Date of Last LAOE Conducted</label>
            <input type="date" class="form-control" name="date_of_last_laoe_conducted" value="<?= esc($employee['date_of_last_laoe_conducted']) ?>">
          </div>
        </div>

        <hr><div class="form-section-title">Contact Information</div><hr>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= esc($employee['email']) ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label">Contact No</label>
            <input type="text" class="form-control" name="contact_no" value="<?= esc($employee['contact_no']) ?>">
          </div>
        </div>

        <div class="mb-3">
          <label for="Photo">Profile Picture</label>
          <input type="file" name="Photo" class="form-control">
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="<?= site_url('employee') ?>" class="btn btn-secondary me-3">Cancel</a>
          <button type="submit" class="btn btn-success px-4">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const provinceSelect = document.getElementById('province-select');
  const municipalitySelect = document.getElementById('municipality-select');
  const birthdateInput = document.getElementById('birthdate');
  const ageInput = document.getElementById('age');
  const provinceNameInput = document.getElementById('province-name');
  const employeeProvinceName = <?= json_encode($employee['province']) ?>;
  const employeeMunicipality = <?= json_encode($employee['municipality']) ?>;

  fetch('/locations/provinces')
    .then(res => res.json())
    .then(data => {
      provinceSelect.innerHTML = '<option value="">-- Select Province --</option>';
      let selectedProvinceId = null;
      data.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id;
        opt.textContent = p.name;
        if (p.name === employeeProvinceName) {
          opt.selected = true;
          selectedProvinceId = p.id;
          provinceNameInput.value = p.name;
        }
        provinceSelect.appendChild(opt);
      });
      if (selectedProvinceId) loadMunicipalities(selectedProvinceId);
    });

  provinceSelect.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    provinceNameInput.value = selectedOption.textContent;
    loadMunicipalities(this.value);
  });

  function loadMunicipalities(provinceId) {
    fetch(`/locations/municipalities/${provinceId}`)
      .then(res => res.json())
      .then(data => {
        municipalitySelect.innerHTML = '<option value="">-- Select Municipality --</option>';
        data.forEach(m => {
          const opt = document.createElement('option');
          opt.value = m.name;
          opt.textContent = m.name;
          if (m.name === employeeMunicipality) {
            opt.selected = true;
          }
          municipalitySelect.appendChild(opt);
        });
      });
  }

  birthdateInput.addEventListener('change', updateAge);
  function updateAge() {
    const b = new Date(birthdateInput.value);
    if (isNaN(b)) return;
    const today = new Date();
    let age = today.getFullYear() - b.getFullYear();
    const m = today.getMonth() - b.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < b.getDate())) age--;
    ageInput.value = age;
  }
  updateAge();
});
</script>
<?= $this->endSection() ?>
