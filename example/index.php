<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once "../framework/WireFactory.php";
	
$base = array(
	array(
		"class" => "classes.Application",
		"args" => array(
			array("class" => "classes.note.NoteWriter"),
			array("value" => "views/write_form.php")
		)
	),
	array(
		"class" => "classes.note.NoteWriter",
		"args" => array(
			array("class" => "classes.note.NoteStorage")
		)
	),
	array(
		"class" => "classes.note.SQLNoteStorage"
	)
);

$override = array_merge($base, array(
	array(
		"class" => "classes.note.XmlFileNoteStorage"
	)
));

$factory = new WireFactory($override);

$application = $factory->getInstance("classes.Application");

$application->run();
