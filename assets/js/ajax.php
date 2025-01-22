<script>
    

// Change Password
document.getElementById('changePasswordForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch('ajax/change_password.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        modal.hide();
        this.reset();
    })
    .catch(error => console.error('Error:', error));
});
</script>