
// Toggle Sidebar
document.addEventListener("DOMContentLoaded", function () {
    const toggleSidebar = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".sidebar");

    toggleSidebar.addEventListener("click", function () {
        sidebar.classList.toggle("active");
    });
});


// Profile Dropdown Toggle
document.addEventListener("DOMContentLoaded", function () {
    const profileDropdown = document.querySelector(".profile-dropdown");
    const dropdownMenu = profileDropdown.querySelector(".profile-dropdown-menu");

    profileDropdown.addEventListener("mouseenter", () => {
        dropdownMenu.style.display = "block";
    });

    profileDropdown.addEventListener("mouseleave", () => {
        setTimeout(() => {
            if (!dropdownMenu.matches(":hover")) {
                dropdownMenu.style.display = "none";
            }
        }, 150);
    });

    dropdownMenu.addEventListener("mouseleave", () => {
        dropdownMenu.style.display = "none";
    });
});


// Handle Change Password Form Submission
$(document).on('submit', '#changePasswordForm', function (e) {
    e.preventDefault();

    const currentPassword = $('#currentPassword').val();
    const newPassword = $('#newPassword').val();
    const confirmPassword = $('#confirmPassword').val();

    if (newPassword !== confirmPassword) {
        alert('New passwords do not match!');
        return;
    }

    $.ajax({
        url: 'ajax/change_password.php', // Adjust this path if needed
        method: 'POST',
        data: {
            currentPassword: currentPassword,
            newPassword: newPassword
        },
        success: function (response) {
            alert(response);
            $('#changePasswordModal').modal('hide');
        },
        error: function () {
            alert('An error occurred. Please try again.');
        }
    });
});

