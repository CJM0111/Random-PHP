<!DOCTYPE html>
<html>
<head>
    <title>
    <?php
		// Update the title to display the user's name
        session_start();
        if(!isset($_SESSION['user_name'])) {
            $_SESSION['user_name'] = $_REQUEST['user_name'];
        }
		if($_POST['submit_name'] && count < 1) {
			$_SESSION['user_name'] = ', '.$_SESSION['user_name'];
			$count++;
		}
		echo 'Welcome'.$_SESSION['user_name'];
        ?>
    </title>
    <link rel="stylesheet" href="https://blue.butler.edu/~cjmcdona/styles.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
<?php
	// Redirect to HTTPS
    if($_SERVER['HTTPS'] != "on") {
        $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header("Location:$redirect");
        exit();
    }
	// Empty the values to start over
    if(isset($_POST['start_over'])){
        unset($_SESSION['number']);
        unset($_SESSION['number_of_guesses']);
    }
	// Generate a random number
    if(!isset($_SESSION['number'])){
        $_SESSION['number'] = rand(1,99);
        $_SESSION['number_of_guesses'] = 0;
    }
	// Guessing Game logic
    if(isset($_POST['guess'])){
        if($_POST['guess'] == $_SESSION['number']){
            echo '
            <div id="win_message" class="layered text-center">
            <svg>
            <defs>
            <linearGradient id="gradient-1" x1="0%" y1="100%" x2="0%" y2="0%">
            <stop offset="0%" style="stop-color:#FFFFFF;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#000099;stop-opacity:1" />
            </linearGradient>
            <linearGradient id="gradient-2" x1="0%" y1="100%" x2="0%" y2="0%">
            <stop offset="0%" style="stop-color:#0000FF;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#000000;stop-opacity:1" />
            </linearGradient>
            </defs>
            <ellipse cx="100" cy="70" rx="85" ry="55" fill="url(#gradient-1)" />
            <text fill="url(#gradient-2)" font-size="28" font-family="Verdana" x="40" y="75">You Win!</text>
            </svg>
            </div>
            ';
        }else if($_POST['guess'] <= $_SESSION['number']){
            echo '
            <div class="center_text layered response_message_position"">
            <svg width="400">
            <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#000000;stop-opacity:1" />
            <stop offset="100%" style="stop-coloR:#FF0000;stop-opacity:1" />
            </linearGradient>
            </defs>
            <text fill="url(#gradient)" font-size="28" font-family="Verdana" x="0" y="100">
            Your guess is too low.</text>
            </svg>
            </div>
			';
        }else if($_POST['guess'] >= $_SESSION['number']){
            echo '
            <div class="center_text layered response_message_position"">
            <svg width="400">
            <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#FFFFFF;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#FFFF00;stop-opacity:1" />
            </linearGradient>
            </defs>
            <text fill="url(#gradient)" font-size="28" font-family="Verdana" x="0" y="100">
            Your guess is too high.</text>
            </svg>
            </div>
			';
        }
		$_SESSION['number_of_guesses']++;
    }
	// Display the form allowing users submit a user name before playing the Guessing Game
    if(!isset($_SESSION['user_name'])){
		echo '
        <div class="container-fluid gradient_background">
			<div id="name_form" class="text-center">
			<form method="post">
			<input id="name_input" class="flashing_text input_field" type="text" name="user_name" /><br>
			<input id="submit_name_button" class="btn btn-info buttons flashing_text transparent" type="submit" name="submit_name" value="Go" />
			</form>
			</div>
        </div>';
    }
	// Display the main Guessing Game page once the user has submitted their name
    else {
        echo '
        <div class="container-fluid gradient_background">
			<div class="text-center">
				<div id="welcome_header" class="center_text flashing_text">
				<h1>Welcome to the Guessing Game!</h1>
				</div>
				<form method="post">
				<input id="guess_input" class="flashing_text input_field" type="text" name="guess" />
				<div id="guess_count" class="flashing_text text-center">Guess Count: '.$_SESSION['number_of_guesses'].'</div>
				<input id="submit_guess_button" class="btn btn-info buttons flashing_text transparent" type="submit" name="submit" value="Submit Guess" />
				</form>
				<form method="post">
				<input id="start_over_button" class="btn btn-info buttons flashing_text transparent" type="submit" name="start_over" value="Start Over" />
				</form>
			</div>
        </div>';
    }
    ?>
</body>
</html>
