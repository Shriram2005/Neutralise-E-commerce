<?php include('connection.php');

if (isset($_POST['update'])) {
    $id = $_GET['id'];

    // Handle uploaded image
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $folder = "contents/promises/" . $file;
    }

    // Sanitize input
    $intro_text = mysqli_real_escape_string($con, $_POST['intro_text']);
    $list_items = mysqli_real_escape_string($con, implode(',', $_POST['list_items']));
    $closing_text = mysqli_real_escape_string($con, $_POST['closing_text']);

    if (!empty($_FILES['image']['name'])) {
        $sql = "UPDATE `our_promise` SET `intro_text`='$intro_text', `list_items`='$list_items', `closing_text`='$closing_text', `image`='$file' WHERE `id` = '$id'";
    } else {
        $sql = "UPDATE `our_promise` SET `intro_text`='$intro_text', `list_items`='$list_items', `closing_text`='$closing_text' WHERE `id` = '$id'";
    }

    $res = mysqli_query($con, $sql);

    if ($res) {
        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($temp, $folder);
        }
        echo "<script>alert('Data Updated Successfully'); window.location.href = 'view_ourpromise.php';</script>";
    } else {
        echo "<script>alert('Failed to update data. Please try again.');</script>";
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM `our_promise` WHERE `id` = '$id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f00c73d838.js" crossorigin="anonymous"></script>
    <title>Update Our Promise</title>
    <style>
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea, .form-group select {
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
        <h1 class="title">Update Our Promise</h1>
        <ul class="breadcrumbs">
            <li><a href="#">Our Promise</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Update</a></li>
        </ul>

        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <!-- Image -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image">
                        <div class="mt-2">
                            Current Image: 
                            <img src="contents/promises/<?php echo $row['image']; ?>" alt="Promise Image" style="width: 150px; height: auto;">
                        </div>
                    </div>
                </div>

                <!-- Intro Text -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="intro_text">Intro Text:</label>
                        <textarea name="intro_text" id="intro_text" rows="5" required><?php echo $row['intro_text']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- List Items -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="list_items">List Items:</label>
                        <input type="text" name="list_items[]" value="<?php echo implode(',', explode(',', $row['list_items'])); ?>" required>
                        <small>Enter comma-separated values (e.g., item 1, item 2, item 3).</small>
                    </div>
                </div>

                <!-- Closing Text -->
                <div class="col-xl-6 col-lg-12">
                    <div class="form-group">
                        <label for="closing_text">Closing Text:</label>
                        <textarea name="closing_text" id="closing_text" rows="5" required><?php echo $row['closing_text']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Buttons -->
                <div class="col-xl-6 col-lg-12">
                    <button type="submit" name="update" class="btn btn-primary btn-min-width">Update Promise</button>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
