<header role="navbar" class="position-sticky bg-light">
  <nav class="navbar d-flex">
    <div class="container-fluid">
      <a class="navbar-brand col" href="index.php"><img src="/img/logo.png" alt="PG Life logo" /></a>

      <?php
      if (!isset($_SESSION['u_name'])) {
      ?>
        <div class="options col text-end d-md-none">
          <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i class="fa-solid fa-list"></i></button>

          <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasTopLabel">Options:</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body row">

              <div class="sign-up col-12" data-bs-toggle="modal" data-bs-target="#signup-modal">
                <i class="fa-solid fa-user"></i>
                <button type="button" class="btn border-0">
                  Singup
                </button>
              </div>

              <div class="log-in col-12 border-start border-2 border-opacity-25 border-secondary" data-bs-toggle="modal" data-bs-target="#login-modal">
                <i class="fa-solid fa-right-to-bracket"></i>
                <button type="button" class="btn">Login</button>
              </div>
            </div>
          </div>
        </div>

        <div class="buttons d-none d-md-flex justify-content-end align-items-center w-100 col">
          <div class="row">
            <div class="sign-up col" data-bs-toggle="modal" data-bs-target="#signup-modal">
              <i class="fa-solid fa-user"></i>
              <button type="button" class="btn border-0">
                Singup
              </button>
            </div>
            <div class="log-in col border-start border-2 border-opacity-25 border-secondary" data-bs-toggle="modal" data-bs-target="#login-modal">
              <i class="fa-solid fa-right-to-bracket"></i>
              <button type="button" class="btn">Login</button>
            </div>
          </div>
        </div>

      <?php
      } else {
      ?>

        <div class=" h-100 d-flex justify-content-end w-50 col">
          <h5>Hi,<?= $_SESSION['u_name'] ?></h5>
        </div>

        <div class="options col text-end d-md-none">
          <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i class="fa-solid fa-list"></i></button>

          <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasTopLabel">Options:</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body row">

              <div class="sign-up col">
                <a href="dashboard.php">
                  <i class="fa-solid fa-user"></i>
                  <button type="button" class="btn border-0">
                    Dashboard
                  </button>
                </a>
              </div>
              <div class="log-in col border-start border-2 border-opacity-25 border-secondary">
                <a href="./php/logout.php">
                  <i class="fa-solid fa-right-to-bracket"></i>
                  <button type="button" class="btn">Logout</button></a>
              </div>
            </div>
          </div>
        </div>

        <div class="buttons d-none d-md-flex justify-content-end align-items-center w-100 col">
          <div class="row">

            <div class="sign-up col">
              <a href="dashboard.php">
                <i class="fa-solid fa-user"></i>
                <button type="button" class="btn border-0">
                  Dashboard
                </button>
              </a>
            </div>
            <div class="log-in col border-start border-2 border-opacity-25 border-secondary">
              <a href="./php/logout.php">
                <i class="fa-solid fa-right-to-bracket"></i>
                <button type="button" class="btn">Logout</button></a>
            </div>

          </div>
        </div>

      <?php
      };
      ?>

    </div>
  </nav>
</header>

<div id="loading"></div>