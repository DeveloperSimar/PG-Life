<?php
session_start();

$db_host = "127.0.0.1";
$db_user = "root";
$db_pswd = "";
$db_name = "pg_life";

//database connection
$conn = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);
if (!$conn) {
  echo "Connection Failed: " . mysqli_connect_error();
  exit;
};

$user_id = $_SESSION['u_id'];

//fetch user data from database
$sql_1 = "SELECT * FROM users WHERE u_id = $user_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
  echo "Something went wrong!" . mysqli_error($conn);
  return;
}
$user = mysqli_fetch_assoc($result_1);
if (!$user) {
  echo "Something went wrong!";
  return;
}

//get interested propery information using join query
$sql_2 = "SELECT * 
            FROM users_properties as iup
            INNER JOIN properties as p ON iup.property_id = p.p_id
            WHERE iup.user_id = $user_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
  echo "Something went wrong!";
  return;
}
$interested_properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/dashboard.css" />
  <title>Dashboard | PG Life</title>
</head>

<body>
  <div id="main">

    <?php
    include "./includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
      </ol>
    </nav>

    <div class="profile mt-5">
      <div class="heading my-5">
        <h2>My Profile</h2>
      </div>
      <div class="profile-info row">
        <div class="user-pic col-12 col-lg-4">
          <i class="fa-solid fa-user "></i>
        </div>
        <div class="user-info col-12 col-lg-8">
          <div class="user-details">
            <h5><?= $user['u_name'] ?></h5>
            <p><?= $user['gmail'] ?></p>
            <p><?= $user['phno'] ?></p>
            <div class="bottom-info d-flex justify-content-between">
              <p><?= $user['college_name'] ?></p>
              <a href="">Edit profile</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    if (count($interested_properties) > 0) {
    ?>
      <div class="my-interested-properties p-5">
        <div class="page-container">
          <h1 class="pb-3">My Interested Properties</h1>

          <div class="properties container-fluid">

            <?php
            foreach ($interested_properties as $property) {
              $property_images = glob("img/properties/" . $property['p_id'] . "/*");
            ?>

              <div class="property-card row my-3 d-flex align-items-center justify-content-center " prop_no-<?= $property['p_id'] ?>>
                <div class="room-pic col-lg-4 col-12 rounded ">
                  <img src="/<?= $property_images[0] ?>" alt="room photo">
                </div>
                <div class="room-info col-lg-8 col-12 py-3 d-flex flex-column align-items-start">
                  <div class="icons d-flex justify-content-between w-100">

                    <?php
                    $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                    $total_rating = round($total_rating, 1);
                    ?>

                    <div class="stars d-flex align-items-center" title="<?= $total_rating ?>">

                      <?php
                      $rating = $total_rating;
                      for ($i = 0; $i < 5; $i++) {
                        if ($rating >= $i + 0.8) {
                      ?>
                          <i class="fa-solid fa-star"></i>

                        <?php
                        } else {
                        ?>
                          <i class="fa-regular fa-star"></i>
                      <?php
                        }
                      }
                      ?>
                    </div>

                    <div class="like">
                                           
                        <i class="is-interested-image fa-solid fa-heart property-<?= $property['p_id'] ?>" property_id="<?= $property['p_id'] ?>"></i>
                      
                    </div>
                  </div>
                  <h3><?= $property['p_name'] ?></h3>
                  <p><?= $property['address'] ?></p>
                  <?php
                  if ($property['gender'] == "male") {
                  ?>
                    <i class="fa-solid fa-person"></i>
                  <?php
                  } elseif ($property['gender'] == "female") {
                  ?>
                    <i class="fa-solid fa-person-dress border border-start"></i>
                  <?php
                  } else {
                  ?>
                    <i class="fa-solid fa-person"></i>
                    <i class="fa-solid fa-person-dress border border-start"></i>
                  <?php } ?>
                  <div class="price mt-2 d-flex align-items-center justify-content-between w-100">
                    <p><span>₹ <?= number_format($property['price']) ?>/-</span> per month</p>
                    <a href="property_detail.php?property_id=<?= $property['p_id'] ?>"><button type="button" class="btn btn-success px-3 px-lg-5">View</button></a>
                  </div>
                </div>
              </div>

              <?php
              }
              ?>
          </div>        
        </div>
      </div>
    <?php
    }
    ?>

    <?php
    include "./includes/footer.php";
    ?>
  </div>

    <script src="js/dashboard.js"></script>
</body>

</html>