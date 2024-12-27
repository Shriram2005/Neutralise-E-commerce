<?php include('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/f00c73d838.js" crossorigin="anonymous"></script>
  <title>Our Approach Management</title>
</head>
<body>
  <?php include('leftbar.php'); ?>

  <main>
    <h1 class="title">Manage Our Approach</h1>
    <ul class="breadcrumbs">
      <li><a href="#">Our Approach</a></li>
      <li class="divider">/</li>
      <li><a href="#" class="active">Dashboard</a></li>
    </ul>
    <br>

    <div class="container-sm mt-4">
      <div class="table-responsive">
        <table class="table table-bordered" style="background-color:white;">
          <thead>
            <tr>
              <th style="padding: 20px">Icon Class</th>
              <th style="padding: 20px">Title</th>
              <th style="padding: 20px">Description</th>
              <th colspan="2" style="padding: 20px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $query = "SELECT * FROM `our_approach`";
              $data = mysqli_query($con, $query);
              $result = mysqli_num_rows($data);

              if ($result) {
                while ($row = mysqli_fetch_array($data)) {
                  ?>
                  <tr style="text-align: center;">
                    <td><i class="<?php echo $row['icon_class']; ?>"></i></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                      <a href="update_ourapproach.php?id=<?php echo $row['id']; ?>">
                        <i class="fa-solid fa-pen-to-square" style="color: #2b6f78;"></i>
                      </a>
                    </td>
                  </tr>
                  <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="4" style="text-align: center;">No records found</td>
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
