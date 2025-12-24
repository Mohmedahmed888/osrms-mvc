<h2>Admin - Courses</h2>
<?php if (!empty($msg)): ?><div class="box ok"><?= e($msg) ?></div><?php endif; ?>
<p><a href="<?= e(BASE_URL) ?>/admin/users">Users</a> | <a href="<?= e(BASE_URL) ?>/admin/courses/create">Add Course</a> | <a href="<?= e(BASE_URL) ?>/admin/approve">Approve Grades</a></p>

<table>
  <tr><th>ID</th><th>Code</th><th>Name</th><th>Credits</th><th>Teacher ID</th></tr>
  <?php foreach ($courses as $c): ?>
    <tr>
      <td><?= (int)$c['id'] ?></td>
      <td><?= e($c['code']) ?></td>
      <td><?= e($c['name']) ?></td>
      <td><?= (int)$c['credits'] ?></td>
      <td><?= e((string)$c['teacher_id']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>
