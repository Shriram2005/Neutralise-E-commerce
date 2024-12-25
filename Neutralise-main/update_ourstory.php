<?php include('connection.php');

if (isset($_POST['update'])) {
    $id = $_GET['id'];

    // Handle uploaded image
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $folder = "contents/stories/" . $file;
    }

    // Sanitize input
    $heading = mysqli_real_escape_string($con, $_POST['heading']);
    $text = mysqli_real_escape_string($con, $_POST['text']);
   

    if (!empty($_FILES['image']['name'])) {
        $sql = "UPDATE `our_story` SET `heading`='$heading', `text`='$text', `image`='$file' WHERE `id` = '$id'";
    } else {
        $sql = "UPDATE `our_story` SET `heading`='$heading', `text`='$text' WHERE `id` = '$id'";
    }

    $res = mysqli_query($con, $sql);

    if ($res) {
        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($temp, $folder);
        }
        echo "<script>alert('Data Updated Successfully'); window.location.href = 'view_ourstory.php';</script>";
    } else {
        echo "<script>alert('Failed to update data. Please try again.');</script>";
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM `our_story` WHERE `id` = '$id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style1.css">
    <link rel="icon" href="photos/logo.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://kit.fontawesome.com/be5622a212.js" crossorigin="anonymous"></script>
  <!-- <link rel="stylesheet" href="style.css"> -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <!-- <script src="script.js"></script> -->
      <title>Update Our Story</title>


  
    <style>
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
     <?php include ('leftbar.php');?>

     <main>
            <h1 class="title">Dashboard</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Manage Product</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Dashboard</a></li>
            </ul>
    
       <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
        
        <!-- Heading -->
        <div class="col-xl-6 col-lg-12">
            <div class="form-group">
                <label for="heading">Heading:</label>
                <input type="text" name="heading" id="heading" value="<?php echo $row['heading']; ?>" required>
            </div>
        </div>

        <!-- Image -->
        <div class="col-xl-6 col-lg-12">
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
                <div class="mt-2">
                    Current Image: 
                    <img src="contents/stories/<?php echo $row['image']; ?>" alt="Story Image" style="width: 150px; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
         <!-- Text -->
        <div class="col-xl-6 col-lg-12">
            <div class="form-group">
                <label for="text">Text:</label>
                <textarea name="text" id="text" rows="5" required><?php echo $row['text']; ?></textarea>
            </div>
        </div>
       

      
    </div>

    <!-- <div class="row">
        
    </div> -->

    <div class="row mt-4">
        <!-- Buttons -->
        <div class="col-xl-6 col-lg-12">
            <button type="submit" name="update" class="btn btn-primary btn-min-width">Update Story</button>
        </div>
        <!-- <div class="col-xl-6 col-lg-12">
            <a href="view_story.php" class="btn btn-secondary btn-min-width">Cancel</a>
        </div> -->
    </div>
</form>

   </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
