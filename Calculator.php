<?php
// Include database connection
include('connection.php');

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    
    // Handle file upload
    $upload_dir = "contents/calculator/";
    $uploaded_file = $upload_dir . basename($_FILES["image_path"]["name"]);
    move_uploaded_file($_FILES["image_path"]["tmp_name"], $uploaded_file);

    // Head and Neck Data
    $head_neck_skin_area = $_POST['head_neck_skin_area'];
    $head_neck_redness = $_POST['head_neck_redness'];
    $head_neck_thickness = $_POST['head_neck_thickness'];
    $head_neck_scale = $_POST['head_neck_scale'];
    $head_neck_itching = $_POST['head_neck_itching'];

    // Hands Data
    $hands_skin_area = $_POST['hands_skin_area'];
    $hands_redness = $_POST['hands_redness'];
    $hands_thickness = $_POST['hands_thickness'];
    $hands_scale = $_POST['hands_scale'];
    $hands_itching = $_POST['hands_itching'];

    // Trunk Data
    $trunk_skin_area = $_POST['trunk_skin_area'];
    $trunk_redness = $_POST['trunk_redness'];
    $trunk_thickness = $_POST['trunk_thickness'];
    $trunk_scale = $_POST['trunk_scale'];
    $trunk_itching = $_POST['trunk_itching'];

    // Groin Data
    $groin_skin_area = $_POST['groin_skin_area'];
    $groin_redness = $_POST['groin_redness'];
    $groin_thickness = $_POST['groin_thickness'];
    $groin_scale = $_POST['groin_scale'];
    $groin_itching = $_POST['groin_itching'];

     // Calculate the scores for each section
    $head_neck_score = $head_neck_skin_area + $head_neck_redness + $head_neck_thickness + $head_neck_scale + $head_neck_itching;
    $hands_score = $hands_skin_area + $hands_redness + $hands_thickness + $hands_scale + $hands_itching;
    $trunk_score = $trunk_skin_area + $trunk_redness + $trunk_thickness + $trunk_scale + $trunk_itching;
    $groin_score = $groin_skin_area + $groin_redness + $groin_thickness + $groin_scale + $groin_itching;

    // Calculate total score
    $total_score = $head_neck_score + $hands_score + $trunk_score + $groin_score;


     // Prepare SQL to insert data, including the calculated total score
    $sql = "INSERT INTO psoriasis_data (
                first_name, last_name, mobile, image_path,
                head_neck_skin_area, head_neck_redness, head_neck_thickness, head_neck_scale, head_neck_itching,
                hands_skin_area, hands_redness, hands_thickness, hands_scale, hands_itching,
                trunk_skin_area, trunk_redness, trunk_thickness, trunk_scale, trunk_itching,
                groin_skin_area, groin_redness, groin_thickness, groin_scale, groin_itching,
                total_score
            ) VALUES (
                '$first_name', '$last_name', '$mobile', '$uploaded_file',
                '$head_neck_skin_area', '$head_neck_redness', '$head_neck_thickness', '$head_neck_scale', '$head_neck_itching',
                '$hands_skin_area', '$hands_redness', '$hands_thickness', '$hands_scale', '$hands_itching',
                '$trunk_skin_area', '$trunk_redness', '$trunk_thickness', '$trunk_scale', '$trunk_itching',
                '$groin_skin_area', '$groin_redness', '$groin_thickness', '$groin_scale', '$groin_itching',
                '$total_score'
            )";



    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($con);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=86400">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neutralise Naturals</title>

    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/calculator.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jacques+Francois&display=swap"
        rel="stylesheet">
</head>


<body>
    <!-------- Navbar --------->
   <?php include 'header.php';?>

    <section class="psoriasis-calculator">
        <div class="page-number" id="page-number">Page 1 of 3</div>
        <form id="multi-step-form" method="POST" enctype="multipart/form-data">
            <div class="form-section" id="step-1">
                <h2>Step 1: Personal Information</h2>
                <div class="input-container">
                    <div class="form-group">
                        <label for="first-name">First Name*</label>
                        <input type="text" id="first-name" name="first_name" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name*</label>
                        <input type="text" id="last-name" name="last_name" placeholder="Enter your last name" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number*</label>
                        <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                    </div>
                    <div class="form-group">
                        <label for="file-upload">Upload Image of Affected Skin Area*</label>
                        <input type="file" id="file-upload" name="image_path" required>
                    </div>
                </div>
                
                <!-- Head and Neck Section -->
                <div class="head-neck-container">
                    <div class="title-overlay">Head and Neck</div>
                    <div class="content">
                        <img src="./contents/calculator/Head_neck.png" alt="Head and Neck" class="head-neck-image">
                        <div class="assessment">
                            <h3>Skin Area Involved</h3>
                            <div class="radio-group">
                                <label><input type="radio" name="head_neck_skin_area" value="0" required> 0%</label>
                                <label><input type="radio" name="head_neck_skin_area" value="10" required> 10%</label>
                                <label><input type="radio" name="head_neck_skin_area" value="25" required> 25%</label>
                                <label><input type="radio" name="head_neck_skin_area" value="40" required> 40%</label>
                                <label><input type="radio" name="head_neck_skin_area" value="60" required> 60%</label>
                                <label><input type="radio" name="head_neck_skin_area" value="75" required> 75%</label>
                                <label><input type="radio" name="head_neck_skin_area" value="90" required> 90%</label>
                            </div>
                
                            <div class="severity-assessment">
                                <h4>Redness</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="head_neck_redness" value="0" required> 0</label>
                                    <label><input type="radio" name="head_neck_redness" value="1" required> 1</label>
                                    <label><input type="radio" name="head_neck_redness" value="2" required> 2</label>
                                    <label><input type="radio" name="head_neck_redness" value="3" required> 3</label>
                                    <label><input type="radio" name="head_neck_redness" value="4" required> 4</label>
                                    <!-- <button type="button" class="view-btn" onclick="showModal('Redness')">View</button> -->
                                </div>
                
                                <h4>Thickness</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="head_neck_thickness" value="0" required> 0</label>
                                    <label><input type="radio" name="head_neck_thickness" value="1" required> 1</label>
                                    <label><input type="radio" name="head_neck_thickness" value="2" required> 2</label>
                                    <label><input type="radio" name="head_neck_thickness" value="3" required> 3</label>
                                    <label><input type="radio" name="head_neck_thickness" value="4" required> 4</label>
                                    <!-- <button type="button" class="view-btn" onclick="showModal('Thickness')">View</button> -->
                                </div>
                
                                <h4>Scale</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="head_neck_scale" value="0" required> 0</label>
                                    <label><input type="radio" name="head_neck_scale" value="1" required> 1</label>
                                    <label><input type="radio" name="head_neck_scale" value="2" required> 2</label>
                                    <label><input type="radio" name="head_neck_scale" value="3" required> 3</label>
                                    <label><input type="radio" name="head_neck_scale" value="4" required> 4</label>
                                </div>
                
                                <h4>Itching</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="head_neck_itching" value="0" required> 0</label>
                                    <label><input type="radio" name="head_neck_itching" value="1" required> 1</label>
                                    <label><input type="radio" name="head_neck_itching" value="2" required> 2</label>
                                    <label><input type="radio" name="head_neck_itching" value="3" required> 3</label>
                                    <label><input type="radio" name="head_neck_itching" value="4" required> 4</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hands Section -->
                <div class="head-neck-container">
                    <div class="title-overlay">Hands</div>
                    <div class="content">
                        <img src="./contents/calculator/hands.png" alt="Hands" class="head-neck-image">
                        <div class="assessment">
                            <h3>Skin Area Involved</h3>
                            <div class="radio-group">
                                <label><input type="radio" name="hands_skin_area" value="0" required> 0%</label>
                                <label><input type="radio" name="hands_skin_area" value="10" required> 10%</label>
                                <label><input type="radio" name="hands_skin_area" value="25" required> 25%</label>
                                <label><input type="radio" name="hands_skin_area" value="40" required> 40%</label>
                                <label><input type="radio" name="hands_skin_area" value="60" required> 60%</label>
                                <label><input type="radio" name="hands_skin_area" value="75" required> 75%</label>
                                <label><input type="radio" name="hands_skin_area" value="90" required> 90%</label>
                            </div>
                
                            <div class="severity-assessment">
                                <h4>Redness</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="hands_redness" value="0" required> 0</label>
                                    <label><input type="radio" name="hands_redness" value="1" required> 1</label>
                                    <label><input type="radio" name="hands_redness" value="2" required> 2</label>
                                    <label><input type="radio" name="hands_redness" value="3" required> 3</label>
                                    <label><input type="radio" name="hands_redness" value="4" required> 4</label>
                                    <!-- <button type="button" class="view-btn" onclick="showModal('Redness Hands')">View</button> -->
                                </div>
                
                                <h4>Thickness</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="hands_thickness" value="0" required> 0</label>
                                    <label><input type="radio" name="hands_thickness" value="1" required> 1</label>
                                    <label><input type="radio" name="hands_thickness" value="2" required> 2</label>
                                    <label><input type="radio" name="hands_thickness" value="3" required> 3</label>
                                    <label><input type="radio" name="hands_thickness" value="4" required> 4</label>
                                    <!-- <button type="button" class="view-btn" onclick="showModal('Thickness Hands')">View</button> -->
                                </div>
                
                                <h4>Scale</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="hands_scale" value="0" required> 0</label>
                                    <label><input type="radio" name="hands_scale" value="1" required> 1</label>
                                    <label><input type="radio" name="hands_scale" value="2" required> 2</label>
                                    <label><input type="radio" name="hands_scale" value="3" required> 3</label>
                                    <label><input type="radio" name="hands_scale" value="4" required> 4</label>
                                </div>
                
                                <h4>Itching</h4>
                                <div class="radio-group">
                                    <label><input type="radio" name="hands_itching" value="0" required> 0</label>
                                    <label><input type="radio" name="hands_itching" value="1" required> 1</label>
                                    <label><input type="radio" name="hands_itching" value="2" required> 2</label>
                                    <label><input type="radio" name="hands_itching" value="3" required> 3</label>
                                    <label><input type="radio" name="hands_itching" value="4" required> 4</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="next-btn" onclick="goToNextStep(2)">Next</button>
                
                <!-- Modal for Images -->
                <div id="modal" class="modal hidden">
                    <div class="modal-content" style="width: 80%; height: auto;">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2 id="modal-title"></h2>
                        <div id="modal-images" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                            <!-- Images will be injected here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="form-section hidden" id="step-2">
                <h2>Step 2: Skin Area Assessment</h2>
                
                <!-- Legs Section -->
                <div class="legs-container">
                    <div class="title-overlay">Trunk</div>
                    <div class="content">
                        <div class="assessment">
                            <h3>Skin Area Involved</h3>
                            <div class="radio-group">
                                <label><input type="radio" name="trunk_skin_area" value="0" required> 0%</label>
                                <label><input type="radio" name="trunk_skin_area" value="10" required> 10%</label>
                                <label><input type="radio" name="trunk_skin_area" value="25" required> 25%</label>
                                <label><input type="radio" name="trunk_skin_area" value="40" required> 40%</label>
                                <label><input type="radio" name="trunk_skin_area" value="60" required> 60%</label>
                                <label><input type="radio" name="trunk_skin_area" value="75" required> 75%</label>
                                <label><input type="radio" name="trunk_skin_area" value="90" required> 90%</label>
                            </div>
                        </div>
                        <img src="./contents/calculator/Trunk.png" alt="Legs" class="legs-image"> <!-- Replace with actual image path -->
                    </div>
                    <!-- Severity Assessment Section -->
                <div class="severity-assessment-container">
                    <h3>Severity Assessment</h3>
                    <div class="severity-assessment">
                        <h4>Redness</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="trunk_redness" value="0" required> 0</label>
                            <label><input type="radio" name="trunk_redness" value="1" required> 1</label>
                            <label><input type="radio" name="trunk_redness" value="2" required> 2</label>
                            <label><input type="radio" name="trunk_redness" value="3" required> 3</label>
                            <label><input type="radio" name="trunk_redness" value="4" required> 4</label>
                            <!-- <button type="button" class="view-btn" onclick="showModal('Redness Legs')">View</button> -->
                        </div>
            
                        <h4>Thickness</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="trunk_thickness" value="0" required> 0</label>
                            <label><input type="radio" name="trunk_thickness" value="1" required> 1</label>
                            <label><input type="radio" name="trunk_thickness" value="2" required> 2</label>
                            <label><input type="radio" name="trunk_thickness" value="3" required> 3</label>
                            <label><input type="radio" name="trunk_thickness" value="4" required> 4</label>
                            <!-- <button type="button" class="view-btn" onclick="showModal('Thickness Legs')">View</button> -->
                        </div>
            
                        <h4>Scale</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="trunk_scale" value="0" required> 0</label>
                            <label><input type="radio" name="trunk_scale" value="1" required> 1</label>
                            <label><input type="radio" name="trunk_scale" value="2" required> 2</label>
                            <label><input type="radio" name="trunk_scale" value="3" required> 3</label>
                            <label><input type="radio" name="trunk_scale" value="4" required> 4</label>
                        </div>
            
                        <h4>Itching</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="trunk_itching" value="0" required> 0</label>
                            <label><input type="radio" name="trunk_itching" value="1" required> 1</label>
                            <label><input type="radio" name="trunk_itching" value="2" required> 2</label>
                            <label><input type="radio" name="trunk_itching" value="3" required> 3</label>
                            <label><input type="radio" name="trunk_itching" value="4" required> 4</label>
                        </div>
                    </div>
                </div>
            

                <!--  -->
                
                </div>
                <div class="legs-container">
                    <div class="title-overlay">Groin and Buttocks</div>
                    <div class="content">
                        <div class="assessment">
                            <h3>Skin Area Involved</h3>
                            <div class="radio-group">
                                <label><input type="radio" name="groin_skin_area" value="0" required> 0%</label>
                                <label><input type="radio" name="groin_skin_area" value="10" required> 10%</label>
                                <label><input type="radio" name="groin_skin_area" value="25" required> 25%</label>
                                <label><input type="radio" name="groin_skin_area" value="40" required> 40%</label>
                                <label><input type="radio" name="groin_skin_area" value="60" required> 60%</label>
                                <label><input type="radio" name="groin_skin_area" value="75" required> 75%</label>
                                <label><input type="radio" name="groin_skin_area" value="90" required> 90%</label>
                            </div>
                        </div>
                        <img src="./contents/calculator/Trunk.png" alt="Legs" class="legs-image"> <!-- Replace with actual image path -->
                    </div>
                    <!-- Severity Assessment Section -->
                <div class="severity-assessment-container">
                    <h3>Severity Assessment</h3>
                    <div class="severity-assessment">
                        <h4>Redness</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="groin_redness" value="0" required> 0</label>
                            <label><input type="radio" name="groin_redness" value="1" required> 1</label>
                            <label><input type="radio" name="groin_redness" value="2" required> 2</label>
                            <label><input type="radio" name="groin_redness" value="3" required> 3</label>
                            <label><input type="radio" name="groin_redness" value="4" required> 4</label>
                            <!-- <button type="button" class="view-btn" onclick="showModal('Redness Legs')">View</button> -->
                        </div>
            
                        <h4>Thickness</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="groin_thickness" value="0" required> 0</label>
                            <label><input type="radio" name="groin_thickness" value="1" required> 1</label>
                            <label><input type="radio" name="groin_thickness" value="2" required> 2</label>
                            <label><input type="radio" name="groin_thickness" value="3" required> 3</label>
                            <label><input type="radio" name="groin_thickness" value="4" required> 4</label>
                            <!-- <button type="button" class="view-btn" onclick="showModal('Thickness Legs')">View</button> -->
                        </div>
            
                        <h4>Scale</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="groin_scale" value="0" required> 0</label>
                            <label><input type="radio" name="groin_scale" value="1" required> 1</label>
                            <label><input type="radio" name="groin_scale" value="2" required> 2</label>
                            <label><input type="radio" name="groin_scale" value="3" required> 3</label>
                            <label><input type="radio" name="groin_scale" value="4" required> 4</label>
                        </div>
            
                        <h4>Itching</h4>
                        <div class="radio-group">
                            <label><input type="radio" name="groin_itching" value="0" required> 0</label>
                            <label><input type="radio" name="groin_itching" value="1" required> 1</label>
                            <label><input type="radio" name="groin_itching" value="2" required> 2</label>
                            <label><input type="radio" name="groin_itching" value="3" required> 3</label>
                            <label><input type="radio" name="groin_itching" value="4" required> 4</label>
                        </div> 
                    </div>
                </div>


            
                <button type="button" class="calculate-btn" onclick="calculate()">Calculate</button>
                <button type="submit" class="submit-btn" name="submit">Submit</button>
                
                <!-- Text area for displaying the random percentage -->
                <div id="percentage-output" style="margin-top: 15px;">
                    <textarea id="random-percentage" rows="2" cols="20" readonly style="resize: none;"></textarea>
                </div>
            
            
                <!-- Modal for Images -->
                <div id="modal" class="modal hidden">
                    <div class="modal-content" style="width: 80%; height: auto;">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2 id="modal-title"></h2>
                        <div id="modal-images" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                            <!-- Images will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    
    <!-- Footer --------------------------------------->
    

<?php include('footer.php');?>

    <script src="./js/script.js" defer></script>
    <script src="./js/calculator.js"></script>
</body>

</html>