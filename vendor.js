document.addEventListener('DOMContentLoaded', function () {
    // Function to show a notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show`;
        notification.role = 'alert';
        notification.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
        document.body.prepend(notification);
    }

    // Check for session messages and show notifications
    const message = document.body.getAttribute('data-message');
    const messageType = document.body.getAttribute('data-message-type');

    if (message) {
        showNotification(message, messageType || 'success');
    }

    // Ensure that the collapse sections stay open
    const productList = document.getElementById('productList');
    const pendingOrders = document.getElementById('pendingOrders');
    
    if (productList) {
        productList.classList.add('show');
    }
    if (pendingOrders) {
        pendingOrders.classList.add('show');
    }

    // Attach event listener to delete buttons
    const deleteButtons = document.querySelectorAll('form[action="vendor.php"] button[type="submit"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const form = button.closest('form');
            if (form.querySelector('input[name="delete_product"]')) {
                if (!confirm('Confirm? This item will be deleted from public view')) {
                    event.preventDefault();
                }
            }
        });
    });
});
