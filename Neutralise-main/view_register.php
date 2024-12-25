<?php include('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/f00c73d838.js" crossorigin="anonymous"></script>
  <title>Register Management</title>
</head>
<body>
  <?php include('leftbar.php'); ?>

  <main>
    <h1 class="title">Manage Registrations</h1>
    <ul class="breadcrumbs">
      <li><a href="#">Register</a></li>
      <li class="divider">/</li>
      <li><a href="#" class="active">Dashboard</a></li>
    </ul>
    <br>

    <div class="container-sm mt-4">
      <div class="table-responsive">
        <table class="table table-bordered" style="background-color:white;">
          <thead>
            <tr>
              <th style="padding: 20px">Full Name</th>
              <th style="padding: 20px">Email</th>
              <th style="padding: 20px">Phone</th>
              <th style="padding: 20px">Address</th>
              <!-- <th colspan="2" style="padding: 20px">Actions</th> -->
            </tr>
          </thead>
          <tbody>
            <?php
              $query = "SELECT * FROM `register`";
              $data = mysqli_query($con, $query);
              $result = mysqli_num_rows($data);

              if ($result) {
                while ($row = mysqli_fetch_array($data)) {
                  ?>
                  <tr style="text-align: center;">
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <!-- <td>
                      <a href="update_register.php?id=<?php echo $row['id']; ?>">
                        <i class="fa-solid fa-pen-to-square" style="color: #2b6f78;"></i>
                      </a>
                    </td>
 -->                  </tr>
                  <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="5" style="text-align: center;">No records found</td>
                </tr>
                <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
