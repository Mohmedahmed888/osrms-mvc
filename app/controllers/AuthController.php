<?php
namespace App\Controllers;

final class AuthController {
  public function loginForm(): void {
    view('auth/login', ['msg' => flash_get()]);
  }

  public function login(): void {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    $st = db()->prepare("SELECT id,name,email,role,password FROM users WHERE email=? LIMIT 1");
    $st->execute([$email]);
    $u = $st->fetch();

    if (!$u || $u['password'] !== $pass) {
      flash_set("Wrong email/password");
      redirect_to('/login');
    }

    $_SESSION['user'] = [
      'id' => (int)$u['id'],
      'name' => $u['name'],
      'email' => $u['email'],
      'role' => $u['role']
    ];
    redirect_to('/dashboard');
  }

  public function logout(): void {
    $_SESSION = [];
    session_destroy();
    redirect_to('/login');
  }
}
