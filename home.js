document.addEventListener('DOMContentLoaded', () => {
    const cartCountElement = document.getElementById('cart-count');

    function updateCartCount() {
        fetch('cart_operations.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'action': 'get_count'
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartCountElement.textContent = data.cartCount;
            } else {
                console.error('Failed to update cart count:', data.message);
            }
        })
        .catch(error => console.error('Error fetching cart count:', error));
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const card = button.closest('.product-card');
            const productName = card.getAttribute('data-product-name');

            fetch('cart_operations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'action': 'add',
                    'product_name': productName,
                    'quantity': 1,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                } else {
                    console.error('Failed to add to cart:', data.message);
                }
            })
            .catch(error => console.error('Error adding to cart:', error));
        });
    });

    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', () => {
            const card = button.closest('.product-card');
            const productName = card.getAttribute('data-product-name');

            fetch('cart_operations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'action': 'remove',
                    'product_name': productName,
                    'quantity': 1, // Decrement by 1 each time
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                } else {
                    console.error('Failed to remove from cart:', data.message);
                }
            })
            .catch(error => console.error('Error removing from cart:', error));
        });
    });

    updateCartCount();
});
