<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Compose and Send Email</h2>
    <form action="compose_email.php" method="post" enctype="multipart/form-data">
        <!-- Email Subject -->
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>

        <!-- Email Body -->
        <div class="mb-3">
            <label for="body" class="form-label">Email Body</label>
            <textarea class="form-control" id="body" name="body" rows="8"></textarea>
            <script>
                CKEDITOR.replace('body');
            </script>
        </div>

        <!-- Attachments -->
        <div class="mb-3">
            <label for="attachments" class="form-label">Attachments</label>
            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
