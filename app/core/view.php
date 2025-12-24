<?php
function view(string $name, array $data=[]): void {
  extract($data);
  require __DIR__ . '/../views/layout/header.php';
  require __DIR__ . '/../views/' . $name . '.php';
  require __DIR__ . '/../views/layout/footer.php';
}
