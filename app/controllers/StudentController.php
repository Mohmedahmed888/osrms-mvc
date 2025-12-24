<?php
namespace App\Controllers;

final class StudentController {
  public function resultsPage(): void {
    require_role('STUDENT');
    $semester = (int)($_GET['semester'] ?? 1);
    $studentId = user()['id'];

    $st = db()->prepare(
      "SELECT c.code, c.name course_name, r.score
       FROM results r
       JOIN submissions s ON s.id=r.submission_id
       JOIN courses c ON c.id=r.course_id
       WHERE r.student_id=? AND r.semester=? AND s.status='APPROVED'
       ORDER BY c.name"
    );
    $st->execute([$studentId,$semester]);
    $rows = $st->fetchAll();

    view('student/results', ['semester'=>$semester,'rows'=>$rows]);
  }

  public function download(): void {
    require_role('STUDENT');
    $semester=(int)($_GET['semester'] ?? 1);

    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="results_sem'.$semester.'.txt"');

    echo "Student: ".user()['name']."\n";
    echo "Semester: $semester\n\n";
    $st = db()->prepare(
      "SELECT c.code, c.name course_name, r.score
       FROM results r
       JOIN submissions s ON s.id=r.submission_id
       JOIN courses c ON c.id=r.course_id
       WHERE r.student_id=? AND r.semester=? AND s.status='APPROVED'
       ORDER BY c.name"
    );
    $st->execute([user()['id'],$semester]);
    foreach ($st->fetchAll() as $r) {
      echo $r['code']." - ".$r['course_name'].": ".$r['score']."\n";
    }
    exit;
  }

  public function printView(): void {
    require_role('STUDENT');
    $semester=(int)($_GET['semester'] ?? 1);
    $studentId=user()['id'];

    $st = db()->prepare(
      "SELECT c.code, c.name course_name, r.score
       FROM results r
       JOIN submissions s ON s.id=r.submission_id
       JOIN courses c ON c.id=r.course_id
       WHERE r.student_id=? AND r.semester=? AND s.status='APPROVED'
       ORDER BY c.name"
    );
    $st->execute([$studentId,$semester]);
    $rows = $st->fetchAll();

    // print without layout
    require __DIR__ . '/../views/student/print.php';
  }
}
