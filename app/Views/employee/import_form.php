<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h5>Import Employees from Excel</h5>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('employee/import') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?> <!-- CSRF token for security -->

            <div class="mb-3">
                <label class="form-label">Excel File (.xlsx, .xls, .csv)</label>
                <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>
            </div>

            <button type="submit" class="btn btn-success">Upload & Import</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
