<?php
namespace App\Controllers;

final class AdminController {

  public function users(): void {
    require_role('ADMIN');
    $users = db()->query("SELECT id,name,email,role FROM users ORDER BY id DESC")->fetchAll();
    view('admin/users', ['users'=>$users, 'msg'=>flash_get()]);
  }

  public function createUserForm(): void {
    require_role('ADMIN');
    view('admin/user_create', ['msg'=>flash_get()]);
  }

  public function createUser(): void {
    require_role('ADMIN');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'STUDENT';
    $password = trim($_POST['password'] ?? '1234');

    $st = db()->prepare("INSERT INTO users(name,email,role,password) VALUES(?,?,?,?)");
    $st->execute([$name,$email,$role,$password]);

    flash_set("User created");
    redirect_to('/admin/users');
  }

  public function editUserForm(): void {
    require_role('ADMIN');
    $id = (int)($_GET['id'] ?? 0);
    $st = db()->prepare("SELECT id,name,email,role FROM users WHERE id=?");
    $st->execute([$id]);
    $u = $st->fetch();
    if (!$u) { echo "Not found"; return; }
    view('admin/user_edit', ['u'=>$u]);
  }

  public function editUser(): void {
    require_role('ADMIN');
    $id=(int)($_POST['id'] ?? 0);
    $name=trim($_POST['name'] ?? '');
    $email=trim($_POST['email'] ?? '');
    $role=$_POST['role'] ?? 'STUDENT';
    $st=db()->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $st->execute([$name,$email,$role,$id]);
    flash_set("User updated");
    redirect_to('/admin/users');
  }

  public function deleteUser(): void {
    require_role('ADMIN');
    $id=(int)($_POST['id'] ?? 0);
    $st=db()->prepare("DELETE FROM users WHERE id=?");
    $st->execute([$id]);
    flash_set("User deleted");
    redirect_to('/admin/users');
  }

  public function courses(): void {
    require_role('ADMIN');
    $courses = db()->query("SELECT id,code,name,credits,teacher_id FROM courses ORDER BY id DESC")->fetchAll();
    $teachers = db()->query("SELECT id,name FROM users WHERE role='TEACHER' ORDER BY name")->fetchAll();
    view('admin/courses', ['courses'=>$courses,'teachers'=>$teachers,'msg'=>flash_get()]);
  }

  public function createCourseForm(): void {
    require_role('ADMIN');
    view('admin/course_create', ['msg'=>flash_get()]);
  }

  public function createCourse(): void {
    require_role('ADMIN');
    $code=trim($_POST['code'] ?? '');
    $name=trim($_POST['name'] ?? '');
    $credits=(int)($_POST['credits'] ?? 3);
    $teacherId=(int)($_POST['teacher_id'] ?? 0);

    $st=db()->prepare("INSERT INTO courses(code,name,credits,teacher_id) VALUES(?,?,?,?)");
    $st->execute([$code,$name,$credits,$teacherId ?: null]);

    flash_set("Course added");
    redirect_to('/admin/courses');
  }

  public function approvePage(): void {
    require_role('ADMIN');
    $pending = db()->query(
      "SELECT s.id, c.code, c.name course_name, u.name teacher_name, s.semester, s.status
       FROM submissions s
       JOIN courses c ON c.id=s.course_id
       JOIN users u ON u.id=s.teacher_id
       WHERE s.status='SUBMITTED'
       ORDER BY s.id DESC"
    )->fetchAll();
    view('admin/approve', ['pending'=>$pending,'msg'=>flash_get()]);
  }

  public function approve(): void {
    require_role('ADMIN');
    $submissionId=(int)($_POST['submission_id'] ?? 0);
    $st=db()->prepare("UPDATE submissions SET status='APPROVED' WHERE id=?");
    $st->execute([$submissionId]);
    flash_set("Approved");
    redirect_to('/admin/approve');
  }
}
