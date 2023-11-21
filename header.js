// header.js

function toggleMenu() {
    var menuOptions = document.getElementById('menuOptions');
    var menuIcon = document.querySelector('.menu-icon');

    if (menuOptions.style.display === 'block') {
        menuOptions.style.display = 'none';
        menuIcon.innerHTML = '☰';
    } else {
        menuOptions.style.display = 'block';
        menuIcon.innerHTML = '✖';
    }
}

function initializeHeader() {
    var storedUsername = localStorage.getItem('username');
    if (storedUsername) {
        document.getElementById('usernamePlaceholder').textContent = storedUsername;
    } else {
        document.getElementById('usernamePlaceholder').textContent = 'Guest';
    }

    $('#logoutLink').on('click', function (e) {
        e.preventDefault();

        // Ask for confirmation
        var confirmLogout = confirm("Are you sure you want to logout?");
        if (!confirmLogout) {
            return;
        }

        localStorage.removeItem('username');

        $.ajax({
            type: 'GET',
            url: 'logout_process.php',
            success: function (response) {
                if (response === 'success') {
                    window.location.href = 'login.html';
                } else {
                    alert('Logout failed. Please try again.');
                }
            },
            error: function () {
                alert('Error occurred during logout process');
            }
        });
    });
}
