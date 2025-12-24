<?php
require __DIR__ . '/../app/core/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// remove base folder if running in htdocs
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($base && str_starts_with($path, $base)) {
  $path = substr($path, strlen($base));
}
$path = $path ?: '/';

$routes = [
  'GET' => [
    '/' => ['AuthController','loginForm'],
    '/login' => ['AuthController','loginForm'],
    '/logout' => ['AuthController','logout'],
    '/dashboard' => ['DashboardController','index'],

    // Admin
    '/admin/users' => ['AdminController','users'],
    '/admin/users/create' => ['AdminController','createUserForm'],
    '/admin/users/edit' => ['AdminController','editUserForm'],
    '/admin/courses' => ['AdminController','courses'],
    '/admin/courses/create' => ['AdminController','createCourseForm'],
    '/admin/approve' => ['AdminController','approvePage'],

    // Teacher
    '/teacher/marks' => ['TeacherController','marksPage'],

    // Student
    '/student/results' => ['StudentController','resultsPage'],
    '/student/results/download' => ['StudentController','download'],
    '/student/results/print' => ['StudentController','printView'],
  ],
  'POST' => [
    '/login' => ['AuthController','login'],

    // Admin actions
    '/admin/users/create' => ['AdminController','createUser'],
    '/admin/users/edit' => ['AdminController','editUser'],
    '/admin/users/delete' => ['AdminController','deleteUser'],
    '/admin/courses/create' => ['AdminController','createCourse'],
    '/admin/approve' => ['AdminController','approve'],

    // Teacher actions
    '/teacher/marks/upload' => ['TeacherController','upload'],
    '/teacher/marks/update' => ['TeacherController','update'],
    '/teacher/marks/submit' => ['TeacherController','submit'],
  ]
];

$method = $_SERVER['REQUEST_METHOD'];
$handler = $routes[$method][$path] ?? null;

if (!$handler) {
  http_response_code(404);
  echo "404 Not Found";
  exit;
}

[$controller, $action] = $handler;
$cls = "App\\Controllers\\$controller";
$c = new $cls();
$c->$action();
