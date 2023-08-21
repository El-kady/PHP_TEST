<?php

require("init.php");
require("functions.php");

$message = "";
$hide_form = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);

    $token = $_POST['token']; // Validate CSRF token here
    if (!$token || $token !== $_SESSION['token']) {
        $message = "csrfToken is not valid";
    } else {
        // Check if image was uploaded without errors
        if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
            $imagePath = 'uploads/' . basename($_FILES['userImage']['name']);
            $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

            // Check if the uploaded file is an image
            if (getimagesize($_FILES['userImage']['tmp_name']) !== false) {
                // Check file size (2MB limit)
                if ($_FILES['userImage']['size'] <= 2 * 1024 * 1024) {
                    // Move the uploaded file to the desired directory
                    move_uploaded_file($_FILES['userImage']['tmp_name'], $imagePath);

                    saveUserData($firstName,$lastName,$imagePath);
                    $message =  "User data saved successfully!";
                    $hide_form = true;
                } else {
                    $message =  'File is too large. Maximum allowed size is 2MB.';
                }
            } else {
                $message =  'Uploaded file is not an image.';
            }
        } else {
            $message =  'Error uploading the file.';
        }
    }

    
}

$_SESSION['token'] = md5(uniqid(mt_rand(), true));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Form</title>
</head>

<body>
    <div class="container">
        <header>Form</header>
        <form method="POST" enctype="multipart/form-data">
            <div class="form">

            <?php if(!empty($message)){ ?>
                    <div class="message"><?php echo $message; ?></div>
            <?php } ?>

            <?php if($hide_form === false){ ?>
                <div class="fields">
                    <div class="input-field">
                        <label>First Name *</label>
                        <input name="firstName" type="text" placeholder="Enter your first name" required>
                    </div>

                    <div class="input-field">
                        <label>Last Name *</label>
                        <input name="lastName" type="text" placeholder="Enter your last name" required>
                    </div>

                    <div class="input-field image-input">
                        <label>User Image *</label>
                        <div id="thumbnail"></div>
                        <input type="file" id="userImage" name="userImage" accept="image/*" required>
                    </div>
                </div>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                <button>Send</button>
                <?php } ?>
            </div>
        </form>
    </div>
    <script src="script.js"></script>
</body>

</html>