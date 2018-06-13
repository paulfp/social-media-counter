<?php
$mySQLuser = 'socialCounter';
$mySQLpass = 'YOUR_DB_PWD';
$mySQLdb = 'socialCounter';

try {
	$dbh = new PDO('mysql:host=localhost;dbname='.$mySQLdb, $mySQLuser, $mySQLpass, array(
		PDO::ATTR_PERSISTENT => true
	));
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}