<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize it
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Pouze písmena a mezery jsou povoleny!!!";
    }
    $email = htmlspecialchars($_POST['email']);
    $website = test_input($_POST["website"]);
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
        $websiteErr = "Invalid URL";
    };
    $comment = htmlspecialchars($_POST['comment']);
    $gender = htmlspecialchars($_POST['gender']);

    // Output or process the data here
    echo "<h2>Your Input:</h2>";
    echo "Name: " . $name . "<br>";
    echo "E-mail: " . $email . "<br>";
    echo "Website: " . $website . "<br>";
    echo "Comment: " . $comment . "<br>";
    echo "Gender: " . $gender . "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Example</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;  /* Dark background for dark mode */
            color: #f0f0f0;  /* Light text color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            color: #e0e0e0;  /* Light grey for the title */
        }

        .form-container {
            background-color: #1f1f1f;  /* Slightly lighter background for form */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 600px;  /* Increased width for more horizontal space */
            text-align: left;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            color: #ddd;  /* Lighter text for labels */
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #333;  /* Dark border */
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #333;  /* Dark background for inputs */
            color: #fff;  /* White text inside input fields */
        }

        input[type="submit"] {
            background-color: #888;  /* Grey button */
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1.1em;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #666;  /* Darker grey on hover */
        }

        .radio-group {
            margin-bottom: 15px;
        }

        .radio-group input {
            margin-right: 10px;
            color: #ddd;
        }

        .error {
            color: #ff4d4d;  /* Red for error messages */
            font-size: 0.9em;
        }

        .required {
            color: #ff6347;  /* Tomato color for required fields */
        }

        .form-container p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

<div class="form-container">
    <h2>PHP Form</h2>
    <p><span class="error">* required field</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Name: <span class="required">*</span></label>
        <input type="text" name="name" required><br>

        <label for="email">E-mail: <span class="required">*</span></label>
        <input type="text" name="email" required><br>

        <label for="website">Website:</label>
        <input type="text" name="website"><br>

        <label for="comment">Comment:</label>
        <textarea name="comment" rows="5" cols="40"></textarea><br>

        <div class="radio-group">
            <label>Gender:</label><br>
            <input type="radio" name="gender" value="female"> Female
            <input type="radio" name="gender" value="male"> Male
            <input type="radio" name="gender" value="other"> Other<br><br>
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>
</div>

</body>
</html>
