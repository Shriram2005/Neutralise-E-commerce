// js/cart.js

function addToCart(id, name, price, image, size = null) {
    // Create form data
    const formData = new FormData();
    formData.append('product_id', id);
    formData.append('quantity', document.getElementById('product-quantity')?.value || 1);
    if (size) {
        formData.append('size_option', size);
    }

    // Show loading state
    showModal('Adding to cart...');

    // Send AJAX request
    fetch('cart_actions.php?action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            updateCartIcon();
            showModal(`${name} has been added to your cart.`);
        } else {
            showModal(data.message || 'Error adding item to cart. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showModal('Error adding item to cart. Please check your connection and try again.');
    });
}

function updateCartIcon() {
    fetch('cart_actions.php?action=count')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.setAttribute('data-count', data.count || 0);
            cartIcon.style.display = (data.count > 0) ? 'inline-block' : 'none';
        }
    })
    .catch(error => {
        console.error('Error updating cart icon:', error);
    });
}

function removeFromCart(id) {
    showModal('Removing item...');
    fetch(`cart_actions.php?action=remove&product_id=${id}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            displayCart();
            updateCartIcon();
            showModal('Item removed from cart.');
        } else {
            showModal(data.message || 'Error removing item from cart.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showModal('Error removing item. Please try again.');
    });
}

function updateQuantity(id, change) {
    const formData = new FormData();
    formData.append('product_id', id);
    formData.append('change', change);

    fetch('cart_actions.php?action=update_quantity', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            displayCart();
            updateCartIcon();
        } else {
            showModal(data.message || 'Error updating quantity.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showModal('Error updating quantity. Please try again.');
    });
}

function displayCart() {
    const cartItemsContainer = document.getElementById('cart-items');
    const subtotalElement = document.getElementById('subtotal-amount');
    const totalElement = document.getElementById('total-amount');

    if (!cartItemsContainer) return;

    fetch('cart_actions.php?action=get')
    .then(response => response.json())
    .then(data => {
        cartItemsContainer.innerHTML = '';
        let subtotal = 0;

        if (data.items.length === 0) {
            cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
            if (subtotalElement) subtotalElement.textContent = '₹0.00';
            if (totalElement) totalElement.textContent = '₹0.00';
            return;
        }

        data.items.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            cartItemsContainer.innerHTML += `
                <div class="cart-item">
                    <img src="contents/products/${item.image}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-details">
                        <h3 class="cart-item-title">${item.name}</h3>
                        <p class="cart-item-price">���${parseFloat(item.price).toFixed(2)}</p>
                        ${item.size_option ? `<p class="cart-item-size">Size: ${item.size_option}</p>` : ''}
                        <div class="cart-item-quantity">
                            <button onclick="updateQuantity('${item.product_id}', -1)">-</button>
                            <span>${item.quantity}</span>
                            <button onclick="updateQuantity('${item.product_id}', 1)">+</button>
                        </div>
                    </div>
                    <p class="cart-item-total">₹${itemTotal.toFixed(2)}</p>
                    <button onclick="removeFromCart('${item.product_id}')">Remove</button>
                </div>
            `;
        });

        if (subtotalElement) subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
        if (totalElement) totalElement.textContent = `₹${subtotal.toFixed(2)}`;
    });
}

function clearCart() {
    fetch('cart_actions.php?action=clear')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayCart();
            updateCartIcon();
        }
    });
}

function showModal(message) {
    const modal = document.getElementById('add-to-cart-modal');
    const modalMessage = document.getElementById('modal-message');
    if (modal && modalMessage) {
        modalMessage.textContent = message;
        modal.style.display = 'block';
    }
}

function closeModal() {
    const modal = document.getElementById('add-to-cart-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function goToCart() {
    window.location.href = 'cart.php';
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartIcon();
    if (window.location.pathname.includes('cart.php')) {
        displayCart();
    }
});

// Make sure these functions are globally accessible
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.clearCart = clearCart;
window.closeModal = closeModal;
window.goToCart = goToCart;