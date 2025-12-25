<?php

namespace App\Core;


final class AuthService {
  public function login(string $email, string $pass): ?array {
    $email = trim($email);
    $pass  = trim($pass);

    $st = db()->prepare("SELECT id,name,email,role,password FROM users WHERE email=? LIMIT 1");
    $st->execute([$email]);
    $u = $st->fetch();

    if (!$u || $u['password'] !== $pass) return null;

    return [
      'id' => (int)$u['id'],
      'name' => $u['name'],
      'email' => $u['email'],
      'role' => $u['role']
    ];
  }
}

// -------------------------
// Users Service
// -------------------------
final class UserService {
  public function all(): array {
    return db()->query("SELECT id,name,email,role,password FROM users ORDER BY id DESC")->fetchAll();
  }

  public function find(int $id): ?array {
    $st = db()->prepare("SELECT id,name,email,role,password FROM users WHERE id=? LIMIT 1");
    $st->execute([$id]);
    $row = $st->fetch();
    return $row ?: null;
  }

  public function create(string $name, string $email, string $password, string $role): void {
    $st = db()->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)");
    $st->execute([trim($name), trim($email), trim($password), trim($role)]);
  }

  public function update(int $id, string $name, string $email, string $password, string $role): void {
    $st = db()->prepare("UPDATE users SET name=?, email=?, password=?, role=? WHERE id=?");
    $st->execute([trim($name), trim($email), trim($password), trim($role), $id]);
  }

  public function delete(int $id): void {
    $st = db()->prepare("DELETE FROM users WHERE id=?");
    $st->execute([$id]);
  }
}

// -------------------------
// Courses Service
// -------------------------
final class CourseService {
  public function all(): array {
    return db()->query("SELECT * FROM courses ORDER BY id DESC")->fetchAll();
  }

  public function create(string $code, string $title): void {
    $st = db()->prepare("INSERT INTO courses(code,title) VALUES(?,?)");
    $st->execute([trim($code), trim($title)]);
  }
}

// -------------------------
// Results Service
// -------------------------
final class ResultService {
  public function forStudent(int $studentId, int $semester): array {
    $st = db()->prepare("SELECT * FROM results WHERE student_id=? AND semester=? ORDER BY id DESC");
    $st->execute([$studentId, $semester]);
    return $st->fetchAll();
  }

  public function approveBySemester(int $semester): void {
    // If your schema uses another column (approved/status), change this query accordingly
    $st = db()->prepare("UPDATE results SET approved=1 WHERE semester=?");
    $st->execute([$semester]);
  }
}

// -------------------------
// Factory (returns services)
// -------------------------
final class Services {
  private static ?AuthService $auth = null;
  private static ?UserService $users = null;
  private static ?CourseService $courses = null;
  private static ?ResultService $results = null;

  public static function auth(): AuthService {
    return self::$auth ??= new AuthService();
  }

  public static function users(): UserService {
    return self::$users ??= new UserService();
  }

  public static function courses(): CourseService {
    return self::$courses ??= new CourseService();
  }

  public static function results(): ResultService {
    return self::$results ??= new ResultService();
  }
}
