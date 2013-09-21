
<?php
/* require the lat lng as the parameters */
if(isset($_GET['lat']) && strval($_GET['lat'])) {

	/* soak in the passed variables or set our own */
	$lat = isset($_GET['lat']) ? strval($_GET['lat']) : '39.952473';
	$lng = isset($_GET['lng']) ? strval($_GET['lng']) : '-75.164106';
	$radius = isset($_GET['radius']) ? strval($_GET['radius']) : '10';
	$count = isset($_GET['count']) ? strval($_GET['count']) : '20';
        $format = isset($_GET['format']) ? strval($_GET['format']) : 'xml';

	/* connect to the db - add your own db info*/
	$link = mysql_connect('server','username','password') or die('Cannot connect to the DB');
	mysql_select_db('penndot_cameras',$link) or die('Cannot select the DB');
	
		$query = "SELECT id, lng, lat, name, road, road_id, url , ( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( lat ) ) * COS( RADIANS( lng ) - RADIANS( $lng ) ) + SIN( RADIANS( '$lat' ) ) * SIN( RADIANS( lat ) ) ) ) AS distance FROM cameras
HAVING distance < $radius
ORDER BY distance
LIMIT 0 , $count";
	
	/* grab the cameras from the db */
	
	
	$result = mysql_query($query,$link) or die('Errant query:  '.$query);
	/* create one master array of the records */
	$cameras = array();
	if(mysql_num_rows($result)) {
		while($camera = mysql_fetch_assoc($result)) {
			$cameras[] = array('camera'=>$camera);
		}
	}

	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('cameras'=>$cameras));
	}
	else {
		header('Content-type: text/xml');
		echo '<cameras>';
		foreach($cameras as $index => $camera) {
			if(is_array($camera)) {
				foreach($camera as $key => $value) {
					echo '<',$key,'>';
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</cameras>';
	}

	/* disconnect from the db */
	@mysql_close($link);
}
?>
