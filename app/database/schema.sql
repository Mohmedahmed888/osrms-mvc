CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  role ENUM('ADMIN','TEACHER','STUDENT') NOT NULL,
  password VARCHAR(60) NOT NULL
);

CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(30) NOT NULL UNIQUE,
  name VARCHAR(190) NOT NULL,
  credits INT NOT NULL DEFAULT 3,
  teacher_id INT NULL,
  FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS submissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  teacher_id INT NOT NULL,
  course_id INT NOT NULL,
  semester INT NOT NULL,
  status ENUM('DRAFT','SUBMITTED','APPROVED') NOT NULL DEFAULT 'DRAFT',
  submitted_at DATETIME NULL,
  UNIQUE KEY uniq_sub (teacher_id, course_id, semester),
  FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  submission_id INT NOT NULL,
  student_id INT NOT NULL,
  course_id INT NOT NULL,
  semester INT NOT NULL,
  score DECIMAL(5,2) NOT NULL,
  UNIQUE KEY uniq_res (student_id, course_id, semester),
  FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Seed demo users (password = 1234)
INSERT IGNORE INTO users(name,email,role,password) VALUES
('Admin','admin@demo.com','ADMIN','1234'),
('Teacher','teacher@demo.com','TEACHER','1234'),
('Student','student@demo.com','STUDENT','1234');

-- Seed a course and assign to Teacher (id=2)
INSERT IGNORE INTO courses(code,name,credits,teacher_id) VALUES
('CS101','Programming',3,2);
