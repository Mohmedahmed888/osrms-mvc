<?php $u = user(); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OSRMS</title>

  <!-- Use fixed base url so links work inside /mvc1/public -->
  <link rel="stylesheet" href="<?= e(BASE_URL) ?>/assets/style.css">
</head>
<body>
<div class="top">
  <b>OSRMS</b>
  <div>
    <?php if ($u): ?>
      <span class="muted"><?= e($u['name']) ?> (<?= e($u['role']) ?>)</span>
      <a href="<?= e(BASE_URL) ?>/logout">Logout</a>
    <?php endif; ?>
  </div>
</div>
<div class="container">
