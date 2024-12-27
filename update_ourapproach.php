<?php include('connection.php');

if (isset($_POST['update'])) {
    $id = $_GET['id'];

    // Sanitize input
    $icon_class = mysqli_real_escape_string($con, $_POST['icon_class']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Check if an image is uploaded
    
        $sql = "UPDATE `our_approach` SET `icon_class`='$icon_class', `title`='$title', `description`='$description' WHERE `id` = '$id'";
    

    $res = mysqli_query($con, $sql);

    if ($res) {
        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($temp, $folder);
        }
        echo "<script>alert('Data Updated Successfully'); window.location.href = 'view_ourapproach.php';</script>";
    } else {
        echo "<script>alert('Failed to update data. Please try again.');</script>";
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM `our_approach` WHERE `id` = '$id'";
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>Update Our Approach</title>
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
    <?php include('leftbar.php'); ?>

    <main>
        <h1 class="title">Dashboard</h1>
        <ul class="breadcrumbs">
            <li><a href="#">Manage Approach</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Dashboard</a></li>
        </ul>

        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                
                <!-- Icon Class -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="icon_class">Icon Class:</label>
                        <input type="text" name="icon_class" id="icon_class" value="<?php echo $row['icon_class']; ?>" required>
                    </div>
                </div>

                <!-- Title -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Description -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="5" required><?php echo $row['description']; ?></textarea>
                    </div>
                </div>

               
            </div>

            <div class="row mt-4">
                <!-- Buttons -->
                <div class="col-xl-6 col-lg-12">
                    <button type="submit" name="update" class="btn btn-primary btn-min-width">Update Approach</button>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
