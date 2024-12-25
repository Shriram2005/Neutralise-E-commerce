<?php include('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/f00c73d838.js" crossorigin="anonymous"></script>
  <title>Our Promise Management</title>
</head>
<body>
  <?php include('leftbar.php'); ?>

  <main>
    <h1 class="title">Manage Our Promise</h1>
    <ul class="breadcrumbs">
      <li><a href="#">Our Promise</a></li>
      <li class="divider">/</li>
      <li><a href="#" class="active">Dashboard</a></li>
    </ul>
    <br>

    <div class="container-sm mt-4">
      <div class="table-responsive">
        <table class="table table-bordered" style="background-color:white;">
          <thead>
            <tr>
              <th style="padding: 20px">Image</th>
              <th style="padding: 20px">Intro Text</th>
              <th style="padding: 20px">List Items</th>
              <th style="padding: 20px">Closing Text</th>
              <th colspan="2" style="padding: 20px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $query = "SELECT * FROM `our_promise`";  // Adjust table name accordingly
              $data = mysqli_query($con, $query);
              $result = mysqli_num_rows($data);

              if ($result) {
                while ($row = mysqli_fetch_array($data)) {
                  ?>
                  <tr style="text-align: center;">
                    <td><img src="contents/promises/<?php echo $row['image']; ?>" alt="" style="width: 100px; height: auto;"><?php echo $row['image']; ?></td>
                    <td><?php echo $row['intro_text']; ?></td>
                    <td>
                      <ul>
                        <?php 
                          $list_items = explode(',', $row['list_items']);
                          foreach ($list_items as $item) {
                            echo "<li>" . $item . "</li>";
                          }
                        ?>
                      </ul>
                    </td>
                    <td><?php echo $row['closing_text']; ?></td>
                    <td>
                      <a href="update_ourpromise.php?id=<?php echo $row['id']; ?>">
                        <i class="fa-solid fa-pen-to-square" style="color: #2b6f78;"></i>
                      </a>
                    </td>
                  </tr>
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
