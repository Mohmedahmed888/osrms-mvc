<?php
namespace App\Controllers;

use App\Core\Services;

final class AuthController {

  public function loginForm(): void {
    view('auth/login', ['msg' => flash_get()]);
  }

  public function login(): void {
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    $user = Services::auth()->login($email, $pass);

    if (!$user) {
      flash_set("Wrong email/password");
      redirect_to('/login');
    }

    $_SESSION['user'] = $user;
    redirect_to('/dashboard');
  }

  public function logout(): void {
    $_SESSION = [];
    session_destroy();
    redirect_to('/login');
  }
}
