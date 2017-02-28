<?php
    require_once "src/Student.php";

    class Course {

        private $id;
        private $name;
        private $course_number;

        function __construct($id, $name, $course_number)
        {
            $this->id = $id;
            $this->name = $name;
            $this->course_number = $course_number;
        }
        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function setCourseNumber($course_number)
        {
            $this->course_number = $course_number;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO courses (name, course_number) VALUES ('{$this->getName()}','{$this->getCourseNumber()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach ($returned_courses as $course) {
                $id = $course['id'];
                $name = $course['name'];
                $course_number = $course['course_number'];
                $new_course = new Course($id, $name, $course_number);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function updateCourseNumber($new_course_number)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_number = '{$new_course_number}' WHERE id = {$this->getId()};");
            $this->setCourseNumber($new_course_number);
        }

        static function find($search_id)
        {
            $found_course = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$search_id};");
            $query = $found_course->fetchAll(PDO::FETCH_ASSOC);
            $id = $query[0]['id'];
            $name = $query[0]['name'];
            $course_number = $query[0]['course_number'];
            $found_course = new Course($id, $name, $course_number );

            return $found_course;
        }

        function addStudent($student)
        {
            $student_id = $student->getId();
            $course_id = $this->getId();
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$course_id}, {$student_id});");
        }
        function getStudents()
        {
            $returned_students = $GLOBALS['DB']->query(
                "SELECT students.*
                FROM courses
                JOIN courses_students ON (courses_students.course_id = courses.id)
                JOIN students ON (students.id = courses_students.student_id)
                WHERE courses.id = {$this->getId()};"
            );
            // var_dump($returned_students);
            $students = array();
            foreach ($returned_students as $student) {
                $id = $student['id'];
                $first_name = $student['first_name'];
                $last_name = $student['last_name'];
                $enrolment_date = $student['enrolment_date'];
                $new_student = new Student($id, $first_name, $last_name, $enrolment_date);
                array_push($students, $new_student);
            }
            return $students;
        }

    }
?>
