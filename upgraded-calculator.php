<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/upgraded-calculator.css">
    <link rel="stylesheet" href="css/nav-bar.css">
    <title>Calculator 2</title>
</head>
<body>
    <main>
        <div class="container">

        <?php $currentpage = basename($_SERVER["PHP_SELF"]); ?>

            <nav class="nav-bar">
                <ul>
                <li><a href="index.php">Level 1</a></li>
                <li><a href="upgraded-calculator.php" class="<?= $currentpage === 'upgraded-calculator.php' ? 'active' : '' ?>">Level 2</a></li>
                <li><a href="404.php">Level 3</a></li>
                </ul>
            </nav>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <?php
                $display = '';

                // Handle input securely
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    if (isset($_POST['btn'])) {
                        $btn = $_POST['btn'];

                        // Whitelist allowed inputs (digits, operators)
                        $whitelist = ['0','1','2','3','4','5','6','7','8','9','.','+','-','*','/','C','=','%','√'];

                        if (in_array($btn, $whitelist)) {
                            session_start();
                            if (!isset($_SESSION['display'])) $_SESSION['display'] = '';

                            if ($btn === 'C') {
                                $_SESSION['display'] = '';
                            } elseif ($btn === '=') {
                                $expression = $_SESSION['display'];
                                
                                // Replace √ with sqrt()
                                $expression = preg_replace('/√(\d+|\([^\)]+\))/', 'sqrt($1)', $expression);

                                // Basic check: only allow valid characters
                                if (preg_match('/^[0-9\+\-\*\/\.\(\)sqrt% ]+$/', $expression)) {
                                    try {
                                        @eval("\$result = $expression;");

                                        $_SESSION['display'] = $result ?? 'Error';
                                    } catch (Exception $e) {
                                        $_SESSION['display'] = 'Error';
                                    }
                                } else {
                                    $_SESSION['display'] = 'Invalid';
                                }
                            } else {
                                $_SESSION['display'] .= $btn;
                            }

                            $display = $_SESSION['display'];
                        }
                    }
                }
                ?>

                <input type="text" readonly placeholder="0" value="<?php echo htmlspecialchars($display); ?>">
                <div class="keypad">
                    <button type="submit" name="btn" value="C" style="background-color:#ff7c85;">C</button>
                    <button type="submit" name="btn" value="%">%</button>
                    <button type="submit" name="btn" value="√">&radic;</button>
                    <button type="submit" name="btn" value="/">&divide;</button>

                    <button type="submit" name="btn" value="7">7</button>
                    <button type="submit" name="btn" value="8">8</button>
                    <button type="submit" name="btn" value="9">9</button>
                    <button type="submit" name="btn" value="*">&times;</button>

                    <button type="submit" name="btn" value="4">4</button>
                    <button type="submit" name="btn" value="5">5</button>
                    <button type="submit" name="btn" value="6">6</button>
                    <button type="submit" name="btn" value="-">−</button>

                    <button type="submit" name="btn" value="1">1</button>
                    <button type="submit" name="btn" value="2">2</button>
                    <button type="submit" name="btn" value="3">3</button>
                    <button type="submit" name="btn" value="+" class="add">+</button>

                    <button type="submit" name="btn" value="0" class="zero">0</button>
                    <button type="submit" name="btn" value=".">.</button>
                    <button type="submit" name="btn" value="=">=</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>