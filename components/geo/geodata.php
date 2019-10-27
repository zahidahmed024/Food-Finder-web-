<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
include "../../config.php";

// if ($_GET['lat']) {
// 	echo json_encode($_GET['lat']);
// }
// print_r($_GET);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	// $d = json_decode(file_get_contents("php://input"), true);
	$centerLat = $_GET['lat'];
	$centerLon = $_GET['lng'];
	$range = (int) $_GET['range'];

	$selected = $_GET['selected'];
	$qu = $_GET['query'];
	$rateOP = $_GET['rateOP'];
	$ob = $_GET['orderby'];

	// echo $centerLat;
// select * from items where item_name like '%d%';

// SELECT *,
	// 	    acos(cos('23.7104' * (PI()/180)) *
	// 	     cos('90.40744' * (PI()/180)) *
	// 	     cos(lat * (PI()/180)) *
	// 	     cos(lon * (PI()/180))
	// 	     +
	// 	     cos('23.7104' * (PI()/180)) *
	// 	     sin('90.40744' * (PI()/180)) *
	// 	     cos(lat * (PI()/180)) *
	// 	     sin(lon * (PI()/180))
	// 	     +
	// 	     sin('23.7104' * (PI()/180)) *
	// 	     sin(lat * (PI()/180))
	// 	    ) * 3959 as Dist
	// 	from info,items WHERE items.item_name like "%do%" and info.token=items.token
	// 		having Dist < 100
	// 		order by Dist

	// $centerLat = 23.7104;
	// $centerLon = 90.40744;

	// $centerLat = '22.974237';
	// $centerLon = '90.222122';
	// $data = [$centerLat, $centerLon];

	// $centerLon = $_GET['lon'];
	// echo json_encode($data['lat']);
	// echo json_encode($centerLon);

	// $query = "SELECT *,
	//     acos(cos('$centerLat' * (PI()/180)) *
	//      cos('$centerLon' * (PI()/180)) *
	//      cos(lat * (PI()/180)) *
	//      cos(lon * (PI()/180))
	//      +
	//      cos('$centerLat' * (PI()/180)) *
	//      sin('$centerLon' * (PI()/180)) *
	//      cos(lat * (PI()/180)) *
	//      sin(lon * (PI()/180))
	//      +
	//      sin('$centerLat' * (PI()/180)) *
	//      sin(lat * (PI()/180))
	//     ) * 3959 as Dist
	// from info
	// having Dist < $range
	// order by Dist";

	if (!empty($_GET['lat']) && !empty($_GET['lng']) && !empty($_GET['selected']) && !empty($_GET['range']) && !empty($_GET['query']) && !empty($_GET['orderby']) && !empty($_GET['rateOP'])) {

		$centerLat = $_GET['lat'];
		$centerLon = $_GET['lng'];
		$range = (int) $_GET['range'];

		$selected = $_GET['selected'];
		$qu = $_GET['query'];
		$rateOP = $_GET['rateOP'];
		$ob = $_GET['orderby'];

		if ($ob == 'ratings') {
			$orderby = 'total';
			$o = 'DESC';
		}if ($ob == 'distance') {
			$orderby = 'Dist';
			$o = 'ASC';
		}

		if ($selected == 'regular' or $selected == 'offer') {
			if ($rateOP == 'rated') {

				$query = "
 SELECT DISTINCT items.item_name,items.image as i_img,items.price,items.item_id,info.*, item_rating.item_id ,count(item_rating.visitor_id) as I_raters,AVG(item_rating.com_price) as com_price,AVG(item_rating.taste) as taste ,ROUND(

AVG((taste + com_price)/2),2) as total ,ROUND(
acos(cos('$centerLat' * (PI()/180)) *
	     cos('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     cos(lon * (PI()/180))
	     +
	     cos('$centerLat' * (PI()/180)) *
	     sin('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     sin(lon * (PI()/180))
	     +
	     sin('$centerLat' * (PI()/180)) *
	     sin(lat * (PI()/180))
	    ) * 3959 ,2)as  Dist
FROM
item_rating,info,items WHERE
 items.item_name like '%$qu%' and items.category='$selected'
  AND item_rating.item_id=items.item_id and items.r_id=info.r_id
GROUP BY item_rating.item_id HAVING Dist < $range ORDER by $orderby $o";
			}
			if ($rateOP == 'notrated') {

				$query = "SELECT DISTINCT items.item_name,items.image as i_img,items.price,items.item_id,info.* ,ROUND( acos(cos('$centerLat' * (PI()/180)) * cos('$centerLon' * (PI()/180)) * cos(lat * (PI()/180)) * cos(lon * (PI()/180)) + cos('$centerLat' * (PI()/180)) * sin('$centerLon' * (PI()/180)) * cos(lat * (PI()/180)) * sin(lon * (PI()/180)) + sin('$centerLat' * (PI()/180)) * sin(lat * (PI()/180)) ) * 3959 ,2)as Dist FROM item_rating,info,items WHERE items.item_name like '%$qu%' and items.item_id not in (SELECT items.item_id from item_rating,items WHERE items.item_id =item_rating.item_id) and items.category='$selected' and items.r_id=info.r_id GROUP BY items.item_id HAVING Dist < $range ORDER by Dist";
			}

		}
////////////////////////////////////////////////////////////////////
		if ($selected == 'restaurant') {
			if ($rateOP == 'rated') {
				$query = "SELECT DISTINCT info.*, res_rating.res_id ,count(res_rating.visitor_id) as raters, AVG(res_rating.environment) as env,AVG(res_rating.service) as service,AVG(res_rating.total) as total,ROUND(
acos(cos('$centerLat' * (PI()/180)) *
	     cos('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     cos(lon * (PI()/180))
	     +
	     cos('$centerLat' * (PI()/180)) *
	     sin('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     sin(lon * (PI()/180))
	     +
	     sin('$centerLat' * (PI()/180)) *
	     sin(lat * (PI()/180))
	    ) * 3959 ,2)as  Dist FROM info,res_rating WHERE info.restaurant_name like '%$qu%' and info.r_id=res_rating.res_id GROUP BY info.r_id HAVING Dist<$range ORDER BY $orderby $o";

			}
			if ($rateOP == 'notrated') {
				$query = "SELECT DISTINCT info.*, res_rating.res_id,ROUND(
          acos(cos('$centerLat' * (PI()/180)) *
	     cos('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     cos(lon * (PI()/180))
	     +
	     cos('$centerLat' * (PI()/180)) *
	     sin('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     sin(lon * (PI()/180))
	     +
	     sin('$centerLat' * (PI()/180)) *
	     sin(lat * (PI()/180))
	    ) * 3959 ,2)as  Dist FROM info,res_rating WHERE info.restaurant_name like '%$qu%'
	     and info.r_id not in (SELECT info.r_id from res_rating,info WHERE info.r_id =res_rating.res_id)
	      GROUP BY info.r_id HAVING Dist<$range ORDER BY Dist DESC";
			}
		}

	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if (!empty($_GET['lat']) && !empty($_GET['lng']) && !empty($_GET['selected']) && !empty($_GET['range'])
		&& !empty($_GET['orderby']) && !empty($_GET['rateOP']) && empty($_GET['query'])) {

		$centerLat = $_GET['lat'];
		$centerLon = $_GET['lng'];
		$range = (int) $_GET['range'];

		$selected = $_GET['selected'];
		// $qu = $_GET['query'];
		$rateOP = $_GET['rateOP'];
		$ob = $_GET['orderby'];

		if ($ob == 'ratings') {
			$orderby = 'total';
			$o = 'DESC';
		}if ($ob == 'distance') {
			$orderby = 'Dist';
			$o = 'ASC';
		}

		if ($selected == 'regular' or $selected == 'offer') {
			if ($rateOP == 'rated') {

				$query = "
 SELECT DISTINCT items.item_name,items.image as i_img,items.price,items.item_id,info.*, item_rating.item_id ,count(item_rating.visitor_id) as I_raters,AVG(item_rating.com_price) as com_price,AVG(item_rating.taste) as taste ,ROUND(

AVG((taste + com_price)/2),2) as total ,ROUND(
acos(cos('$centerLat' * (PI()/180)) *
	     cos('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     cos(lon * (PI()/180))
	     +
	     cos('$centerLat' * (PI()/180)) *
	     sin('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     sin(lon * (PI()/180))
	     +
	     sin('$centerLat' * (PI()/180)) *
	     sin(lat * (PI()/180))
	    ) * 3959 ,2)as  Dist
FROM
item_rating,info,items WHERE items.category='$selected'
  AND item_rating.item_id=items.item_id and items.r_id=info.r_id
GROUP BY item_rating.item_id HAVING Dist < $range ORDER by $orderby $o";
			}
			if ($rateOP == 'notrated') {

				$query = "SELECT DISTINCT items.item_name,items.image as i_img,items.price,items.item_id,info.* ,ROUND( acos(cos('$centerLat' * (PI()/180)) * cos('$centerLon' * (PI()/180)) * cos(lat * (PI()/180)) * cos(lon * (PI()/180)) + cos('$centerLat' * (PI()/180)) * sin('$centerLon' * (PI()/180)) * cos(lat * (PI()/180)) * sin(lon * (PI()/180)) + sin('$centerLat' * (PI()/180)) * sin(lat * (PI()/180)) ) * 3959 ,2)as Dist FROM item_rating,info,items WHERE  items.item_id not in (SELECT items.item_id from item_rating,items WHERE items.item_id =item_rating.item_id) and items.category='$selected' and items.r_id=info.r_id GROUP BY items.item_id HAVING Dist < $range ORDER by Dist";
			}

		}
////////////////////////////////////////////////////////////////////
		if ($selected == 'restaurant') {
			if ($rateOP == 'rated') {
				$query = "SELECT DISTINCT info.*, res_rating.res_id ,count(res_rating.visitor_id) as raters, AVG(res_rating.environment) as env,AVG(res_rating.service) as service,AVG(res_rating.total) as total,ROUND(
acos(cos('$centerLat' * (PI()/180)) *
	     cos('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     cos(lon * (PI()/180))
	     +
	     cos('$centerLat' * (PI()/180)) *
	     sin('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     sin(lon * (PI()/180))
	     +
	     sin('$centerLat' * (PI()/180)) *
	     sin(lat * (PI()/180))
	    ) * 3959 ,2)as  Dist FROM info,res_rating WHERE  info.r_id=res_rating.res_id GROUP BY info.r_id HAVING Dist<$range ORDER BY $orderby $o";

			}
			if ($rateOP == 'notrated') {
				$query = "SELECT DISTINCT info.*, res_rating.res_id ,ROUND(
          acos(cos('$centerLat' * (PI()/180)) *
	     cos('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     cos(lon * (PI()/180))
	     +
	     cos('$centerLat' * (PI()/180)) *
	     sin('$centerLon' * (PI()/180)) *
	     cos(lat * (PI()/180)) *
	     sin(lon * (PI()/180))
	     +
	     sin('$centerLat' * (PI()/180)) *
	     sin(lat * (PI()/180))
	    ) * 3959 ,2)as  Dist FROM info,res_rating WHERE  info.r_id not in (SELECT info.r_id from res_rating,info WHERE info.r_id =res_rating.res_id)
	      GROUP BY info.r_id HAVING Dist<$range ORDER BY Dist ASC";
			}
		}

	}

	$q = mysqli_query($con, $query);
	$count = mysqli_num_rows($q);
	if ($count > 0) {
		while ($row = mysqli_fetch_assoc($q)) {

			$data['data'][] = [
				'res' => $row,
				'position' => ['lat' => (float) $row['lat'], 'lng' => (float) $row['lon']],

				'g' => ['glat' => $centerLat, 'glng' => $centerLon],

			];

		}
		echo json_encode($data);

	} else {
		$data['error'] = "no data";
		echo json_encode($data);
	}
} else {

	$data['error'] = "invalid request";
	echo json_encode($data);

}

//  "SELECT DISTINCT info.*, res_rating.res_id ,count(res_rating.visitor_id) as raters, AVG(res_rating.environment) as env,AVG(res_rating.service) as service ,ROUND(

// AVG((env+ service)/2),2) as total ,ROUND(
// acos(cos('23.7104' * (PI()/180)) *
// 	     cos('90.40744' * (PI()/180)) *
// 	     cos(lat * (PI()/180)) *
// 	     cos(lon * (PI()/180))
// 	     +
// 	     cos('23.7104' * (PI()/180)) *
// 	     sin('90.40744' * (PI()/180)) *
// 	     cos(lat * (PI()/180)) *
// 	     sin(lon * (PI()/180))
// 	     +
// 	     sin('23.7104' * (PI()/180)) *
// 	     sin(lat * (PI()/180))
// 	    ) * 3959 ,2)as  Dist
// FROM
// res_rating,info WHERE
//  info.restaurant_name like '%raj%' and res_rating.res_id=info.r_id
// GROUP BY info.r_id HAVING Dist < 123 ORDER by Dist ASC";

// ROUND(
// acos(cos('23.7104' * (PI()/180)) *
// 	     cos('90.40744' * (PI()/180)) *
// 	     cos(lat * (PI()/180)) *
// 	     cos(lon * (PI()/180))
// 	     +
// 	     cos('23.7104' * (PI()/180)) *
// 	     sin('90.40744' * (PI()/180)) *
// 	     cos(lat * (PI()/180)) *
// 	     sin(lon * (PI()/180))
// 	     +
// 	     sin('23.7104' * (PI()/180)) *
// 	     sin(lat * (PI()/180))
// 	    ) * 3959 ,2)as  Dist

?>

