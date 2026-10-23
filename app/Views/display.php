<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List all Employee</title>
</head>
<body>
    <h2>Employee Directory</h2>
    <p align="right"><a href="<?= base_url('logout') ?>">Logout</a></p>
    <br>
    <a href="<?= base_url('employee/create') ?>">+ Add New Employee</a>
    <hr>

    <?php if(session()->getFlashdata('status')): ?>
        <p style="color: green;"><?= session()->getFlashdata('status') ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Birth Day</th>
                <th>Department</th>
                <th>Position</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($employees) && is_array($employees)): ?>
                <?php foreach($employees as $employee): ?>
                <tr>
                    <td><?= $employee['emp_id'] ?></td>
                    <td><?= $employee['firstname'] . ', ' . $employee['lastname'] ?></td>
                    <td><?= $employee['email'] ?></td>
                    <td><?= $employee['mobile'] ?></td>
                    <td><?= // Convert it to MM-DD-YYYY string
                        date('m-d-Y', strtotime($employee['birthdate']));
                    ?></td>
                    <td><?= $employee['department'] ?></td>
                    <td><?= $employee['position'] ?></td>
                    <td><?= $employee['username'] ?></td>
                    <td><?= $employee['password'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
