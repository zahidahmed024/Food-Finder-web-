<?php
include "../../config.php";
include "head.php";
include "geocode.php";

// echo $_SESSION['uniq_id'];

// print_r($_GET);
if (!empty($_GET['res_id'])) {
	$res_id = $_GET['res_id'];
	$visitor_id = $_SESSION['uniq_id'];
	$qu_r = "SELECT DISTINCT info.*, res_rating.res_id ,count(res_rating.visitor_id) as raters, AVG(res_rating.environment) as env,AVG(res_rating.service) as service,ROUND(AVG(res_rating.total),2) as total FROM info,res_rating WHERE info.r_id=res_rating.res_id and info.r_id = '$res_id' GROUP BY info.r_id";
	$q = mysqli_query($con, $qu_r);
	$count = mysqli_num_rows($q);
	if ($count == 0) {
		$qu_nr = "SELECT * from info where info.r_id='$res_id'";
		$qn = mysqli_query($con, $qu_nr);
		$row_r = mysqli_fetch_assoc($qn);
		// print_r($row_r);
	}
	if ($count > 0) {
		$row_r = mysqli_fetch_assoc($q);
		// print_r($row_r);
	}

	if (!empty($row_r['lat']) && !empty($row_r['lon'])) {
		$address = getLocation($row_r['lat'], $row_r['lon']);
	}

	$rated_i = "SELECT DISTINCT items.*,count(item_rating.visitor_id) as I_raters,AVG(item_rating.com_price) as com_price,AVG(item_rating.taste) as taste ,ROUND( AVG((taste + com_price)/2),2) as total FROM item_rating,items WHERE item_rating.item_id=items.item_id and items.r_id='$res_id' GROUP BY items.item_id ORDER by total";
	$qr_i = mysqli_query($con, $rated_i);
	$count_ri = mysqli_num_rows($qr_i);
	if ($count_ri > 0) {
		while ($result_r = mysqli_fetch_assoc($qr_i)) {
			$row_i[] = $result_r;
		}
	}
	$i_nt = "SELECT DISTINCT items.* FROM item_rating,items WHERE items.item_id NOT IN( (SELECT items.item_id from item_rating,items WHERE items.item_id =item_rating.item_id)) and items.r_id='$res_id' GROUP BY items.item_id";
	$in_q = mysqli_query($con, $i_nt);
	$count_ni = mysqli_num_rows($in_q);
	if ($count_ni > 0) {
		while ($result_nr = mysqli_fetch_assoc($in_q)) {
			$row_nr[] = $result_nr;
		}
	}

	$res_review = "SELECT res_review.*,visitor.name from res_review,visitor WHERE res_review.res_id='$res_id' and res_review.visitor_id=visitor.uniq_id order by res_review.id asc";

	$review = mysqli_query($con, $res_review);
	$count_review = mysqli_num_rows($review);
	if ($count_review > 0) {
		while ($result_review = mysqli_fetch_assoc($review)) {
			$row_review[] = $result_review;
		}
	}

}
?>
	<div class="container-fluid res_info">
			</br>
<div class="row">
	<div class="col-md-3">
		<div class="card" style="width: 25rem;">
  <img class="card-img-top" src="<?php echo $row_r['image'] ?>" alt="Card image cap">
  <div class="card-body">

    <h5 class="card-title"><?php echo $row_r['restaurant_name'] ?></h5>
    <p class="card-text">description:<?php echo $row_r['description'] ?></p>
    <p class="card-text">starting_time:<?php echo $row_r['starting_time'] ?></p>
    <p class="card-text">ending_time:<?php echo $row_r['ending_time'] ?></p>
    <p class="card-text">contact:<?php echo $row_r['contact'] ?></p>
    <p class="card-text">raters:<?php if ($count > 0) {echo $row_r['raters'];} else {echo 'not rated';}?></p>
    <p class="card-text">avg. env:<?php if ($count > 0) {echo $row_r['env'];} else {echo 'not rated';}?></p>
    <p class="card-text">avg service:<?php if ($count > 0) {echo $row_r['service'];} else {echo 'not rated';}?></p>
    <p class="card-text">avg rating:<?php if ($count > 0) {echo $row_r['total'];} else {echo 'not rated';}?></p>
    <p class="card-text">address : <?php if ($address) {echo $address;} else {echo 'not rated';}?></p>

    <!-- <a href="restaurant.php?res_id=<?php echo $res_id; ?>" class="btn btn-primary">check their restaurant</a> -->
  </div>
</div>
	</div>

	<div class="col-md-3">
		<div class="card" style="width: 25rem;">
  <div class="card-body">
  <h4> Rate This Restaurant</h4>
  <hr>

  <form action="r_rating.php" method="get" accept-charset="utf-8">
<h5>environment:</h5>
<div id="starrating" class="starrating risingstar small d-flex justify-content-center flex-row-reverse">
 <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star">5</label>
<input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star">4</label>
<input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star">3</label>
<input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star">2</label>
<input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">1</label>

  </div>
<h5>service:</h5>
<div id="starrating2" class="starrating2 risingstar small d-flex justify-content-center flex-row-reverse">
             <input type="radio" id="star6" name="rating2" value="5" /><label for="star6" title="5 star">5</label>
            <input type="radio" id="star7" name="rating2" value="4" /><label for="star7" title="4 star">4</label>
            <input type="radio" id="star8" name="rating2" value="3" /><label for="star8" title="3 star">3</label>
            <input type="radio" id="star9" name="rating2" value="2" /><label for="star9" title="2 star">2</label>
            <input type="radio" id="star10" name="rating2" value="1" /><label for="star10" title="1 star">1</label>
            <input type="hidden" name="res_id" value="<?php echo $row_r['r_id'] ?>" placeholder="">
<!-- <h4>comparative price:</h4> -->
        </div>
   <button id="sub" class="btn btn-primary center-block" type="submit">submit your rating</button>
  </form>
  </div>
</div>

<div class=" container overflow-auto">

<form action="res_review.php" method="post">
  <input type="text" name="r_cmnt"  placeholder="submit your review...">
  <input type="hidden" name="visitor_id" value="<?php echo $visitor_id ?>" >
  <input type="hidden" name="res_id" value="<?php echo $res_id ?>" >
  <input  class="btn btn-info" type="submit" name="" value="submit">
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

<div class="col-md-6">
	<h3>Food Items</h3>
	</hr>
<div class="container-fluid">


	<div class="row">

        <?php
if ($count_ri > 0) {
	foreach ($row_i as $row_i) {?>

 <div class="card" style="width: 15rem;height:5%; ">
  <img class="card-img-top" style="height: 20%" src="<?php echo $row_i['image'] ?>" alt="Card image cap">
  <div class="card-body">

    <h5 class="card-title"><?php echo $row_i['item_name'] ?></h5>
    <p class="card-text">description:<?php echo $row_i['description'] ?></p>
    <p class="card-text">price:<?php echo $row_i['price'] ?></p>
    <p class="card-text">category:<?php echo $row_i['category'] ?></p>
    <p class="card-text">raters:<?php echo $row_i['I_raters'] ?></p>
    <p class="card-text">avg com_price:<?php echo $row_i['com_price'] ?></p>
    <p class="card-text">avg taste:<?php echo $row_i['taste'] ?></p>
    <p class="card-text">avg total:<?php echo $row_i['total'] ?></p>

    <a href="item.php?item_id=<?php echo $row_i['item_id'] ?>&&res_id=<?php echo $row_i['r_id']; ?>" class="btn btn-primary">rate this food</a>
  </div>

	</div>
   <?php }
}
?>

<?php
if ($count_ni > 0) {
	foreach ($row_nr as $row_nr) {?>

 <div class="card" style="width: 15rem;height:30rem; ">
  <img class="card-img-top" style="height: 20%" src="<?php echo $row_nr['image'] ?>" alt="Card image cap">
  <div class="card-body">

    <h5 class="card-title"><?php echo $row_nr['item_name'] ?></h5>
    <p class="card-text">description:<?php echo $row_nr['description'] ?></p>
    <p class="card-text">price:<?php echo $row_nr['price'] ?></p>
    <p class="card-text">category:<?php echo $row_nr['category'] ?></p>
    <a href="item.php?item_id=<?php echo $row_nr['item_id'] ?>&&res_id=<?php echo $row_nr['r_id'] ?>" class="btn btn-primary">rate this food</a>
  </div>

	</div>
   <?php }
}
?>

	</div>

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

