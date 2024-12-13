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
    $drink = htmlspecialchars($_POST['drink']); // změněno na drink

    // Output or process the data here
    echo "<h2>Your Input:</h2>";
    echo "Name: " . $name . "<br>";
    echo "E-mail: " . $email . "<br>";
    echo "Website: " . $website . "<br>";
    echo "Comment: " . $comment . "<br>";
    echo "Your drink choice: " . $drink . "<br>"; // Změněno na drink
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
            background-color: #f4f4f4;  /* Default light background */
            color: #333;  /* Default dark text */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }

        h2 {
            color: #333;  /* Default text color */
        }

        .form-container {
            background-color: #fff;  /* Default light background for form */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 600px;  /* Increased width for more horizontal space */
            text-align: left;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .dark-mode {
            background-color: #121212;
            color: #f0f0f0;
        }

        .dark-mode .form-container {
            background-color: #1f1f1f;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dark-mode input[type="text"],
        .dark-mode textarea {
            background-color: #333;
            color: #fff;
            border: 1px solid #444;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        input[type="submit"] {
            background-color: #888;
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
            background-color: #666;
        }

        .radio-group {
            margin-bottom: 15px;
        }

        .radio-group input {
            margin-right: 10px;
        }

        .error {
            color: #ff4d4d;
        }

        .required {
            color: #ff6347;
        }

        .switch {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
        }

        .switch input {
            width: 40px;
            height: 20px;
            -webkit-appearance: none;
            background-color: #ccc;
            border-radius: 20px;
            outline: none;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .switch input:checked {
            background-color: #4CAF50;
        }

        .switch input:checked + .slider {
            background-color: #4CAF50;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 20px;
            transition: 0.3s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            border-radius: 50%;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.3s;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }
    </style>
</head>
<body>

<!-- Dark/Light Mode Switch -->
<div class="switch">
    <label class="switch">
        <input type="checkbox" id="modeSwitch">
        <span class="slider"></span>
    </label>
</div>

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
            <label>Choose your drink:</label><br>
            <input type="radio" name="drink" value="coffee"> Coffee
            <input type="radio" name="drink" value="tea"> Tea<br><br>
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<script>
    // Get the mode switch checkbox and body element
    const modeSwitch = document.getElementById("modeSwitch");
    const body = document.body;

    // Check for the stored mode in localStorage and set it
    if (localStorage.getItem("mode") === "dark") {
        body.classList.add("dark-mode");
        modeSwitch.checked = true;
    }

    // Listen for changes in the switch and update mode
    modeSwitch.addEventListener("change", function() {
        if (modeSwitch.checked) {
            body.classList.add("dark-mode");
            localStorage.setItem("mode", "dark");  // Save mode to localStorage
        } else {
            body.classList.remove("dark-mode");
            localStorage.setItem("mode", "light");  // Save mode to localStorage
        }
    });
</script>

</body>
</html>
