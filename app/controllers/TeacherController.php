<?php
namespace App\Controllers;

final class TeacherController {
  public function marksPage(): void {
    require_role('TEACHER');
    $teacherId = user()['id'];
    $coursesSt = db()->prepare("SELECT id,code,name FROM courses WHERE teacher_id=? ORDER BY name");
    $coursesSt->execute([$teacherId]);
    $courses = $coursesSt->fetchAll();

    $students = db()->query("SELECT id,name,email FROM users WHERE role='STUDENT' ORDER BY name")->fetchAll();

    $subsSt = db()->prepare(
      "SELECT s.id, s.semester, s.status, c.code, c.name course_name
       FROM submissions s
       JOIN courses c ON c.id=s.course_id
       WHERE s.teacher_id=?
       ORDER BY s.id DESC"
    );
    $subsSt->execute([$teacherId]);
    $subs = $subsSt->fetchAll();

    view('teacher/marks', ['courses'=>$courses,'students'=>$students,'subs'=>$subs,'msg'=>flash_get()]);
  }

  private function ensureSubmission(int $teacherId, int $courseId, int $semester): int {
    $st = db()->prepare("SELECT id FROM submissions WHERE teacher_id=? AND course_id=? AND semester=? LIMIT 1");
    $st->execute([$teacherId,$courseId,$semester]);
    $row = $st->fetch();
    if ($row) return (int)$row['id'];

    $ins = db()->prepare("INSERT INTO submissions(teacher_id,course_id,semester,status) VALUES(?,?,?,'DRAFT')");
    $ins->execute([$teacherId,$courseId,$semester]);
    return (int)db()->lastInsertId();
  }

  public function upload(): void {
    require_role('TEACHER');
    $teacherId=user()['id'];
    $courseId=(int)($_POST['course_id'] ?? 0);
    $studentId=(int)($_POST['student_id'] ?? 0);
    $semester=(int)($_POST['semester'] ?? 1);
    $score=(float)($_POST['score'] ?? 0);

    $submissionId = $this->ensureSubmission($teacherId,$courseId,$semester);

    $st = db()->prepare(
      "INSERT INTO results(submission_id,student_id,course_id,semester,score)
       VALUES(?,?,?,?,?)
       ON DUPLICATE KEY UPDATE score=VALUES(score)"
    );
    $st->execute([$submissionId,$studentId,$courseId,$semester,$score]);

    flash_set("Mark saved (draft)");
    redirect_to('/teacher/marks');
  }

  public function update(): void {
    require_role('TEACHER');
    // simple update = same as upload, but requires submission id
    $teacherId=user()['id'];
    $submissionId=(int)($_POST['submission_id'] ?? 0);

    // 48 hours rule after submission time (simple)
    $check = db()->prepare("SELECT submitted_at FROM submissions WHERE id=? AND teacher_id=?");
    $check->execute([$submissionId,$teacherId]);
    $row = $check->fetch();
    if ($row && $row['submitted_at']) {
      $submitted = strtotime($row['submitted_at']);
      if (time() - $submitted > 48*3600) {
        flash_set("Cannot update: 48 hours passed");
        redirect_to('/teacher/marks');
      }
    }

    $courseId=(int)($_POST['course_id'] ?? 0);
    $studentId=(int)($_POST['student_id'] ?? 0);
    $semester=(int)($_POST['semester'] ?? 1);
    $score=(float)($_POST['score'] ?? 0);

    $st = db()->prepare(
      "INSERT INTO results(submission_id,student_id,course_id,semester,score)
       VALUES(?,?,?,?,?)
       ON DUPLICATE KEY UPDATE score=VALUES(score)"
    );
    $st->execute([$submissionId,$studentId,$courseId,$semester,$score]);

    flash_set("Updated");
    redirect_to('/teacher/marks');
  }

  public function submit(): void {
    require_role('TEACHER');
    $teacherId=user()['id'];
    $submissionId=(int)($_POST['submission_id'] ?? 0);
    $st=db()->prepare("UPDATE submissions SET status='SUBMITTED', submitted_at=NOW() WHERE id=? AND teacher_id=?");
    $st->execute([$submissionId,$teacherId]);
    flash_set("Submitted to admin");
    redirect_to('/teacher/marks');
  }
}
