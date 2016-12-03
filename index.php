<?php
require './common.php';

$html = new HTML;
$all_cities = $sql->getById("SELECT id,name FROM City WHERE type='actual' ORDER BY name");
$all_cities[0] = 'Any';
$all_centers = $sql->getById("SELECT id,name,city_id FROM Center");

$centers = array('0' => array('Any'));
foreach ($all_centers as $this_center_id => $center) {
	if(!isset($centers[$center['city_id']])) {
		$centers[$center['city_id']] = array('0' => 'Any');
	}
	$centers[$center['city_id']][$this_center_id] = $center['name'];
}

$name 		= i($QUERY, 'name');
$sex		= i($QUERY, 'sex');
$city_id	= i($QUERY, 'city_id', 0);
$center_id	= i($QUERY, 'center_id', 0);
$include_deleted_students	= i($QUERY, 'include_deleted_students', 1);
$data 		= array();

if(i($QUERY, 'action')) {
	$checks = array();

	if($name) $checks['name'] = "S.name LIKE '%$name%'";
	if($sex) $checks['sex'] = "S.sex = '$sex'";
	if($center_id) $checks['center_id'] = "S.center_id = '$center_id'";
	if(!$center_id and $city_id) $checks['city_id'] = "S.center_id IN (" . implode(',', $centers[$city_id]) . ")";
	if(!$include_deleted_students) $checks['include_deleted_students'] = "S.status = '1'";

	$data = $sql->getAll("SELECT S.* FROM Student S WHERE " . implode(' AND ', array_values($checks)) . " ORDER BY S.name");
}

render();
