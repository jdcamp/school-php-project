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
    		return (($this->getFirst_name()) . ($this->getLast_name()));
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

}

?>
