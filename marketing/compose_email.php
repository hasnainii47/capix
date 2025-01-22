<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "sajibgpo_tr";
$password = "Capix@2024";
$dbname = "sajibgpo_transaction_reports";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $attachments = $_FILES['attachments'];

    // Create database connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Fetch customer emails
    $emails = [];
    $sql = "SELECT email FROM lead";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }
    }
    $connection->close();

    // Divide emails into batches of 100
    $batches = array_chunk($emails, 100);

    foreach ($batches as $batch) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@capixllc.com';
            $mail->Password = 'Capix@0125';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('noreply@capixllc.com', 'Capix Freight LLC');
            foreach ($batch as $email) {
                $mail->addBCC($email);
            }
            $mail->addCC('kristin@capixllc.com'); // Replace with your CC email
            $mail->addCC('fardheen@capixllc.com');
            // Subject and body
            $mail->Subject = $subject;
            $mail->Body = $body.'<hr><p>For further inquiries, you can reach out to our dedicated sales team:</p>

<p><strong>Sales Team Contact Details:</strong></p>

<ul>
	<li>
	<p><strong>Name:</strong>&nbsp;Kristin Susan Koshy<br />
	<strong>Phone:</strong>&nbsp;<a href="tel:+971 54 266 2955">+971 54 266 2955</a><br />
	<strong>Email:</strong> <a href="mailto:kristin@capixllc.com">kristin@capixllc.com</a></p>
	</li>
	<li>
	<p><strong>Name:</strong>&nbsp;Mohammed Fardheen<br />
	<strong>Phone:</strong>&nbsp;<a href="tel:+971 50 681 5281">+971 50 681 5281</a><br />
	<strong>Email:</strong>&nbsp;<a href="mailto:Fardheen@capixllc.com">Fardheen@capixllc.com</a></p>
	</li>
</ul>

<p><strong>Company Contact Details:</strong></p>

<ul>
	<li><strong>Website:</strong> <a href="https://capixllc.com" target="_new">capixllc.com</a></li>
	<li><strong>Phone:</strong>&nbsp;<a href="tel:+971 4 354 2423">+971 4 354 2423</a></li>
</ul>

<p><strong>Follow Us on Social Media:</strong></p>

<ul>
	<li><strong>LinkedIn:</strong> <a href="https://www.linkedin.com/company/capixfreightllc/">https://www.linkedin.com/company/capixfreightllc/</a></li>
	<li><strong>Facebook:</strong> <a href="https://www.facebook.com/capixfreightllc">https://www.facebook.com/capixfreightllc</a></li>
	<li><strong>Instagram:</strong> <a href="https://www.instagram.com/capixfreightllc/">https://www.instagram.com/capixfreightllc/</a></li>
	<li><strong>Twitter:</strong> <a href="https://x.com/capixfreightllc">https://x.com/capixfreightllc</a></li>
	<li><strong>Email:</strong> <a href="http://capix@capixllc.com">capix@capixllc.com</a></li>
</ul>

<p>We are looking forward to collaborating with your esteemed company and providing tailored logistics solutions to meet your requirements.<br />
<strong>Best regards,</strong><br />
Capix Freight LLC</p>

<p>&nbsp;</p>';
            $mail->isHTML(true);

            // Attachments
            if (!empty($attachments['name'][0])) {
                for ($i = 0; $i < count($attachments['name']); $i++) {
                    $mail->addAttachment($attachments['tmp_name'][$i], $attachments['name'][$i]);
                }
            }

            // Send email
            $mail->send();
            echo "Batch sent successfully.<br>";
        } catch (Exception $e) {
            echo "Batch could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }

        // Pause briefly between batches to avoid SMTP limits
        sleep(1);
    }

    echo "All emails sent.";
}
?>
