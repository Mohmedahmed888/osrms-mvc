# OSRMS — Simple MVC (Plain PHP)

**Very simple** MVC structure (no over-engineering) based on your class diagram:
- User (login/logout)
- Student (view/download/print result)
- Teacher (upload/update/submit final grades)
- Admin (create/edit/delete user, add subject/course, approve grades)
- Result, Course
- Report/Transcript are left as placeholders (methods exist; can be extended)

## Run (XAMPP/Apache)
1) Create DB `osrms_simple`
2) Import: `database/schema.sql`
3) Put folder inside `htdocs` and open:
   - http://localhost/osrms_simple_mvc/public/

## Default logins
- Admin: admin@demo.com / 1234
- Teacher: teacher@demo.com / 1234
- Student: student@demo.com / 1234
