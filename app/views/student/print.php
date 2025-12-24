<!doctype html>
<html>
<head><meta charset="utf-8"><title>Print Results</title></head>
<body onload="window.print()">
<h3>Results - Semester <?= (int)$semester ?></h3>
<p>Student: <?= e(user()['name']) ?></p>
<table border="1" cellpadding="6" cellspacing="0">
  <tr><th>Code</th><th>Course</th><th>Score</th></tr>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= e($r['code']) ?></td>
      <td><?= e($r['course_name']) ?></td>
      <td><?= e((string)$r['score']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
