<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/PHPMailer/src/Exception.php';
require './vendor/PHPMailer/src/PHPMailer.php';
require './vendor/PHPMailer/src/SMTP.php';

//Autoloader
require 'includes/autoloader.inc.php';

//let's initialize these variables to empty values
$email = '';
$subject = '';
$message = '';
$sent = false; 

// now i make validate to the submit the contact form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    //Adding a message to the errors array if it's invalid
    $errors = [];

    //We'll use the filtervar method with the email filter
    if (filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'please enter a valid email address'; 
    }

    if ($subject == '') {
        $errors[] = "please enter a subject";
    }

    if ($message == '') {
        $errors[] = 'please enter a mmessage';
    }
    // if don't have any errors we can send a email 
    if(empty($errors)) {

        // i must to creat a object from the PHP MAILER 

        $mail = new PHPMAiler(true);

        try {
        
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true ;                                   //Enable SMTP authentication
            $mail->Username   = 'username';                             //SMTP username
            $mail->Password   = 'password';                             //SMTP password
            $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com');
            $mail->addAddress('joe@example.net');     //Add a recipient
            $mail->addReplyTo($email);
            $mail->Subject = $subject;
            $mail->Body    = $message;
        
            $mail->send();
            $sent  =true;
        } catch (Exception $e) {

            //when i get error by sending i must to save in errors array 
            $errors[] = $mail->ErrorInfo;
        }

    }
}
?>
<?php require "includes/header.inc.php"; ?>

<h2>Contact</h2>

<!-- when the email send successfully-->
<?php if ($sent) : ?>
    <p>Message sent.</p>
<?php else: ?>

    <?php if (! empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>    
        
<?php endif; ?>    


<form action="" method="post" id="formContact">
    <div class="form-group">
        <label for="email">Your Email </label>
        <input class="form-control" type="email" name="email" id="title" placeholder="Your Email" value="<?php htmlspecialchars($email); ?>">
    </div>
    
    <div class="form-group">
        <label for="subject">Subject</label>
        <input class="form-control" type="subject" name="subject" id="subject" placeholder="Subject" value="<?php htmlspecialchars($subject); ?>">
    </div>

    <div class="form-group">
        <label for="message">Message </label>
        <textarea class="form-control" name="message" id="message" placeholder="Message"><?php htmlspecialchars($message); ?></textarea>
    </div>
    <br>
    <button class="btn btn-primary"> Send </button>
</form>
<?php require "includes/footer.inc.php"; ?>