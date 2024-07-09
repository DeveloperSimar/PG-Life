<?php
session_start();

$db_host = "127.0.0.1";
$db_user = "root";
$db_pswd = "";
$db_name = "pg_life";

//database conntion
$conn = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);
if (!$conn) {
    echo "Connection Failed: " . mysqli_connect_error();
    exit;
};

//get property and city id
$property_id = $_GET['property_id'];
$city_id = $_GET['c_id'];
$user_id = isset($_SESSION['u_id']) ? $_SESSION['u_id'] : NULL;

//fetch property data
$sql = "select * from properties where p_id = $property_id";
$result = mysqli_query($conn, $sql);
if(!$result){
  echo "Something went wrong!" . mysqli_error($conn);
}
$property = mysqli_fetch_assoc($result);

$sql_2 = "select * from testimonials where property_id = $property_id";

$result_2 = mysqli_query($conn, $sql_2);
if(!$result_2){
  echo "Something went wrong!" . mysqli_error($conn);
}

$properties_testimonials = mysqli_fetch_all($result_2, MYSQLI_ASSOC);

//interested user's properties
$sql_3 = "SELECT * 
            FROM users_properties iup
            INNER JOIN properties p ON iup.property_id = p.p_id
            WHERE p.city_id = $city_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo "Something went wrong!";
    return;
}
$users_properties = mysqli_fetch_all($result_3, MYSQLI_ASSOC);

//amenities and properties data
$sql_5 = "select * from properties_amenities p_a inner join amenities a on p_a.amenity_id = a.a_id where p_a.property_id = $property_id";

$result_5 = mysqli_query($conn, $sql_5);
if(!$result_5){
  echo "Something went wrong!" . mysqli_error($conn);
}

$amenities = mysqli_fetch_all($result_5, MYSQLI_ASSOC);

$sql_6 = "select * from cities where c_id = $city_id";
$result_6 = mysqli_query($conn, $sql_6);
if(!$result_6){
  echo "Something went wrong!" . mysqli_error($conn);
}

$city = mysqli_fetch_assoc($result_6);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $property['p_name'] ?> | PG Life</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/property_detail.css" rel="stylesheet" />
  </head>

  <body>
    
    <?php
      include "./includes/header.php";
    ?>


    <nav aria-label="breadcrumb">
      <ol class="breadcrumb py-2">
        <li class="breadcrumb-item">
          <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="propertyList.php?city=<?= $city['c_name'] ?>"><?= $city['c_name'] ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <?= $property['p_name'] ?>
        </li>
      </ol>
    </nav>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
    <?php 
      $property_images = glob('img/properties/'.$property_id.'/*');
    ?>
  <div class="carousel-inner">
    <?php 
      foreach ($property_images as $image) {
    ?>
    <div class="carousel-item active">
      <img src="/<?= $image ?>" class="d-block w-100" alt="...">
    </div>
    <?php } ?>
  </div>
</div>

    <div class="property-summary page-container">
      <div class="row no-gutters justify-content-between">
        <div class="star-container" title="4.8">

          <?php 
            $rating = round((($property['rating_clean']+$property['rating_food']+$property['rating_safety'])/3),1);

            for($i=0;$i<5;$i++){
              if($rating > $i+0.5){
          ?>
             <i class="fas fa-star"></i>
          <?php 
              } else{
          ?>
              <i class="fa-regular fa-star"></i>
          <?php
              }
            }
          ?>
              
        </div>
        <div class="interested-container">
        <?php
                            $user_like = false;
                            foreach ($users_properties as $interested_user_property) {
                                if ($interested_user_property['user_id'] == $user_id) {
                                    $user_like = true;
                                }
                            }
                            if($user_like){
           ?>
           <i class="is-interested-image fa-solid fa-heart"></i>
           <?php } else{ ?>
          <i class="is-interested-image far fa-heart"></i>
          <?php } ?>
          <div class="interested-text">

          <?php
                            $interested_users_count = 0;
                            foreach ($users_properties as $interested_user_property) {
                                if ($interested_user_property['property_id'] == $property['p_id']) {
                                    $interested_users_count++;
                                }
                            }
           ?>

            <span class="interested-user-count"><?= $interested_users_count ?></span> interested
          </div>
        </div>
      </div>
      <div class="detail-container">
        <div class="property-name"><?= $property['p_name'] ?></div>
        <div class="property-address">
          <?= $property['address'] ?>
        </div>
        <div class="property-gender">

            <?php 
              if($property['gender']=="male"){
            ?>
              <img src="/img/male.png" />
            <?php 
              } elseif($property['gender']=='female'){
            ?>
              <img src="/img/female.png" alt="female">
            <?php 
              } else{
            ?>
              <img src="/img/unisex.png" alt="unisex">
            <?php 
              }
            ?>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="rent-container col-6">
          <div class="rent">₹ <?= number_format($property['price']) ?>/-</div>
          <div class="rent-unit">per month</div>
        </div>
        <div class="button-container col-6">
          <a href="#" class="btn btn-primary">Book Now</a>
        </div>
      </div>
    </div>

    <div class="property-amenities">
      <div class="page-container">
        <h1>Amenities</h1>
        <div class="row justify-content-between">
          <div class="col-md-auto">
            <h5>Building</h5>
            <?php 
            foreach ($amenities as $amenity) {
              if($amenity['type']=="Building"){
            ?>
            <div class="amenity-container">
              <img src="/img/amenities/<?= $amenity['icon'] ?>.svg" />
              <span><?= $amenity['a_name'] ?></span>
            </div>
            <?php 
              }
             }
            ?>
          </div>

          <div class="col-md-auto">
            <h5>Common Area</h5>
            <?php 
            foreach ($amenities as $amenity) {
              if($amenity['type']=="Common Area"){
            ?>
            <div class="amenity-container">
              <img src="/img/amenities/<?= $amenity['icon'] ?>.svg" />
              <span><?= $amenity['a_name'] ?></span>
            </div>
            <?php 
              }
             }
            ?>
          </div>

          <div class="col-md-auto">
            <h5>Bedroom</h5>
            <?php 
            foreach ($amenities as $amenity) {
              if($amenity['type']=="Bedroom"){
            ?>
            <div class="amenity-container">
              <img src="/img/amenities/<?= $amenity['icon'] ?>.svg" />
              <span><?= $amenity['a_name'] ?></span>
            </div>
            <?php 
              }
             }
            ?>
          </div>

          <div class="col-md-auto">
            <h5>Washroom</h5>
            <?php 
            foreach ($amenities as $amenity) {
              if($amenity['type']=="Washroom"){
            ?>
            <div class="amenity-container">
              <img src="/img/amenities/<?= $amenity['icon'] ?>.svg" />
              <span><?= $amenity['a_name'] ?></span>
            </div>
            <?php 
              }
             }
            ?>
          </div>
        </div>
      </div>
    </div>

    <div class="property-about page-container">
      <h1>About the Property</h1>
      <p>
        <?= $property['description'] ?>
      </p>
    </div>

    <div class="property-rating">
      <div class="page-container">
        <h1>Property Rating</h1>
        <div class="row align-items-center justify-content-between">
          <div class="col-md-6">
            <div class="rating-criteria row">
              <div class="col-6">
                <i class="rating-criteria-icon fas fa-broom"></i>

                <?php
                        $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                        $total_rating = round($total_rating, 1);
                        $rating = $total_rating
                ?>

                <span class="rating-criteria-text">Cleanliness</span>
              </div>
              <div class="rating-criteria-star-container col-6" title="4.3">

              <?php          
                  for($i=0;$i<5;$i++){
                    if($property['rating_clean']>$i+0.5){
              ?>
                <i class="fas fa-star"></i>
                
              <?php 
                } else{
              ?>
                <i class="fa-regular fa-star"></i>
              <?php 
                }
               }
              ?>

              </div>
            </div>

            <div class="rating-criteria row">
              <div class="col-6">
                <i class="rating-criteria-icon fas fa-utensils"></i>
                <span class="rating-criteria-text">Food Quality</span>
              </div>
              <div class="rating-criteria-star-container col-6" title="3.4">
              <?php          
                  for($i=0;$i<5;$i++){
                    if($property['rating_food']>$i+0.5){
              ?>
                <i class="fas fa-star"></i>
                
              <?php 
                } else{
              ?>
                <i class="fa-regular fa-star"></i>
              <?php 
                }
               }
              ?>
              </div>
            </div>

            <div class="rating-criteria row">
              <div class="col-6">
                <i class="rating-criteria-icon fa fa-lock"></i>
                <span class="rating-criteria-text">Safety</span>
              </div>
              <div class="rating-criteria-star-container col-6" title="4.8">
              <?php          
                  for($i=0;$i<5;$i++){
                    if($property['rating_safety']>$i+0.5){
              ?>
                <i class="fas fa-star"></i>
                
              <?php 
                } else{
              ?>
                <i class="fa-regular fa-star"></i>
              <?php 
                }
               }
              ?>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="rating-circle">
              <div class="total-rating"><?= $rating ?></div>
              <div class="rating-circle-star-container">
              <?php          
                  for($i=0;$i<5;$i++){
                    if($rating>$i+0.5){
              ?>
                <i class="fas fa-star"></i>
                
              <?php 
                } else{
              ?>
                <i class="fa-regular fa-star"></i>
              <?php 
                }
               }
              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="property-testimonials page-container">
      <h1>What people say</h1>
      <div class="testimonial-block">
        <?php
          foreach($properties_testimonials as $feedback){
         ?>
        <div class="testimonial-image-container">
          <img class="testimonial-img" src="/img/man.png" />
        </div>
        <div class="testimonial-text">
          <i class="fa fa-quote-left" aria-hidden="true"></i>
          <p>
            <?= $feedback['content'] ?>
          </p>
        </div>
        <?php 
          $user_di_id = $feedback['user_id'];
          $sql_4 = "select u_name from users where u_id = $user_di_id";
          $result_4 = mysqli_query($conn, $sql_4);
          if(!$result_4){
            echo "Something went wrong!" . mysqli_error($conn);
          }
          $row_4 = mysqli_fetch_assoc($result_4);
        ?>
        <div class="testimonial-name">- <?= $row_4['u_name'] ?></div>
        <?php 
          }
        ?>
      </div>
    </div>

    <div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signup-heading" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signup-heading">Signup with PGLife</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="signup-form" class="form" role="form"
                     method="post" action="./php/signup.php">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="full_name" placeholder="Full Name" maxlength="30" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" maxlength="10" minlength="10" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" minlength="6" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-university"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="college_name" placeholder="College Name" maxlength="150" required>
                        </div>

                        <div class="form-group">
                            <span>I'm a</span>
                            <input type="radio" class="ml-3" id="gender-male" name="gender" value="male" /> Male
                            <label for="gender-male">
                            </label>
                            <input type="radio" class="ml-3" id="gender-female" name="gender" value="female" />
                            <label for="gender-female">
                                Female
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Create Account</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <span>Already have an account?
                        <a href="" data-dismiss="modal" data-bs-toggle="modal" data-bs-target="#login-modal">Login</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-heading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="login-heading">Login with PGLife</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="login-form" class="form" role="form" 
                     method="post" action="./php/login.php" >
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" minlength="6" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <span >
                        <a href="" data-dismiss="modal" data-bs-toggle="modal" data-bs-target="#signup-modal">Click here</a>
                        to register a new account
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php
      include "./includes/footer.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/common.js"></script>
    <script src="js/property_detail.js"></script>
  </body>
</html>
