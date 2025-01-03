<?php
session_start();
include 'check_admin.php';
// Start output buffering at the very beginning
ob_start();
include 'connection.php';

// Handle Delete Action
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    mysqli_query($con, "DELETE FROM testimonials WHERE id = $id");
    header("Location: manage_testimonials.php?success=deleted");
    exit;
}

// Handle Add/Edit Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $date = $_POST['date'];

    // Handle file upload
    $imgSrc = 'users.png'; // Default image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "contents/testimonials/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        // Check if image file is a actual image or fake image
        if (getimagesize($_FILES["image"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $imgSrc = basename($_FILES["image"]["name"]);
            }
        }
    }

    if ($_POST['action'] === 'add') {
        $sql = "INSERT INTO testimonials (name, date, message, rating, imgSrc) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $name, $date, $message, $rating, $imgSrc);
        $stmt->execute();
    } else if ($_POST['action'] === 'edit' && isset($_POST['id'])) {
        $id = $_POST['id'];
        if ($_FILES['image']['error'] == 4) { // No new image uploaded
            $sql = "UPDATE testimonials SET name=?, date=?, message=?, rating=? WHERE id=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssi", $name, $date, $message, $rating, $id);
        } else {
            $sql = "UPDATE testimonials SET name=?, date=?, message=?, rating=?, imgSrc=? WHERE id=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssssi", $name, $date, $message, $rating, $imgSrc, $id);
        }
        $stmt->execute();
    }
    header("Location: manage_testimonials.php?success=saved");
    exit;
}

// Get all testimonials
$testimonials = mysqli_query($con, "SELECT * FROM testimonials ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('header.php')?>

    <main class="testimonials-container">
        <div class="testimonials-header">
            <h1>Manage Testimonials</h1>
            <div class="header-actions">
                <button class="add-testimonial-btn" onclick="openModal()">
                    <i class="fas fa-plus"></i> Add New Testimonial
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if ($_GET['success'] === 'deleted') echo "Testimonial deleted successfully!";
                    if ($_GET['success'] === 'saved') echo "Testimonial saved successfully!";
                ?>
            </div>
        <?php endif; ?>

        <div class="testimonials-grid">
            <?php while ($testimonial = mysqli_fetch_assoc($testimonials)): ?>
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="contents/testimonials/<?php echo htmlspecialchars($testimonial['imgSrc']); ?>" alt="User" class="testimonial-image">
                        <div class="testimonial-info">
                            <h3><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                            <div class="testimonial-date">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo date('F j, Y', strtotime($testimonial['date'])); ?>
                            </div>
                            <div class="testimonial-rating">
                                <?php 
                                    $rating = intval($testimonial['rating']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="testimonial-actions">
                            <button onclick="editTestimonial(<?php echo htmlspecialchars(json_encode($testimonial)); ?>)" class="edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                <input type="hidden" name="delete_id" value="<?php echo $testimonial['id']; ?>">
                                <button type="submit" class="delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo htmlspecialchars($testimonial['message']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Modal for Add/Edit -->
    <div id="testimonialModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add New Testimonial</h2>
            <form method="POST" enctype="multipart/form-data" id="testimonialForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="testimonialId">

                <div class="form-group">
                    <label for="name">Name*</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="date">Date*</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="rating">Rating*</label>
                    <select id="rating" name="rating" required>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message*</label>
                    <textarea id="message" name="message" required rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Profile Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal()" class="cancel-btn">Cancel</button>
                    <button type="submit" class="save-btn">Save</button>
                </div>
            </form>
        </div>
    </div>

<style>
.testimonials-container {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
}

.testimonials-header {
    text-align: center;
    margin-bottom: 3rem;
}

.testimonials-header h1 {
    font-size: 2.5rem;
    color: var(--text-color);
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
    padding-bottom: 15px;
    font-family: var(--font-heading);
}

.testimonials-header h1::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: var(--green-bg-color);
}

.header-actions {
    margin-top: 2rem;
}

.add-testimonial-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
    background-color: var(--green-bg-color);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.add-testimonial-btn:hover {
    background-color: var(--dark-green-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.success-message i {
    font-size: 1.25rem;
    color: #28a745;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

.testimonial-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.testimonial-header {
    padding: 1.5rem;
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    position: relative;
}

.testimonial-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.testimonial-info {
    flex: 1;
}

.testimonial-info h3 {
    margin: 0 0 0.5rem;
    color: var(--text-color);
    font-size: 1.2rem;
    font-weight: 600;
}

.testimonial-date {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.testimonial-rating {
    color: #ffc107;
    font-size: 1rem;
}

.testimonial-rating i {
    margin-right: 2px;
}

.testimonial-content {
    padding: 1.5rem;
    border-top: 1px solid #eee;
}

.testimonial-content p {
    margin: 0;
    color: #444;
    line-height: 1.6;
    font-size: 1rem;
}

.testimonial-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.75rem;
}

.edit-btn,
.delete-btn {
    background: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.edit-btn {
    color: #4CAF50;
}

.delete-btn {
    color: #dc3545;
}

.edit-btn:hover {
    background-color: #4CAF50;
    color: white;
    transform: scale(1.1);
}

.delete-btn:hover {
    background-color: #dc3545;
    color: white;
    transform: scale(1.1);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: white;
    margin: 2rem auto;
    padding: 2.5rem;
    border-radius: 12px;
    max-width: 600px;
    width: 90%;
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.close {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close:hover {
    background-color: #f8f9fa;
    color: #333;
}

.modal-content h2 {
    color: var(--text-color);
    margin-bottom: 2rem;
    font-family: var(--font-heading);
    font-size: 1.8rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.75rem;
    color: #444;
    font-weight: 500;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.875rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--green-bg-color);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2.5rem;
}

.cancel-btn,
.save-btn {
    padding: 0.875rem 2rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.cancel-btn {
    background: none;
    border: 1px solid #ddd;
    color: #666;
}

.save-btn {
    background-color: var(--green-bg-color);
    border: none;
    color: white;
}

.cancel-btn:hover {
    background-color: #f8f9fa;
    border-color: #ccc;
}

.save-btn:hover {
    background-color: var(--dark-green-color);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .testimonials-header h1 {
        font-size: 2rem;
    }

    .testimonials-grid {
        grid-template-columns: 1fr;
    }

    .add-testimonial-btn {
        width: 100%;
        justify-content: center;
    }

    .modal-content {
        padding: 1.5rem;
        margin: 1rem;
        width: calc(100% - 2rem);
    }
}
</style>

<script>
function openModal() {
    document.getElementById('testimonialModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Add New Testimonial';
    document.getElementById('formAction').value = 'add';
    document.getElementById('testimonialForm').reset();
    document.getElementById('testimonialId').value = '';
}

function closeModal() {
    document.getElementById('testimonialModal').style.display = 'none';
}

function editTestimonial(testimonial) {
    document.getElementById('testimonialModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Edit Testimonial';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('testimonialId').value = testimonial.id;
    document.getElementById('name').value = testimonial.name;
    document.getElementById('date').value = testimonial.date;
    document.getElementById('rating').value = testimonial.rating;
    document.getElementById('message').value = testimonial.message;
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == document.getElementById('testimonialModal')) {
        closeModal();
    }
}
</script>

</body>
</html> 