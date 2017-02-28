<?php

    class Student
    {
        private $id;
        private $first_name;
        private $last_name;
        private $enrolment_date;

        function __construct($id = null, $first_name, $last_name, $enrolment_date)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->enrolment_date = $enrolment_date;
            $this->id = $id;
        }

        function getId()
        {
    		return $this->id;
    	}

    	function getFirstName()
        {
    		return $this->first_name;
    	}

    	function setFirstName($first_name)
        {
    		$this->first_name = $first_name;
    	}

    	function getLastName()
        {
    		return $this->last_name;
    	}

    	function setLastName($last_name)
        {
    		$this->last_name = $last_name;
    	}

    	function getEnrolmentDate()
        {
    		return $this->enrolment_date;
    	}

    	function setEnrolmentDate($enrolment_date)
        {
    		$this->enrolment_date = $enrolment_date;
    	}
    	function getFullName()
        {
    		return (($this->getFirstName()) . " " . ($this->getLastName()));
    	}

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (first_name, last_name, enrolment_date) VALUES ('{$this->getFirstName()}','{$this->getLastName()}','{$this->getEnrolmentDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

        static function find($search_id)
        {
            $found_student = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$search_id};");
            $query = $found_student->fetchAll(PDO::FETCH_ASSOC);
            $id = $query[0]['id'];
            $first_name = $query[0]['first_name'];
            $last_name = $query[0]['last_name'];
            $enrolment_date = $query[0]['enrolment_date'];
            $found_student = new Student($id, $first_name, $last_name, $enrolment_date);

            return $found_student;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        function updateFirstName($new_first_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET first_name = '{$new_first_name}' WHERE id = {$this->getId()};");
            $this->setFirstName($new_first_name);
        }
        function updateLastName($new_last_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET last_name = '{$new_last_name}' WHERE id = {$this->getId()};");
            $this->setLastName($new_last_name);
        }
        function updateEnrolmentDate($new_enrolment_date)
        {
            $GLOBALS['DB']->exec("UPDATE students SET enrolment_date = '{$new_enrolment_date}' WHERE id = {$this->getId()};");
            $this->setEnrolmentDate($new_enrolment_date);
        }
        function addCourse($course)
        {
            $course_id = $course->getId();
            $student_id = $this->getId();
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$course_id}, {$student_id});");
        }

        function getCourse()
        {
            $returned_courses = $GLOBALS['DB']->query(
                "SELECT courses.*
                FROM students
                JOIN courses_students ON (courses_students.student_id = students.id)
                JOIN courses ON (courses.id = courses_students.course_id)
                WHERE students.id = {$this->getId()};"
            );

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
}

?>
