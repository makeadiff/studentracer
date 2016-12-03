<script type="text/javascript">
var centers = <?php echo json_encode($centers); ?>;
</script>

<h3>Search For Student</h3>

<form action="" method="post" class="form-area">
<?php
$html->buildInput("name", 'Student Name');
$html->buildInput("sex", 'Sex', 'select', '0', array('options' => array('0' => 'Any', 'm' => 'Male', 'f' => 'Female')));

$html->buildInput("city_id", 'City', 'select', $city_id, array('options' => $all_cities));
$html->buildInput("center_id", 'Center', 'select', $center_id, array('options' => $centers[$city_id]));

$html->buildInput("include_deleted_students", 'Include Deleted?', 'checkbox', '1');

$html->buildInput("action", '&nbsp;', 'submit', 'Search', array('class' => 'btn btn-primary'));
?>
</form>


<?php if($data) { ?>
<table class="table table-striped">
<tr><th>ID</th><th>Name</th><th>Sex</th><th>Center</th><th>City</th><th>Status</th></tr>
<?php 
foreach ($data as $row) {
	$center_info = i($all_centers, $row['center_id'], array('id' => 0, 'name' => '', 'city_id' => 0));
	?>
<tr>
	<td><?php echo $row['id'] ?></td>
	<td><?php echo $row['name'] ?></td>
	<td><?php echo $row['sex'] ?></td>
	<td><?php echo $center_info['name']; ?></td>
	<td><?php echo $all_cities[$center_info['city_id']] ?></td>
	<td><?php echo $row['status'] ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>