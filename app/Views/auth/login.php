<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="<?= base_url('blgf.ico') ?>" type="image/x-icon">
  <title>BLGF Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    html,body{height:100%;margin:0}
    body{
      display:flex;align-items:center;justify-content:center;
      font-family:'Inter',sans-serif;
    }
    /* 50 % opacity DOF building */
    body::before{
      content:'';
      position:fixed;inset:0;z-index:-1;
     background: url('<?php echo base_url('37thbg.jpg'); ?>') center/cover no-repeat;
      opacity:.5;
    }
    .login-card{
      width:100%;max-width:380px;
      padding:48px 40px;
      background:#fff;border-radius:.75rem;
      box-shadow:0 .5rem 1.5rem rgba(0,0,0,.08);
    }
    .login-card img.logo{width:64px;height:64px;margin:0 auto 24px}
  </style>
</head>
<body>
  <div class="login-card">
    <img class="logo d-block" src="https://blgf.gov.ph/wp-content/uploads/2022/05/BLGF-Seal-HD.png" alt="BLGF Seal">
    <h4 class="text-center mb-4 fw-semibold">Welcome!</h4>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/loginPost') ?>">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Sign in</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>