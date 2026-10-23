<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In</title>
<style>
* { box-sizing: border-box; }
body {
  margin: 0;
  min-height: 100vh;
  display: grid;
  place-items: center;
  padding: 24px;
  background: #edf2f0;
  color: #172b28;
  font-family: "Segoe UI", sans-serif;
}
main {
  width: min(100%, 400px);
  padding: 36px;
  background: #fff;
  border: 1px solid #d9e3df;
  border-top: 5px solid #3f1774;
  box-shadow: 0 16px 40px rgba(24, 57, 48, .09);
}
h1 { margin: 0 0 8px; font-size: 1.8rem; }
p { margin: 0 0 24px; color: #5d706b; }
label { display: block; margin: 16px 0 6px; font-weight: 600; }
input {
  width: 100%;
  min-height: 44px;
  padding: 10px 12px;
  border: 1px solid #b9c9c3;
  border-radius: 3px;
  font: inherit;
}
input:focus { outline: 2px solid #3f1774; outline-offset: 2px; }
button {
  width: 100%;
  min-height: 46px;
  margin-top: 24px;
  border: 0;
  border-radius: 3px;
  background: #4a1774;
  color: #fff;
  font: inherit;
  font-weight: 700;
  cursor: pointer;
}
button:hover { background: #4d105c; }
.error {
  margin: 0 0 16px;
  padding: 10px 12px;
  border-left: 3px solid #b33b35;
  background: #fff1ef;
  color: #812923;
}
</style>
</head>
<body>
<main>
  <h1>Sign in</h1>
  <p>Use your employee account to continue.</p>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="error" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <form action="<?= base_url('auth') ?>" method="post">
    <?= csrf_field() ?>

    <label for="username">Username</label>
    <input id="username" name="usernametxt" type="text" autocomplete="username" required autofocus>

    <label for="password">Password</label>
    <input id="password" name="passwordtxt" type="password" autocomplete="current-password" required>

    <button type="submit">Sign in</button>
  </form>
</main>
</body>
</html>
