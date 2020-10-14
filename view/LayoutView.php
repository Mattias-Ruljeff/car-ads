<?php

namespace View;

class LayoutView {

  public function render($isLoggedIn, $view, DateTimeView $dtv, $adsView, $message) {
      if(isset($_GET["register"])) {
        $textInATag = "Back to login";
        $href = "/";
      } else {
        $textInATag = "Register a new user";
        $href = "?register";
      }
      echo '<!DOCTYPE html>
        <html>
            <head>
            <meta charset="utf-8">
            <title>Login Example</title>
            <link rel="stylesheet" href="./style.css">
            </head>
            <body>
            <div class="container">
                <div id="loginBox">
                    <h1>Assignment 2</h1>
                    <a href="'. $href .'">'. $textInATag .'</a>
                    ' . $this->renderIsLoggedIn($isLoggedIn) . '
                    ' . $view->response($message) . '
                    ' . $dtv->show() . '
                </div>
            </div>
                <div id="adsBox">
                    ' . $adsView . '
                </div>
           </body>
        </html>
      ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {

    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}