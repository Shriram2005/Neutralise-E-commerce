document.addEventListener('DOMContentLoaded', function () {
    // Function to get query parameters from URL
    function getQueryParams() {
        const params = {};
        const queryString = window.location.search.substring(1);
        const regex = /([^&=]+)=([^&]*)/g;
        let match;
        while (match = regex.exec(queryString)) {
            params[decodeURIComponent(match[1])] = decodeURIComponent(match[2]);
        }
        return params;
    }

    const params = getQueryParams();
    const productId = params['id'];

    // Fetch the product data
    if (productId) {
        fetchProductData(productId).then(product => {
            updateProductDetails(product);
            updateProductGallery(product);
            updateProductTabs(product);

            // Add event listener to "Add to Cart" button
            const addToCartButton = document.getElementById('add-to-cart-btn');
            addToCartButton.addEventListener('click', function() {
                addToCart(product.id, product.name, product.price, product.mainImage);
            });
        });
    } else {
        console.error('Product ID not found in URL');
    }

    // Handle tab switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.getAttribute('data-tab');

            // Remove 'active' class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Add 'active' class to clicked button and corresponding pane
            button.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });

    // Handle quantity buttons
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');
    const quantityInput = document.getElementById('product-quantity');

    minusBtn.addEventListener('click', () => updateQuantity(-1));
    plusBtn.addEventListener('click', () => updateQuantity(1));

    function updateQuantity(change) {
        let newValue = parseInt(quantityInput.value) + change;
        if (newValue >= 1 && newValue <= 99) {
            quantityInput.value = newValue;
        }
    }

    // Handle size options
    const sizeOptions = document.querySelectorAll('.size-option');
    sizeOptions.forEach(option => {
        option.addEventListener('click', () => {
            sizeOptions.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
        });
    });
});

// Update product details on the page
function updateProductDetails(product) {
    document.getElementById('product-name').textContent = product.name;
    document.getElementById('product-title').textContent = product.name;
    document.getElementById('product-price').textContent = `₹${product.price.toFixed(2)}`;
    document.getElementById('product-short-description').textContent = product.shortDescription;
    document.querySelector('.product-sku').textContent = `SKU: ${product.sku}`;
    // Update other product details as needed
}

// Update product images in gallery
function updateProductGallery(product) {
    document.getElementById('main-product-image').src = product.mainImage;

    const thumbnailsContainer = document.querySelector('.gallery-thumbnails');
    thumbnailsContainer.innerHTML = ''; // Clear existing thumbnails
    product.images.forEach(image => {
        const img = document.createElement('img');
        img.src = image;
        img.alt = product.name;
        img.addEventListener('click', () => {
            document.getElementById('main-product-image').src = image;
        });
        thumbnailsContainer.appendChild(img);
    });
}

// Update product tabs with product-specific information
function updateProductTabs(product) {
    document.getElementById('full-description').textContent = product.fullDescription;

    const ingredientsList = document.getElementById('ingredients-list');
    ingredientsList.innerHTML = ''; // Clear existing ingredients
    product.ingredients.forEach(ingredient => {
        const li = document.createElement('li');
        li.textContent = ingredient;
        ingredientsList.appendChild(li);
    });

    const usageInstructions = document.getElementById('usage-instructions');
    usageInstructions.innerHTML = ''; // Clear existing instructions
    product.howToUse.forEach(instruction => {
        const li = document.createElement('li');
        li.textContent = instruction;
        usageInstructions.appendChild(li);
    });

    const reviewsList = document.getElementById('reviews-list');
    reviewsList.innerHTML = ''; // Clear existing reviews
    product.reviews.forEach(review => {
        const reviewElement = document.createElement('div');
        reviewElement.classList.add('review');
        reviewElement.innerHTML = `
            <h3>${review.author}</h3>
            <p>${review.content}</p>
            <p>Rating: ${review.rating}/5</p>
        `;
        reviewsList.appendChild(reviewElement);
    });
}

// This function should fetch the product data from an array
function fetchProductData(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        return Promise.resolve(product);
    } else {
        return Promise.reject('Product not found');
    }
}

// List of all products (already provided)
const products = [];




