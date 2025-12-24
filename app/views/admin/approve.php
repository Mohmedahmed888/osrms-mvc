<h2>Admin - Approve Grades</h2>
<?php if (!empty($msg)): ?><div class="box ok"><?= e($msg) ?></div><?php endif; ?>
<p><a href="<?= e(BASE_URL) ?>/admin/users">Users</a> | <a href="<?= e(BASE_URL) ?>/admin/courses">Courses</a></p>

<table>
  <tr><th>Submission</th><th>Teacher</th><th>Course</th><th>Semester</th><th>Status</th><th>Action</th></tr>
  <?php foreach ($pending as $p): ?>
    <tr>
      <td><?= (int)$p['id'] ?></td>
      <td><?= e($p['teacher_name']) ?></td>
      <td><?= e($p['code'].' - '.$p['course_name']) ?></td>
      <td><?= (int)$p['semester'] ?></td>
      <td><?= e($p['status']) ?></td>
      <td>
        <form method="post" action="<?= e(BASE_URL) ?>/admin/approve">

          <input type="hidden" name="submission_id" value="<?= (int)$p['id'] ?>">
          <button type="submit">Approve</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<?php if (empty($pending)): ?><p class="muted">No pending submissions.</p><?php endif; ?>
