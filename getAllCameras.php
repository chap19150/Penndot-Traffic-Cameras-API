<?php
$format = isset($_GET['format']) ? strval($_GET['format']) : 'xml';
/* connect to the db - add your own db info*/
$link = mysql_connect('mysql.chapslife.com', 'lc88', 'lkc76lcj') or die('Cannot connect to the DB');
mysql_select_db('penndot_cameras', $link) or die('Cannot select the DB');

$query = "SELECT * FROM cameras";

/* grab the cameras from the db */

$result = mysql_query($query, $link) or die('Errant query:  ' . $query);
/* create one master array of the records */
$cameras = array();
if (mysql_num_rows($result)) {
	while ($camera = mysql_fetch_assoc($result)) {
		$cameras[] = array('camera' => $camera);
	}
}

/* output in necessary format */
if ($format == 'json') {
	header('Content-type: application/json');
	echo json_encode(array('cameras' => $cameras));
} else {
	header('Content-type: text/xml');
	echo '<cameras>';
	foreach ($cameras as $index => $camera) {
		if (is_array($camera)) {
			foreach ($camera as $key => $value) {
				echo '<', $key, '>';
				if (is_array($value)) {
					foreach ($value as $tag => $val) {
						echo '<', $tag, '>',  htmlentities($val), '</', $tag, '>';
					}
				}
				echo '</', $key, '>';
			}
		}
	}
	echo '</cameras>';
}

/* disconnect from the db */
@mysql_close($link);
?>
