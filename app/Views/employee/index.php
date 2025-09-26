<?= $this->extend('layout') ?>

<?= $this->section('actions') ?>
<div class="row g-2 align-items-center mt-2 mt-md-0">
    <!-- Search bar -->
    <div class="col-auto">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name...">
    </div>

    <!-- Buttons -->
    <div class="col-auto d-flex gap-2">
        <a href="<?= site_url('employee/create') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New
        </a>
        <a href="<?= site_url('employee/import') ?>" class="btn btn-warning">
            <i class="bi bi-upload"></i> Import from Excel
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-body table-responsive">

        <!-- Uppercase display styling -->
        <style>
            #employeeTable td,
            #employeeTable th {
                text-transform: uppercase;
            }
        </style>

        <table class="table table-bordered table-hover align-middle" id="employeeTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Municipality</th>
                    <th>Designation</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)) : ?>
                    <?php foreach ($employees as $emp) : ?>
                        <tr>
                            <td><?= esc($emp['id']) ?></td>
                            <td><?= esc($emp['first_name'] . ' ' . $emp['middle_name'] . ' ' . $emp['last_name']) ?></td>
                            <td><?= esc($emp['municipality']) ?></td>
                            <td><?= esc($emp['designation']) ?></td>
                            <td><?= esc($emp['plantilla_position']) ?></td>
                            <td><?= esc($emp['email']) ?></td>
                            <td><?= esc($emp['contact_no']) ?></td>
                            <td>
                                <?php if (!empty($emp['Photo']) && file_exists(FCPATH . 'uploads/' . $emp['Photo'])): ?>
                                    <div class="hover-img" data-full="<?= base_url('uploads/' . $emp['Photo']) ?>">
                                        <img src="<?= base_url('uploads/' . $emp['Photo']) ?>"
                                            alt="Profile" width="60" height="60" style="object-fit:cover;border-radius:50%;cursor:pointer;">
                                    </div>
                                <?php else: ?>
                                    <span>No photo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= site_url('employee/edit/' . $emp['id']) ?>" class="btn btn-sm btn-primary py-0 px-2">Edit</a>
                                <a href="<?= site_url('employee/delete/' . $emp['id']) ?>" class="btn btn-sm btn-danger py-0 px-2" onclick="return confirm('Are you sure?')">Delete</a>
                                <a href="<?= site_url('employee/view/' . $emp['id']) ?>" target="_blank" class="btn btn-sm btn-secondary py-0 px-2">View Profile</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">No employee records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#employeeTable tbody tr');

    searchInput.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        tableRows.forEach(row => {
            const fullName = row.children[1].textContent.toLowerCase();
            row.style.display = fullName.includes(keyword) ? '' : 'none';
        });
    });
</script>
<script>
    /* open lightbox on hover */
    document.querySelectorAll('.hover-img').forEach(el => {
        el.addEventListener('mouseenter', () => {
            const full = el.dataset.full;
            document.getElementById('lightbox-img').src = full;
            document.getElementById('lightbox').style.display = 'flex';
        });
        el.addEventListener('mouseleave', () => {
            document.getElementById('lightbox').style.display = 'none';
        });
    });
</script>
<?= $this->endSection() ?>
