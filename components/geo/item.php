<?php

include "../../config.php";
include "head.php";
include "geocode.php";
// print_r($_GET);
// echo $_SESSION['uniq_id'];
if ($_GET['item_id'] && $_GET['res_id']) {
	$res_id = $_GET['res_id'];
	$item_id = $_GET['item_id'];
	$visitor_id = $_SESSION['uniq_id'];
	// print_r($_GET);
	// $qu_r = "SELECT DISTINCT info.*, res_rating.res_id ,count(res_rating.visitor_id) as raters, AVG(res_rating.environment) as env,AVG(res_rating.service) as service,AVG(res_rating.total) as total FROM info,res_rating WHERE info.r_id=res_rating.res_id and info.r_id = '$res_id' GROUP BY info.r_id";
	// $q = mysqli_query($con, $qu_r);
	// $count = mysqli_num_rows($q);

/////////////////////////////////////////////////////////////////

	$item_q = "SELECT DISTINCT info.*,items.description as i_des,items.item_name,items.image as i_img,items.price,items.item_id, item_rating.item_id ,count(item_rating.visitor_id) as I_raters,AVG(item_rating.com_price) as com_price,AVG(item_rating.taste) as taste , ROUND(AVG((taste + com_price)/2),2) as total FROM item_rating,info,items WHERE item_rating.item_id=items.item_id and items.r_id=info.r_id and items.item_id ='$item_id' and info.r_id='$res_id' GROUP BY items.item_id ";

	$i_q = mysqli_query($con, $item_q);
	$i_c = mysqli_num_rows($i_q);
	// echo $i_c;
	if ($i_c == 0) {
		$qu_i = "SELECT items.item_name,items.item_id,items.image as i_img ,items.description as i_des , items.price,info.* from items,info where items.item_id='$item_id' and items.r_id=info.r_id and info.r_id='$res_id'";
		$q__item = mysqli_query($con, $qu_i);
		$row_item = mysqli_fetch_assoc($q__item);
		// print_r($row_item);
	}if ($i_c > 0) {
		$row_item = mysqli_fetch_assoc($i_q);
		// print_r($row_item);
	}
	if (!empty($row_item['lat']) && !empty($row_item['lon'])) {
		$address = getLocation($row_item['lat'], $row_item['lon']);
	}

	$res_review = "SELECT item_review.*,visitor.name from item_review,visitor WHERE item_review.item_id='$item_id' and item_review.visitor_id=visitor.uniq_id order by item_review.id asc";

	$review = mysqli_query($con, $res_review);
	$count_review = mysqli_num_rows($review);
	if ($count_review > 0) {
		while ($result_review = mysqli_fetch_assoc($review)) {
			$row_review[] = $result_review;
		}
	}

} else {
	echo 'missing arguments';
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>item</title>
	<!-- <link rel="stylesheet" href="style/star.css"> -->
</head>
<body>
	<div class="container res_info">
<div class="row">
	<div class="col-md-6">
		<div class="card" style="width: 25rem;">
  <img class="card-img-top" src="<?php echo $row_item['i_img'] ?>" alt="Card image cap">
  <div class="card-body">

    <h5 class="card-title"><?php echo $row_item['item_name'] ?></h5>
    <p class="card-text">description:<?php echo $row_item['i_des'] ?></p>
    <p class="card-text">price:<?php echo $row_item['price'] ?></p>
    <p class="card-text">raters:<?php if ($i_c > 0) {echo $row_item['I_raters'];} else {echo 'not rated';}?></p>
    <p class="card-text">avg. comparative price:<?php if ($i_c > 0) {echo $row_item['com_price'];} else {echo 'not rated';}?></p>
    <p class="card-text">avg taste:<?php if ($i_c > 0) {echo $row_item['taste'];} else {echo 'not rated';}?></p>
    <p class="card-text">avg rating:<?php if ($i_c > 0) {echo $row_item['total'];} else {echo 'not rated';}?></p>
    <p class="card-text">restaurant name: <?php echo $row_item['restaurant_name'] ?></p>
    <p class="card-text">address : <?php if ($address) {echo $address;} else {echo 'not rated';}?></p>

    <a href="restaurant.php?res_id=<?php echo $res_id; ?>" class="btn btn-primary">check their restaurant</a>
  </div>
</div>
	</div>

	<div class="col-md-6">
		<div class="card" style="width: 25rem;">
  <div class="card-body">
  <h1> Rate this food</h1>

<form  id="r_form" action="i_rating.php" method="get"">

<h4>Taste:</h4>
<div id="starrating" class="starrating risingstar small d-flex justify-content-center flex-row-reverse">
 <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star">5</label>
<input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star">4</label>
<input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star">3</label>
<input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star">2</label>
<input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">1</label>
  </div>

<h4>comparative price:</h4>
<div  id="starrating2" class="starrating2 risingstar small d-flex justify-content-center flex-row-reverse">
             <input type="radio" id="star6" name="rating2" value="5" /><label for="star6" title="5 star">5</label>
            <input type="radio" id="star7" name="rating2" value="4" /><label for="star7" title="4 star">4</label>
            <input type="radio" id="star8" name="rating2" value="3" /><label for="star8" title="3 star">3</label>
            <input type="radio" id="star9" name="rating2" value="2" /><label for="star9" title="2 star">2</label>
            <input type="radio" id="star10" name="rating2" value="1" /><label for="star10" title="1 star">1</label>
            <input type="hidden" name="item_id" value="<?php echo $row_item['item_id'] ?>" placeholder="">
            <input type="hidden" name="res_id" value="<?php echo $row_item['r_id'] ?>" placeholder="">
<!-- <h4>comparative price:</h4> -->

        </div>

   <button id="sub" class="btn btn-primary center-block" type="submit">submit your rating</button>

  </form>




  </div>
</div>
<div class=" container overflow-auto">

<form action="item_review.php" method="post">
  <input type="text" name="r_cmnt"  placeholder="submit your review...">
  <input type="hidden" name="visitor_id" value="<?php echo $visitor_id ?>" >
  <input type="hidden" name="item_id" value="<?php echo $item_id ?>" >
  <input type="hidden" name="res_id" value="<?php echo $res_id ?>" >
  <input  class="btn btn-info" type="submit" value="submit">
</form>
<p><?php echo $count_review ?> comments</p>
<?php
if ($count_review > 0) {
	// print_r($row_review);

	foreach ($row_review as $review) {?>
 <span class="font-weight-bold"><?php echo $review['name']; ?> : </span>
 <span><?php echo $review['cmnt']; ?></span><br>

<?php }

}?>
</div>



	</div>
</div>

</div>

<script src="bootstrap4/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

// alert('hallo');
var taste=null;
var com_price=null;
 $('#starrating').on('click', 'input[type=radio]', function(evt) {
                // alert($(this).val());
                taste = $(this).val();
                // myFunction(number);
                // check(number);
            });

 $('#starrating2').on('click', 'input[type=radio]', function(evt) {
                // alert($(this).val());
                 com_price = $(this).val();
                // myFunction(number);
                // check(number);
            });




$( "#sub" ).click(function() {

	if (com_price==null || taste==null) {

      alert( 'please select both rating field');

     return false;
	}

});



</script>


</body>
</html>