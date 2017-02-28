<?php
date_default_timezone_set('America/Los_Angeles');

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Student.php";
// require_once __DIR__ . "/../src/Client.php";

$app = new Silex\Application();

$app['debug'] = true;

$server = 'mysql:host=localhost:8889;dbname=school';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

$app->get("/", function() use ($app) {
    return $app['twig']->render('homepage.html.twig');
});

$app->get("/students", function() use ($app) {
    return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
});

$app->post("/add_student", function() use ($app) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $enrolment_date = $_POST['enrolment_date'];
    $new_student = new Student(null, $first_name, $last_name, $enrolment_date);
    $new_student->save();
    return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
});
$app->delete("/delete_student/{id}", function($id) use ($app) {
    $student = Student::find($id);
    $student->delete();
    return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
});
$app->delete("/delete_all_students", function() use ($app) {
    Student::deleteAll();
    return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
});

$app->get("/update_student/{id}", function($id) use ($app) {
    $student = Student::find($id);
    return $app['twig']->render('edit_student.html.twig', array('student' => $student));
});


return $app;
?>
