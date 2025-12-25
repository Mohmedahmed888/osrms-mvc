<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/db.php';
require __DIR__ . '/view.php';
require __DIR__ . '/helpers.php';

// simple autoload
spl_autoload_register(function($class){
  $prefix = 'App\\';
  if (!str_starts_with($class, $prefix)) return;
  $rel = str_replace('\\','/', substr($class, strlen($prefix)));
  $file = __DIR__ . '/../' . $rel . '.php';
  if (file_exists($file)) require $file;
});
require __DIR__ . '/services.php';
