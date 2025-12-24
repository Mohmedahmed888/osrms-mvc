<h2>Teacher - Marks</h2>
<?php if (!empty($msg)): ?><div class="box ok"><?= e($msg) ?></div><?php endif; ?>

<div class="grid">
  <div class="box">
    <h3>Upload Mark</h3>
    <form method="post" action="<?= e(BASE_URL) ?>/teacher/marks/upload">
      <label>Course</label>
      <select name="course_id" required>
        <?php foreach ($courses as $c): ?>
          <option value="<?= (int)$c['id'] ?>"><?= e($c['code'].' - '.$c['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Student</label>
      <select name="student_id" required>
        <?php foreach ($students as $s): ?>
          <option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Semester</label><input name="semester" type="number" value="1" min="1">
      <label>Score</label><input name="score" type="number" min="0" max="100" step="0.01">

      <button type="submit">Save</button>
    </form>
  </div>

  <div class="box">
    <h3>My Submissions</h3>
    <table>
      <tr><th>ID</th><th>Course</th><th>Sem</th><th>Status</th><th>Submit</th></tr>
      <?php foreach ($subs as $s): ?>
        <tr>
          <td><?= (int)$s['id'] ?></td>
          <td><?= e($s['code'].' - '.$s['course_name']) ?></td>
          <td><?= (int)$s['semester'] ?></td>
          <td><?= e($s['status']) ?></td>
          <td>
            <?php if ($s['status']!=='APPROVED'): ?>
            <form method="post" action="<?= e(BASE_URL) ?>/teacher/marks/submit">
              <input type="hidden" name="submission_id" value="<?= (int)$s['id'] ?>">
              <button type="submit">Submit</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <hr>
    <h4>Update Mark (needs submission id)</h4>
    <form method="post" action="<?= e(BASE_URL) ?>/teacher/marks/update">
      <label>Submission ID</label><input name="submission_id" type="number" required>

      <label>Course</label>
      <select name="course_id" required>
        <?php foreach ($courses as $c): ?>
          <option value="<?= (int)$c['id'] ?>"><?= e($c['code'].' - '.$c['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Student</label>
      <select name="student_id" required>
        <?php foreach ($students as $s): ?>
          <option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Semester</label><input name="semester" type="number" value="1" min="1">
      <label>Score</label><input name="score" type="number" min="0" max="100" step="0.01">
      <button type="submit">Update</button>
      <p class="muted">Update allowed فقط خلال 48 ساعة بعد Submit.</p>
    </form>
  </div>
</div>
