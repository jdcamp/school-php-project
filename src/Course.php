<?php
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

    }
?>
