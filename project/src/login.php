<?php
// ===========================================================================================
//
// Origin: http://github.com/mosbth/Utility
//
// Filename: login.php
//
// Description: Provide a set of functions to enable login & logout on a website.
//
// Author: Mikael Roos, mos@bth.se
//
// Change history:
//
// 2011-01-26:
// First try. Used as example code in htmlphp-kmom03.
//


// -------------------------------------------------------------------------------------------
//
// Is user authenticated and logged in?
//
function userIsAuthenticated() {
  if(isset($_SESSION['authenticated'])) {
    return $_SESSION['authenticated'];
  } else {
    return false;
  }
}


// -------------------------------------------------------------------------------------------
//
// create the login/logout menu
//

function userLoginMenu() {
  // array with all menu items
  $menu = array(
    'login' => array('label' => 'Logga in', 'href' => 'login.php?p=login'),
    // 'status' => array('label' => 'Status', 'href' => 'login.php'),
    'logout' => array('label' => 'Logga ut', 'href' => 'login.php?p=logout'),
  );

  // check if user is logged in or not, alter the menu depending on the result
  if(userIsAuthenticated()) {
    unset($menu['login']);
  } else {
    // unset($menu['status']);
    unset($menu['logout']);
  }

  $html = '';
  foreach($menu as $key => $val) {
    $html .= "<a class='" . (isActivePage('login') ? 'active' : '') . "' href='$val[href]'>$val[label]</a> ";
  }

  return $html;
}

function localize($placeholder, $lang) {
  $translations = array(
    'sv' => array(
      'login_string' => 'Logga in',
      // 'status_string' => 'Status'
    ),
    'jp' => array(
      'login_string' => 'ログイン',
      // 'status_string' => 'ステータス'
    )
  );

  return $translations[$placeholder][$lang];
}

// -------------------------------------------------------------------------------------------
//
// Get login-form
//
function userLoginForm($output=null, $outputClass=null) {

  if(isset($output)) {
    $output = "<p id='loginstatus' class='right'><output class='$outputClass'>$output</output></p>";
  }

  $disabled = null;
  $disabledInfo = null;

  if(userisAuthenticated()) {
    $disabled = "disabled";
    $disabledInfo = "<a href='?p=logout' class='login_logout'>logga ut</a>";
  }

  $html = <<<EOD
<h1>Logga in</h1>
<form method="post" action="?p=login">
  <fieldset>
    $output
    <p>
      <label for="input1">Användarkonto:</label><br>
      <input id="input1" class="text" type="text" name="account">
    </p>
    <p>
      <label for="input2">Lösenord:</label><br>
      <input id="input2" class="text" type="password" name="password">
    </p>
    <p>
      <input type="submit" name="doLogin" value="Login" $disabled>
      $disabledInfo
    </p>
  </fieldset>
</form>
EOD;

  return $html;
}


// -------------------------------------------------------------------------------------------
//
// Login the user
//
function userLogin() {
  global $userAccount, $userPassword;
  // if form is submitted then try to login
  // $_POST['doLogin'] is related to the name of the login-button
  $output=null;
  $outputClass=null;
  if(isset($_POST['doLogin'])) {

    // does account and password match?
    if($userAccount == $_POST['account'] && $userPassword == userPassword($_POST['password'])) {
      $output = "Du är nu inloggad.";
      $outputClass = "success";
      $_SESSION['authenticated'] = true;
    } else {
      $output = "Du lyckades ej logga in. Felaktigt konto eller lösenord.";
      $outputClass = "error";
    }
  }

  return userLoginForm($output, $outputClass);
}


// -------------------------------------------------------------------------------------------
//
// Logout the user
//
function userLogout() {
  unset($_SESSION['authenticated']);
  return "<h1>Utloggad</h1><p>Du är nu utloggad.</p>";
}


// -------------------------------------------------------------------------------------------
//
// Generate a password
//
function userPassword($password) {
  return sha1($password);
}
