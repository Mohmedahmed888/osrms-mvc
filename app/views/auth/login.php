<h2>Login</h2>
<?php if (!empty($msg)): ?><div class="box warn"><?= e($msg) ?></div><?php endif; ?>

<form method="post" action="<?= BASE_URL ?>/login" class="box">

  <label>Email</label>
  <input name="email" type="email" required>
  <label>Password</label>
  <input name="password" type="password" required>
  <button type="submit">Login</button>
</form>

<p class="muted">Demo: admin@demo.com / teacher@demo.com / student@demo.com (password 1234)</p>