<h2>Admin - Users</h2>
<?php if (!empty($msg)): ?><div class="box ok"><?= e($msg) ?></div><?php endif; ?>
<p><a href="<?= e(BASE_URL) ?>/admin/users/create">Create User</a> | <a href="<?= e(BASE_URL) ?>/admin/courses">Courses</a> | <a href="<?= e(BASE_URL) ?>/admin/approve">Approve Grades</a></p>
<a href="<?= e(BASE_URL) ?>/admin/users/edit?id=<?= (int)$x['id'] ?>">Edit</a>
<table>
  <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
  <?php foreach ($users as $x): ?>
    <tr>
      <td><?= (int)$x['id'] ?></td>
      <td><?= e($x['name']) ?></td>
      <td><?= e($x['email']) ?></td>
      <td><?= e($x['role']) ?></td>
      <td>
        <a href="/admin/users/edit?id=<?= (int)$x['id'] ?>">Edit</a>
        <form method="post" action="<?= e(BASE_URL) ?>/admin/users/delete" style="display:inline">

          <input type="hidden" name="id" value="<?= (int)$x['id'] ?>">
          <button type="submit" class="link">Delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
