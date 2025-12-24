<?php
define('BASE_URL', '/mvc1/public');



function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function redirect_to(string $path): void {
  if (str_starts_with($path, '/')) {
    header("Location: " . BASE_URL . $path);
  } else {
    header("Location: " . $path);
  }
  exit;
}

function url(string $path): string {
  return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}




function user(): ?array { return $_SESSION['user'] ?? null; }

function require_login(): void {
  if (!user()) redirect_to('/login');
}

function require_role(string $role): void {
  require_login();
  if (user()['role'] !== $role) {
    http_response_code(403);
    echo "403 Forbidden";
    exit;
  }
}

function flash_set(string $msg): void { $_SESSION['_flash'] = $msg; }
function flash_get(): ?string {
  $m = $_SESSION['_flash'] ?? null;
  unset($_SESSION['_flash']);
  return $m;
}
