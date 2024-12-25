

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style1.css">
  
  <title>AdminSite</title>
</head>
<body>

  



  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand" style="text-decoration:none;"><i class='bx bxs-smile icon'></i> AdminSite</a>
    <ul class="side-menu"> 
      <li><a href="r1.php" class="active" style="text-decoration:none;"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
      <li class="divider" data-text="main" style="text-decoration:none;">Main</li>

      <li><a href="view_register.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Reg_users</span></a></li>
      <li><a href="view_ourstory.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Our Story</span></a></li>

      <li><a href="view_ourapproach.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Our Approach</span></a></li>

      <li><a href="view_ourpromise.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Our Promise</span></a></li>



      <li><a href="insert_product.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Products</span></a></li>

      <li><a href="view_testimonials.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Testimonials</span></a></li>

      
      
      <!-- <li><a href="subscriber.php" style="text-decoration:none;"><i class='bx bxs-group icon' ></i> <span id="a">Subscribers</span></a></li> -->

  
    </ul>
   
  </section>
  <section id="content">

     <nav>
      <i class='bx bx-menu toggle-sidebar' ></i>
      <form action="#">
        <div class="form-group">
          <input type="text" placeholder="Search...">
          <i class='bx bx-search icon' ></i>
        </div>
      </form>

      
      <!-- <input type="checkbox" id="switch-mode" hidden>
      <label for="switch-mode" class="switch-mode"></label> -->
      <a href="#" class="nav-link">
        <i class='bx bxs-bell icon' ></i>
        <span class="badge" style="margin-right:10px"></span>
      </a>
      <!-- <a href="#" class="nav-link">
        <i class='bx bxs-message-square-dots icon' ></i>
        <span class="badge">10</span>
      </a> -->
      <span class="divider"></span>
      <div class="profile">
        <img src="images/p.jpg" alt="">
        <ul class="profile-link">
          <li><a href="admin_profile.php" style="text-decoration:none;"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
          <!-- <li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li> -->
          <li><a href="logout.php" style="text-decoration:none;"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
        </ul>
      </div>
    </nav>






