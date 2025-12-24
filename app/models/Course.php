<?php
namespace App\Models;

final class Course {
  public function __construct(
    public int $course_id,
    public string $course_name,
    public int $credits
  ) {}

  public function get_course_details(): array { return []; }
}
