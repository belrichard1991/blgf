<!DOCTYPE html>
<html>
<head>
    <title>Employee Profile</title>
</head>
<body>
    <h1>Employee Profile</h1>

    <p><strong>Name:</strong> <?= esc($employee['first_name']) ?> <?= esc($employee['middle_name']) ?> <?= esc($employee['last_name']) ?> <?= esc($employee['ext']) ?></p>
    <p><strong>Municipality:</strong> <?= esc($employee['municipality']) ?></p>
    <p><strong>Province:</strong> <?= esc($employee['province']) ?></p>
    <p><strong>Region:</strong> <?= esc($employee['region']) ?></p>
    <p><strong>Designation:</strong> <?= esc($employee['designation']) ?></p>
    <p><strong>Plantilla Position:</strong> <?= esc($employee['plantilla_position']) ?></p>
    <p><strong>Salary Grade:</strong> <?= esc($employee['salary_grade']) ?></p>
    <p><strong>Gender:</strong> <?= esc($employee['gender']) ?></p>
    <p><strong>Age:</strong> <?= esc($employee['age']) ?></p>
    <p><strong>Birthdate:</strong> <?= esc($employee['birthdate']) ?></p>
    <p><strong>Civil Status:</strong> <?= esc($employee['civil_status']) ?></p>
    <p><strong>Real Estate Appraiser:</strong> <?= $employee['is_real_estate_appraiser'] ? 'Yes' : 'No' ?></p>
    <p><strong>License No:</strong> <?= esc($employee['license_no']) ?></p>
    <p><strong>License Registered:</strong> <?= esc($employee['date_of_license_registration']) ?></p>
    <p><strong>License Expiry:</strong> <?= esc($employee['date_of_license_expiration']) ?></p>
    <p><strong>Email:</strong> <?= esc($employee['email']) ?></p>
    <p><strong>Contact No:</strong> <?= esc($employee['contact_no']) ?></p>
    <p><strong>Retirement Year:</strong> <?= esc($employee['retirement_year']) ?></p>
    <p><strong>IPCR Rating:</strong> <?= esc($employee['ipcr_rating']) ?></p>
    <p><strong>Date of Last LAOE Conducted:</strong> <?= esc($employee['date_of_last_laoe_conducted']) ?></p>

    <br>
    <a href="<?= site_url('employee') ?>">⬅ Back to list</a>
</body>
</html>
