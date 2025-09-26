<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="watermark">CLASSIFIED</div>
<div class="seal-bg"></div>

<div class="profile-container">
  <header class="fbi-header">
    <div class="logo-row">
      <img src="<?= base_url('blgf.png') ?>" 
       alt="BLGF Logo" 
       class="blgf-logo">
    </div>
    <h1>BUREAU OF LOCAL GOVERNMENT FINANCE</h1>
    <p>EMPLOYEE DOSSIER</p>
  </header>

  <div class="profile-content">
    <!-- Photo Section -->
    <div class="photo-section">
      <?php if (!empty($employee['Photo']) && file_exists(FCPATH . 'uploads/' . $employee['Photo'])) : ?>
        <img src="<?= base_url('uploads/' . $employee['Photo']) ?>" class="agent-photo" alt="Employee Photo">
      <?php else : ?>
        <div class="agent-photo d-flex align-items-center justify-content-center">NO PHOTO</div>
      <?php endif; ?>
      <div class="status">ACTIVE</div>
      <div class="file-id">File ID: <?= esc($employee['id'] ?? '0000') ?></div>
    </div>

    <!-- Details Section -->
    <div class="details-section">
      <h2>Personal Information</h2>
      <div class="info-grid">
        <div><strong>Full Name:</strong> <?= esc($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']) ?></div>
        <div><strong>Extension:</strong> <?= esc($employee['ext']) ?></div>
        <div><strong>Gender:</strong> <?= esc($employee['gender']) ?></div>
        <div><strong>Age:</strong> <?= esc($employee['age']) ?></div>
        <div><strong>Birthdate:</strong> <?= esc($employee['birthdate']) ?></div>
        <div><strong>Civil Status:</strong> <?= esc($employee['civil_status']) ?></div>
      </div>

      <h2>Assignment</h2>
      <div class="info-grid">
        <div><strong>Municipality:</strong> <?= esc($employee['municipality']) ?></div>
        <div><strong>Province:</strong> <?= esc($employee['province']) ?></div>
        <div><strong>Region:</strong> <?= esc($employee['region']) ?></div>
        <div><strong>Designation:</strong> <?= esc($employee['designation']) ?></div>
        <div><strong>Plantilla Position:</strong> <?= esc($employee['plantilla_position']) ?></div>
        <div><strong>Salary Grade:</strong> <?= esc($employee['salary_grade']) ?></div>
      </div>

      <h2>Licensing</h2>
      <div class="info-grid">
        <div><strong>Real Estate Appraiser:</strong> <?= ((int)($employee['is_real_estate_appraiser'] ?? 0) === 1) ? 'Yes' : 'No' ?></div>
        <div><strong>License No.:</strong> <?= esc($employee['license_no']) ?></div>
        <div><strong>Registered:</strong> <?= esc($employee['date_of_license_registration']) ?></div>
        <div><strong>Expiry:</strong> <?= esc($employee['date_of_license_expiration']) ?></div>
      </div>

      <h2>Contact</h2>
      <div class="info-grid">
        <div><strong>Phone:</strong> <?= esc($employee['contact_no']) ?></div>
        <div><strong>Email:</strong> <?= esc($employee['email']) ?></div>
      </div>

      <h2>Other Information</h2>
      <div class="info-grid">
        <div><strong>Retirement Year:</strong> <?= esc($employee['retirement_year']) ?></div>
        <div><strong>IPCR Rating:</strong> <?= esc($employee['ipcr_rating']) ?></div>
        <div><strong>Last LAOE:</strong> <?= esc($employee['date_of_last_laoe_conducted']) ?></div>
      </div>
    </div>
  </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Share Tech Mono', monospace;
  background-color: #0a0a0a;
  color: #00ffcc;
  padding: 20px;
}

.profile-container {
  border: 2px solid #00ffcc;
  padding: 20px;
  max-width: 1000px;
  margin: auto;
  background-color: #111;
  box-shadow: 0 0 20px #00ffcc33;
  position: relative;
  z-index: 1;
}

header {
  text-align: center;
  margin-bottom: 30px;
}

header h1 {
  font-size: 28px;
  letter-spacing: 1.5px;
}

header p {
  font-size: 14px;
  color: #ff4444;
  font-weight: bold;
}

.profile-content {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
}

.photo-section {
  flex: 1;
  max-width: 250px;
  text-align: center;
}

.agent-photo {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border: 3px solid #00ffcc;
  margin-bottom: 10px;
  box-shadow: 0 0 15px #00ffcc55;
  border-radius: 5px;
  background-color: #222;
  display: flex;
  align-items: center;
  justify-content: center;
}

.status {
  font-weight: bold;
  padding: 8px;
  margin-top: 10px;
  border: 2px dashed #ff4444;
  color: #ff4444;
}

.file-id {
  margin-top: 15px;
  font-size: 14px;
  color: #999;
}

.details-section {
  flex: 2;
}

.details-section h2 {
  border-bottom: 1px solid #00ffcc88;
  margin-top: 20px;
  margin-bottom: 10px;
  padding-bottom: 5px;
  font-size: 20px;
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  font-size: 14px;
}

.watermark {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-30deg);
  font-size: 100px;
  color: rgba(255, 0, 0, 0.1);
  font-weight: 900;
  pointer-events: none;
  z-index: 9999;
  white-space: nowrap;
  user-select: none;
  text-transform: uppercase;
}

.seal-bg {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  height: 400px;
  background: url('https://blgf.gov.ph/wp-content/uploads/2022/05/BLGF-Seal-Regular.png') no-repeat center center;
  background-size: contain;
  transform: translate(-50%, -50%);
  opacity: 0.05;
  pointer-events: none;
  z-index: 0;
}
.blgf-logo {
  max-width: 80px;
  margin-bottom: 10px;
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.logo-row {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px; /* space between logos */
  margin-bottom: 10px;
}

.blgf-logo {
  max-width: 80px;
  height: auto;
}

.fbi-seal {
  max-width: 80px;
  height: auto;
}

</style>

<?= $this->endSection() ?>
