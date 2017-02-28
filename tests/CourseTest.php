<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Course.php";
    require_once "src/Student.php";
    $server = 'mysql:host=localhost:8889;dbname=school_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_save()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $result = Course::getAll();

            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $id2 = 1;
            $name2 = 'Foo';
            $course_name2 = 'php';
            $test_course2 = new Course($id2, $name2, $course_name2);

            $test_course2->save();

            $result = Course::getAll();

            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function test_deleteAll()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $id2 = 1;
            $name2 = 'Foo';
            $course_name2 = 'php';
            $test_course2 = new Course($id2, $name2, $course_name2);

            $test_course2->save();

            Course::deleteAll();
            $result = Course::getAll();
            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $id2 = 1;
            $name2 = 'Foo';
            $course_name2 = 'php';
            $test_course2 = new Course($id2, $name2, $course_name2);

            $test_course2->save();
            $test_course2->delete();

            $result = Course::getAll();

            $this->assertEquals([$test_course], $result);
        }

        function test_updateName()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $new_name = 'Boo';
            $test_course->updateName($new_name);
            $result = $test_course->getName();

            $this->assertEquals($new_name, $result);
        }

        function test_updateCourseNumber()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $new_course_name = 'Boo';
            $test_course->updateCourseNumber($new_course_name);
            $result = $test_course->getCourseNumber();

            $this->assertEquals($new_course_name, $result);
        }

        function test_find()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $id2 = 1;
            $name2 = 'Foo';
            $course_name2 = 'php';
            $test_course2 = new Course($id2, $name2, $course_name2);

            $test_course2->save();

            $result = Course::find($test_course->getId());

            $this->assertEquals($test_course, $result);
        }
        function test_addStudent()
        {
            $id = 1;
            $name = 'Foo';
            $course_name = 'php';
            $test_course = new Course($id, $name, $course_name);

            $test_course->save();

            $first_name = 'StudentFirst';
            $last_name = 'StudentLast';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(null, $first_name, $last_name, $enrolment_date);
            $test_student->save();

            $test_course->addStudent($test_student);


            $result = $test_course->getStudents();

            $this->assertEquals([$test_student], $result);
        }
    }
?>
