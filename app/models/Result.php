<?php
namespace App\Models;

final class Result {
  public function __construct(
    public int $result_id,
    public float $score,
    public string $grade,
    public float $gpa
  ) {}

  public function calculate_grade(): string { return $this->grade; }
}
