<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Employee</title>
</head>
<body>
<h2>Add New Employee</h2>
<a href="<?= base_url('/') ?>">Back to Employee List</a>
<hr>

<?php if (session()->getFlashdata('error')): ?>
  <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<form action="<?= base_url('employee/insert') ?>" method="post">
  <?= csrf_field() ?>

  <div>
    <label>First Name:</label><br>
    <input type="text" name="fnametxt" value="<?= esc(old('fnametxt')) ?>" required>
  </div>
  <div>
    <label>Last Name:</label><br>
    <input type="text" name="lnametxt" value="<?= esc(old('lnametxt')) ?>" required>
  </div>
  <div>
    <label>Email Address:</label><br>
    <input type="email" name="emailtxt" value="<?= esc(old('emailtxt')) ?>" required>
  </div>
  <div>
    <label>Mobile:</label><br>
    <input type="text" name="mobiletxt" value="<?= esc(old('mobiletxt')) ?>" required>
  </div>
  <div>
    <label>Department:</label><br>
    <input type="text" name="departmenttxt" value="<?= esc(old('departmenttxt')) ?>" required>
  </div>
  <div>
    <label>Position:</label><br>
    <input type="text" name="positiontxt" value="<?= esc(old('positiontxt')) ?>" required>
  </div>
  <div>
    <label>Date of Birth:</label><br>
    <input type="text" name="birthdatetxt" placeholder="MM-DD-YYYY"
           value="<?= esc(old('birthdatetxt')) ?>" required>
  </div>
  <div>
    <label>Username:</label><br>
    <input type="text" name="usernametxt" maxlength="10" value="<?= esc(old('usernametxt')) ?>" required>
  </div>
  <div>
    <label>Password:</label><br>
    <input type="password" name="passwordtxt" required>
  </div>

  <br>
  <button type="submit">Save Employee</button>
</form>
</body>
</html>
