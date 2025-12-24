<?php
namespace App\Controllers;

final class DashboardController {
  public function index(): void {
    require_login();
    $r = user()['role'];
    if ($r === 'ADMIN') redirect_to('/admin/users');
    if ($r === 'TEACHER') redirect_to('/teacher/marks');
    redirect_to('/student/results');
  }
}
