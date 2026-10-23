<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>List all Employee</title>
</head>
<body>
<h2>Employee Directory</h2>
<p align="right">
  Logged in as <strong><?= esc(session()->get('username')) ?></strong> |
  <a href="<?= base_url('logout') ?>">Logout</a>
</p>
<br>
<a href="<?= base_url('employee/create') ?>">+ Add New Employee</a>
<hr>

<?php if (session()->getFlashdata('status')): ?>
  <p style="color: green;"><?= esc(session()->getFlashdata('status')) ?></p>
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
    </tr>
  </thead>
  <tbody>
    <?php if (! empty($employees) && is_array($employees)): ?>
      <?php foreach ($employees as $employee): ?>
        <tr>
          <td><?= esc($employee['emp_id']) ?></td>
          <td><?= esc($employee['firstname'] . ', ' . $employee['lastname']) ?></td>
          <td><?= esc($employee['email']) ?></td>
          <td><?= esc($employee['mobile']) ?></td>
          <td><?= date('m-d-Y', strtotime($employee['birthdate'])) // MM-DD-YYYY ?></td>
          <td><?= esc($employee['department']) ?></td>
          <td><?= esc($employee['position']) ?></td>
          <td><?= esc($employee['username']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="8">No employee records found.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
</body>
</html>
