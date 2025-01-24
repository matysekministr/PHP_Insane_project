<?php
// Inicializace proměnných pro chyby a data
$nameErr = $emailErr = $websiteErr = $drinkErr = "";
$name = $email = $website = $comment = $drink = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ošetření a sanitizace vstupních dat
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Pouze písmena a mezery jsou povoleny!!!";
    }

    $email = test_input($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Neplatný formát e-mailu";
    }

    $website = test_input($_POST["website"]);
    if (!empty($website) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
        $websiteErr = "Neplatná URL adresa";
    }

    $comment = test_input($_POST['comment']);
    $drink = isset($_POST['drink']) ? $_POST['drink'] : "";
    if (empty($drink)) {
        $drinkErr = "Prosím vyberte nápoj";
    }

    // Pokud nejsou žádné chyby, uložíme údaje do souboru
    if (empty($nameErr) && empty($emailErr) && empty($websiteErr) && empty($drinkErr)) {
        // Vytvoření pole s daty
        $data = array(
            "name" => $name,
            "email" => $email,
            "website" => $website,
            "comment" => $comment,
            "drink" => $drink
        );

        // Získání existujících dat z JSON souboru, pokud existují
        $jsonFile = "data.json";
        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            $existingData = json_decode($jsonData, true);
        } else {
            $existingData = array();
        }

        // Přidání nových dat do existujících dat
        $existingData[] = $data;

        // Uložení všech dat zpět do souboru ve formátu JSON
        file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

        // Výstup pro uživatele
        $output = "<h2>Vaše údaje:</h2>";
        $output .= "Name: " . $name . "<br>";
        $output .= "E-mail: " . $email . "<br>";
        $output .= "Website: " . $website . "<br>";
        $output .= "Comment: " . $comment . "<br>";
        $output .= "Your drink choice: " . $drink . "<br>";
    }
}

// Funkce pro ošetření vstupních dat
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Example</title>
    <style>
        /* Obecné nastavení */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;  /* Světle šedé pozadí */
            color: #495057;  /* Tmavě šedý text */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #343a40;  /* Tmavý text pro nadpisy */
        }

        /* Formulář */
        .form-container {
            background-color: #ffffff;  /* Bílé pozadí formuláře */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: left;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        /* Tmavý režim */
        .dark-mode {
            background-color: #343a40;
            color: #e9ecef;
        }

        .dark-mode .form-container {
            background-color: #495057;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Vstupy a textová pole */
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #495057;
            transition: background-color 0.3s, color 0.3s;
        }

        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
        }

        /* Tlačítka */
        input[type="submit"], #showJsonBtn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover, #showJsonBtn:hover {
            background-color: #0056b3;
        }

        /* Chybové zprávy */
        .error {
            color: #e63946;
            font-size: 0.9em;
        }

        /* Přepínač režimu */
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
            background-color: #ced4da;
            border-radius: 20px;
            outline: none;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .switch input:checked {
            background-color: #4CAF50;
        }

        .switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ced4da;
            border-radius: 20px;
            transition: 0.3s;
        }

        .switch .slider:before {
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

        .switch input:checked + .slider:before {
            transform: translateX(20px);
        }

        /* Zobrazení JSON dat */
        #jsonContent {
            background-color: #f1f3f5;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
            color: #343a40;
            margin-top: 20px;
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
    <h2>PHP Formulář</h2>
    <p><span class="error">* required field</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Jméno: <span class="required">*</span></label>
        <input type="text" name="name" value="<?php echo $name;?>" required><br>
        <span class="error"><?php echo $nameErr; ?></span><br>

        <label for="email">E-mail: <span class="required">*</span></label>
        <input type="text" name="email" value="<?php echo $email;?>" required><br>
        <span class="error"><?php echo $emailErr; ?></span><br>

        <label for="website">Webs:</label>
        <input type="text" name="website" value="<?php echo $website;?>"><br>
        <span class="error"><?php echo $websiteErr; ?></span><br>

        <label for="comment">Komentář:</label>
        <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea><br>

        <div class="radio-group">
            <label>Zvolte nápoj:</label><br>
            <input type="radio" name="drink" value="coffee" <?php if ($drink == "coffee") echo "checked"; ?>> Coffee
            <input type="radio" name="drink" value="tea" <?php if ($drink == "tea") echo "checked"; ?>> Tea<br>
            <span class="error"><?php echo $drinkErr; ?></span><br>
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>

    <!-- Zobrazení zadaných údajů -->
    <?php
    if (isset($output)) {
        echo "<div class='output'>";
        echo $output;
        echo "</div>";
    }
    ?>
</div>

<script>
    // Dark/Light mode přepínač
    const modeSwitch = document.getElementById("modeSwitch");
    const body = document.body;

    if (localStorage.getItem("mode") === "dark") {
        body.classList.add("dark-mode");
        modeSwitch.checked = true;
    }

    modeSwitch.addEventListener("change", function() {
        if (modeSwitch.checked) {
            body.classList.add("dark-mode");
            localStorage.setItem("mode", "dark");
        } else {
            body.classList.remove("dark-mode");
            localStorage.setItem("mode", "light");
        }
    });
</script>

</body>
</html>
