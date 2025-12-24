<h2>Create User</h2>
<form method="post" action="<?= e(BASE_URL) ?>/admin/users/create" class="box">

  <label>Name</label><input name="name" required>
  <label>Email</label><input name="email" type="email" required>
  <label>Role</label>
  <select name="role">
    <option>ADMIN</option>
    <option>TEACHER</option>
    <option selected>STUDENT</option>
  </select>
  <label>Password</label><input name="password" type="text" value="1234">
  <button type="submit">Save</button>
</form>
