<?php
function db(): PDO {
  static $pdo = null;
  if ($pdo) return $pdo;

  // Edit these if needed
  $host='127.0.0.1';
  $db='osrms_simple';
  $user='root';
  $pass='';

  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
  return $pdo;
}
