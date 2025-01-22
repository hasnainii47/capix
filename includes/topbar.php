<div class="topbar d-flex justify-content-between align-items-center p-2 bg-light">
    <div class="topbar-left d-flex align-items-center">
        <button id="toggleSidebar" class="btn btn-primary d-md-none me-3">☰</button>
        <h4>Dashboard</h4>
    </div>
    <div class="topbar-right d-flex align-items-center">
        <div class="profile-dropdown position-relative">
            <img src="assets/images/profile-placeholder.png" alt="Profile" class="profile-img rounded-circle" width="40" height="40">
            <span class="profile-name ms-2"><?= $_SESSION['name']; ?></span>
            <ul class="profile-dropdown-menu list-unstyled position-absolute bg-white border shadow-sm mt-2">
                <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class="fas fa-key me-2"></i>Change Password</a></li>
                <li><a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</div>
