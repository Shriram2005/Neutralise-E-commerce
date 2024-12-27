function goToNextStep(step) {
    console.log(`Navigating to step: ${step}`);
    document.querySelectorAll('.form-section').forEach((el) => el.classList.add('hidden'));
    const stepElement = document.getElementById(`step-${step}`);
    console.log(stepElement); // Log the step element
    if (stepElement) {
        stepElement.classList.remove('hidden');
        updatePageNumber(step);
    } else {
        console.error(`Step ${step} not found`);
    }
}

function goToPreviousStep(step) {
    console.log(`Going back to step: ${step}`);
    document.querySelectorAll('.form-section').forEach((el) => el.classList.add('hidden'));
    document.getElementById(`step-${step}`).classList.remove('hidden');
    updatePageNumber(step);
}

function updatePageNumber(step) {
    document.getElementById('page-number').innerText = `Page ${step} of 3`;
}

// Initialize the first step
document.addEventListener('DOMContentLoaded', () => {
    goToNextStep(1); // Ensure this starts at step 1
});

function showModal(type, percentage) {
    const modalTitle = document.getElementById('modal-title');
    const modalImages = document.getElementById('modal-images');

    modalTitle.innerText = `${type} Images`;
    
    // Change images based on the percentage or type
    modalImages.innerHTML = `
        <img src="/contents/calculator/image1.jpg" alt="${type} Image 1" style="width: 100%; height: auto;">
        <img src="/contents/calculator/image2.jpg" alt="${type} Image 2" style="width: 100%; height: auto;">
        <img src="/contents/calculator/image3.jpg" alt="${type} Image 3" style="width: 100%; height: auto;">
        <img src="/contents/calculator/image4.jpg" alt="${type} Image 4" style="width: 100%; height: auto;">
    `;

    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

// Ensure the modal is hidden on page load
document.addEventListener('DOMContentLoaded', () => {
    closeModal();
});

function generateRandomPercentage() {
    // Generate a random percentage between 10 and 100
    const randomPercentage = Math.floor(Math.random() * (100 - 10 + 1)) + 10;
    
    // Display the random percentage in the text area
    document.getElementById('random-percentage').value = `${randomPercentage}%`;
    
    // Optionally, you can also show a modal with different images based on the context
    showModal('Random Percentage', randomPercentage);
}







// Function to calculate the overall average percentage
// Function to calculate the overall average percentage considering all attributes including skin-area
function calculate() {
    let totalScore = 0;
    let totalMaxScore = 0; // To store the total maximum possible score for all areas

    // Collecting values and calculating score for each section
    const areas = [
        'head_neck', 'hands', 'trunk', 'groin'
    ];

    areas.forEach(area => {
        // Check if the area is marked as 0% (no score)
        if (isAreaZero(area)) {
            // Skip calculation for this area if it's marked as 0%
            return;
        }

        // Get the skin-area value for the area (e.g., 0%, 25%, 50%, 75%, 100%)
        const skinArea = getAreaSkinAreaValue(area);

        // Get the attribute values for each area (redness, thickness, scale, itching)
        const redness = getAreaAttributeValue(area, 'redness');
        const thickness = getAreaAttributeValue(area, 'thickness');
        const scale = getAreaAttributeValue(area, 'scale');
        const itching = getAreaAttributeValue(area, 'itching');

        // Calculate the average for the attributes (redness, thickness, scale, itching)
        const attributesAverage = (redness + thickness + scale + itching) / 4;

        // Calculate the area score by multiplying the skin-area with the attributes average (this is the key difference)
        const areaScore = (attributesAverage * skinArea) / 100; // Scale to percentage

        // Add the area score to the total score
        totalScore += areaScore;

        // Assuming that the max score for each area is 100% (if the skin area is 100% and attributes are at max 4)
        totalMaxScore += 1; // Each area can contribute a maximum of 100% to the total score
    });

    // Calculate the overall average percentage
    const averagePercentage = (totalScore / totalMaxScore) * 100;

    // Display the calculated total score as percentage
    document.getElementById('random-percentage').value = averagePercentage.toFixed(2);

    // Optional: Display the average percentage in a more user-friendly manner
    alert(`The overall average percentage is: ${averagePercentage.toFixed(2)}%`);
}

// Helper function to get the skin-area percentage for an area
function getAreaSkinAreaValue(area) {
    const selectedOption = document.querySelector(`input[name="${area}_skin_area"]:checked`);
    if (selectedOption) {
        return parseInt(selectedOption.value); // Return the percentage value (e.g., 0%, 25%, 50%, etc.)
    }
    return 0; // If no value is selected, return 0%
}

// Helper function to get the value of each attribute for an area
function getAreaAttributeValue(area, attribute) {
    const selectedOption = document.querySelector(`input[name="${area}_${attribute}"]:checked`);
    if (selectedOption) {
        return parseInt(selectedOption.value); // Return value between 0 and 4
    }
    return 0; // If no value is selected, return 0
}

// Helper function to check if an area is marked as 0%
function isAreaZero(area) {
    const zeroOption = document.querySelector(`input[name="${area}_skin_area"][value="0"]`);
    // Check if the 0% option is selected for any field of the area
    return zeroOption && zeroOption.checked;
}






