<?php
namespace App\Models;

final class User {
  public function __construct(
    public int $user_id,
    public string $user_name,
    public string $pass,
    public string $role
  ) {}

  public function login(): void {}
  public function logout(): void {}
}
