<h2>Add Course</h2>
<form method="post" action="<?= e(BASE_URL) ?>/admin/courses/create" class="box">

  <label>Code</label><input name="code" required placeholder="CS101">
  <label>Name</label><input name="name" required placeholder="Programming">
  <label>Credits</label><input name="credits" type="number" value="3" min="1" max="6">
  <label>Teacher</label>
  <select name="teacher_id">
    <option value="">-- none --</option>
    <?php foreach ($teachers as $t): ?>
      <option value="<?= (int)$t['id'] ?>"><?= e($t['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Save</button>
</form>
