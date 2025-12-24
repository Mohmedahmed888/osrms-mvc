<h2>Edit User</h2>
<form method="post" action="<?= e(BASE_URL) ?>/admin/users/edit" class="box">

  <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
  <label>Name</label><input name="name" value="<?= e($u['name']) ?>" required>
  <label>Email</label><input name="email" type="email" value="<?= e($u['email']) ?>" required>
  <label>Role</label>
  <select name="role">
    <option <?= $u['role']==='ADMIN'?'selected':'' ?>>ADMIN</option>
    <option <?= $u['role']==='TEACHER'?'selected':'' ?>>TEACHER</option>
    <option <?= $u['role']==='STUDENT'?'selected':'' ?>>STUDENT</option>
  </select>
  <button type="submit">Update</button>
</form>
