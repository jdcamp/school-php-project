<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";
    $server = 'mysql:host=localhost:8889;dbname=school_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }

        function test_save()
        {
            $id = 1;
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student($id, $first_name, $last_name, $enrolment_date);

            $test_student->save();

            $result = Student::getAll();

            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(3, $first_name, $last_name, $enrolment_date);
            $test_student->save();

            $first_name2 = 'Foo';
            $last_name2 = 'Bar';
            $enrolment_date2 = '1234-12-12';
            $test_student2 = new Student(4, $first_name2, $last_name2, $enrolment_date2);

            $test_student2->save();

            $result = Student::getAll();

            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function test_deleteAll()
        {
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(null, $first_name, $last_name, $enrolment_date);

            $test_student->save();

            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student2 = new Student(null, $first_name, $last_name, $enrolment_date);

            $test_student2->save();
            Student::deleteAll();
            $result = Student::getAll();

            $this->assertEquals([], $result);
        }
        function test_delete()
        {
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(null, $first_name, $last_name, $enrolment_date);

            $test_student->save();

            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student2 = new Student(null, $first_name, $last_name, $enrolment_date);

            $test_student2->save();
            $test_student2->delete();

            $result = Student::getAll();

            $this->assertEquals([$test_student], $result);
        }

        function test_updateFirstName()
        {
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(null, $first_name, $last_name, $enrolment_date);
            $test_student->save();

            $new_first_name = 'Boo';
            $test_student->updateFirstName($new_first_name);
            $result = $test_student->getFirstName();

            $this->assertEquals($new_first_name, $result);
        }

        function test_updateLasttName()
        {
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(null, $first_name, $last_name, $enrolment_date);
            $test_student->save();

            $new_last_name = 'Boo';
            $test_student->updateLastName($new_last_name);
            $result = $test_student->getLastName();

            $this->assertEquals($new_last_name, $result);
        }
        function test_find()
        {
            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student = new Student(null, $first_name, $last_name, $enrolment_date);

            $test_student->save();

            $first_name = 'Foo';
            $last_name = 'Bar';
            $enrolment_date = '1234-12-12';
            $test_student2 = new Student(null, $first_name, $last_name, $enrolment_date);

            $test_student2->save();
            $result = Student::find($test_student2->getId());

            $this->assertEquals($test_student2, $result);
        }

    }
?>
