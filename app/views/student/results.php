<h2>Student - Results</h2>

<form method="get" action="<?= e(BASE_URL) ?>/student/results" class="box">

  <label>Semester</label>
  <input name="semester" type="number" value="<?= (int)$semester ?>" min="1">
  <button type="submit">Load</button>
</form>

<div class="box">
  <p>
   <a href="<?= e(BASE_URL) ?>/student/results/download?semester=<?= (int)$semester ?>">Download</a>
   <a href="<?= e(BASE_URL) ?>/student/results/print?semester=<?= (int)$semester ?>" target="_blank">Print</a>

  </p>

  <table>
    <tr><th>Code</th><th>Course</th><th>Score</th></tr>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['code']) ?></td>
        <td><?= e($r['course_name']) ?></td>
        <td><?= e((string)$r['score']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <?php if (empty($rows)): ?><p class="muted">No approved results yet.</p><?php endif; ?>
</div>
