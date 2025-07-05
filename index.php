<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/nav-bar.css">
  <title>Calculator 1</title>
</head>
<body>
  <main>
    <div class="container">
      <?php $currentpage = basename($_SERVER["PHP_SELF"]); ?>
      <nav class="nav-bar">
        <ul>
          <li><a href="index.php" class="<?= $currentpage === 'index.php' ? 'active' : '' ?>">Level 1</a></li>
          <li><a href="upgraded-calculator.php">Level 2</a></li>
          <li><a href="404.php">Level 3</a></li>
        </ul>
      </nav>
      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input required type="number" name="num1" placeholder="input number here">
        <select name="operator" id="">
          <option value="add">+</option>
          <option value="minus">-</option>
          <option value="multiply">x</option>
          <option value="divide">/</option>
        </select>
        <input required type="number" name="num2" placeholder="input number here">
        <button>Calculate</button>
        <?php  

          if($_SERVER["REQUEST_METHOD"] == "POST") {
            $num1 = filter_input(INPUT_POST, "num1", FILTER_SANITIZE_NUMBER_FLOAT);
            $num2 = filter_input(INPUT_POST, "num2", FILTER_SANITIZE_NUMBER_FLOAT);
            $operator = htmlspecialchars($_POST["operator"]);


            //error checker and handler
            $error = false;

            if(empty($num1) || empty($num2) || empty($operator)){
              echo "<p class='calc-error'>Fill all the input!</p>";
              $error = true;
            }

            if(!is_numeric($num1) || !is_numeric($num2)) {
              echo "<p class='calc-error'>Number Only</p>";
              $error = true;
            }

            //Calculates if no error found

            if(!$error) {
              $value = 0;
              
              switch($operator) {
                case "add": 
                  $value = $num1 + $num2;
                  break;
                case "minus": 
                  $value = $num1 - $num2;
                  break;
                case "multiply":
                  $value = $num1 * $num2;
                  break;
                case "divide": 
                  $value = $num1 / $num2;
                  break;
                default:
                  echo "<p class='calc-error'>error!</p>";
              }
                echo "<p> Result:</p><input type='text' class='calc-result' name='result' value='" . $value . "'readonly>";
            }
          }
        ?>

      </form>
    </div>
  </main>
</body>
</html>