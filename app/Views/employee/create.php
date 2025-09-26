<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-4 text-primary">Add New Employee</h2>

  <div class="card">
    <div class="card-body">
      <form action="<?= site_url('employee/store') ?>" method="post" enctype="multipart/form-data">
        
        <!-- Personal Info -->
        <div class="row mb-3">
          <div class="col-md-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middle_name">
          </div>
          <div class="col-md-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Extension</label>
            <input type="text" class="form-control" name="ext">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" id="birthdate">
          </div>
          <div class="col-md-3">
            <label class="form-label">Age</label>
            <input type="number" class="form-control" name="age" id="age" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label">Civil Status</label>
            <select name="civil_status" class="form-select">
              <option value="">-- Select --</option>
              <option value="Single">Single</option>
              <option value="Married">Married</option>
              <option value="Widowed">Widowed</option>
              <option value="Separated">Separated</option>
            </select>
          </div>
        </div>

        <!-- Province and Municipality -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Province</label>
            <select class="form-select" name="province" id="province-select" required>
              <option value="">-- Select Province --</option>
              <!-- JS will load provinces -->
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Municipality</label>
            <select class="form-select" name="municipality" id="municipality-select" required>
              <option value="">-- Select Municipality --</option>
              <!-- JS will load municipalities -->
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Region</label>
            <input type="text" name="region" class="form-control" value="Caraga" readonly>
          </div>
        </div>

        <!-- Other Info -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Position</label>
            <select name="plantilla_position" class="form-select">
              <option value="">-- Select --</option>
              <option value="Permanent">Permanent</option>
              <option value="Casual">Casual</option>
              <option value="J.O.">J.O.</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Salary Grade</label>
            <input type="number" name="salary_grade" class="form-control">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Retirement Year</label>
            <input type="number" name="retirement_year" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">IPCR Rating</label>
            <input type="text" name="ipcr_rating" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Contact No.</label>
            <input type="text" name="contact_no" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Real Estate Appraiser?</label>
            <select name="is_real_estate_appraiser" class="form-select">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">License No.</label>
            <input type="text" name="license_no" class="form-control">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">License Registration Date</label>
            <input type="date" name="date_of_license_registration" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">License Expiration Date</label>
            <input type="date" name="date_of_license_expiration" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Date of Last LAOE</label>
            <input type="date" name="date_of_last_laoe_conducted" class="form-control">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Profile Picture</label>
          <input type="file" name="Photo" class="form-control">
        </div>

        <div class="d-flex justify-content-end">
          <a href="<?= site_url('employee') ?>" class="btn btn-secondary me-2">Cancel</a>
          <button type="submit" class="btn btn-primary">Save</button>
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

    // Load provinces from API
    fetch('/locations/provinces')
      .then(res => res.json())
      .then(data => {
        provinceSelect.innerHTML = '<option value="">-- Select Province --</option>';
        data.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p.name; // store name
          opt.textContent = p.name;
          opt.setAttribute('data-id', p.id); // for loading municipalities
          provinceSelect.appendChild(opt);
        });
      });

    // Load municipalities when province changes
    provinceSelect.addEventListener('change', function () {
      const selected = this.options[this.selectedIndex];
      const provinceId = selected.getAttribute('data-id');

      municipalitySelect.innerHTML = '<option value="">Loading...</option>';

      fetch(`/locations/municipalities/${provinceId}`)
        .then(res => res.json())
        .then(data => {
          municipalitySelect.innerHTML = '<option value="">-- Select Municipality --</option>';
          data.forEach(m => {
            const opt = document.createElement('option');
            opt.value = m.name; // store name
            opt.textContent = m.name;
            municipalitySelect.appendChild(opt);
          });
        });
    });

    // Calculate age from birthdate
    const birthdate = document.getElementById('birthdate');
    const ageInput = document.getElementById('age');

    birthdate.addEventListener('change', function () {
      const bdate = new Date(this.value);
      const today = new Date();
      let age = today.getFullYear() - bdate.getFullYear();
      const m = today.getMonth() - bdate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < bdate.getDate())) age--;
      ageInput.value = age;
    });
  });
</script>
<?= $this->endSection() ?>
