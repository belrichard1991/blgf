<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="<?= base_url('blgf.ico') ?>" type="image/x-icon">
  <title><?= esc($title ?? "Assessor's Profiling") ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f1f4f9;
    }

    .topbar { 
      background-color: #fff; 
      padding: 15px 20px; 
      margin-bottom: 30px; 
      border-bottom: 1px solid #dee2e6; 
    }

    .sidebar-desktop {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 240px;
      background-color: #343a40;
      padding: 20px;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.3s ease;
      z-index: 1000;
      overflow-y: auto;
    }

    .sidebar-hidden {
      transform: translateX(-240px);
    }

    .sidebar-desktop h4 {
      color: #ffc107;
      margin-bottom: 20px;
    }

    .sidebar-desktop a {
      color: #adb5bd;
      text-decoration: none;
      display: block;
      padding: 8px 12px;
      margin: 6px 0;
      border-radius: 4px;
      font-size: 15px;
      transition: background-color 0.2s ease;
    }

    .sidebar-desktop a:hover {
      color: #fff;
      background-color: #495057;
    }

    .sidebar-desktop h6 {
      margin-top: 20px;
      font-size: 13px;
      letter-spacing: 1px;
      color: #ffc107;
    }

    .main-content {
      margin-left: 260px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    .hover-shadow:hover { 
      box-shadow: 0 0 10px rgba(0,0,0,0.2); 
      transform: scale(1.02); 
      transition: 0.2s ease-in-out; 
    }
    
    .main-expanded {
      margin-left: 20px !important;
    }

    #sidebarToggleWrapper {
      position: fixed;
      top: 20px;
      left: 220px;
      z-index: 1100;
      transition: left 0.3s ease;
    }

    .sidebar-hidden + #sidebarToggleWrapper {
      left: 0px;
    }

    .circle-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: none;
      background-color: #ffc107;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .circle-btn:hover {
      background-color: #e0a800;
    }

    @media (max-width: 768px) {
      .sidebar-desktop {
        display: none;
      }
      .main-content {
        margin-left: 0;
      }
      #sidebarToggleWrapper {
        display: none;
      }
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Desktop Sidebar -->
<div class="sidebar-desktop" id="sidebar">
  <div>
    <h4>Assessor's Panel</h4>
    <a href="<?= site_url('dashboard') ?>">Dashboard</a>
    <a href="<?= site_url('records') ?>">Records</a>
    <a href="<?= site_url('employee/create') ?>">Add Employee</a>
    <a href="<?= site_url('employee/directory') ?>">Directory</a>
    <hr class="bg-light">

    <h6 class="text-uppercase">QRRPA</h6>
    <a href="<?= site_url('qrrpa') ?>">QRRPA Monitoring</a>
    <a href="<?= site_url('qrrpa/summary') ?>">Evaluation Summary</a>

    <hr class="bg-light">
    <h6 class="text-uppercase">SMV Monitoring</h6>
    <a href="<?= site_url('smv') ?>">SMV Dashboard</a>
    <a href="<?= site_url('smv/summary') ?>">Summary of Accomplishments</a>
    <a href="<?= site_url('rpvara/progress') ?>">RPVARA Progress Report</a>
    <a href="<?= site_url('rpvara/summary') ?>" hidden>RPVARA Summary</a>
  </div>

  <div class="mt-3">
    <a href="<?= site_url('logout') ?>" class="btn w-100" style="background-color:#ffc107; color:#000; border:none;">
      Logout
    </a>
  </div>
</div>

<!-- Sidebar Toggle Button -->
<div id="sidebarToggleWrapper">
  <button id="toggleSidebar" class="circle-btn" title="Toggle Sidebar">☰</button>
</div>

<!-- Offcanvas Sidebar (Mobile) -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-warning">Assessor's Panel</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column justify-content-between">
    <div>
      <a href="<?= site_url('dashboard') ?>" class="d-block mb-2 text-decoration-none text-light">Dashboard</a>
      <a href="<?= site_url('records') ?>" class="d-block mb-2 text-decoration-none text-light">Records</a>
      <a href="<?= site_url('employee/create') ?>" class="d-block mb-2 text-decoration-none text-light">Add Employee</a>
      <a href="<?= site_url('employee/directory') ?>" class="d-block mb-2 text-decoration-none text-light">Directory</a>
      <hr class="bg-light">

      <h6 class="text-uppercase text-warning mt-3">QRRPA</h6>
      <a href="<?= site_url('qrrpa') ?>" class="d-block mb-2 text-decoration-none text-light">QRRPA Monitoring</a>
      <a href="<?= site_url('qrrpa/summary') ?>" class="d-block mb-2 text-decoration-none text-light">Evaluation Summary</a>

      <hr class="bg-light">
      <h6 class="text-uppercase text-warning mt-3">SMV Monitoring</h6>
      <a href="<?= site_url('smv') ?>" class="d-block mb-2 text-decoration-none text-light">SMV Dashboard</a>
      <a href="<?= site_url('smv/summary') ?>" class="d-block mb-2 text-decoration-none text-light">Summary of Accomplishments</a>
      <a href="<?= site_url('rpvara/progress') ?>" class="d-block mb-2 text-decoration-none text-light">RPVARA Progress Report</a>
    </div>
    <div>
      <a href="<?= site_url('logout') ?>" class="btn w-100" style="background-color:#ffc107; color:#000; border:none;">
        Logout
      </a>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
  <div class="topbar d-flex flex-wrap justify-content-between align-items-center">
  
  <button class="btn btn-outline-dark d-md-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
    ☰ Menu
  </button>

  <h3 class="mb-0"><?= esc($header ?? "Assessor's Profiling Database") ?></h3>
  <?= $this->renderSection('actions') ?>
</div>

  <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
<script>
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const toggleWrapper = document.getElementById('sidebarToggleWrapper');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('sidebar-hidden');
    mainContent.classList.toggle('main-expanded');

    // Move toggle button to left edge or back to sidebar edge
    if (sidebar.classList.contains('sidebar-hidden')) {
      toggleWrapper.style.left = '0px';
    } else {
      toggleWrapper.style.left = '220px';
    }
  });
</script>

</body>
</html>
