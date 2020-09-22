<?php

class LayoutView {

  public function render($isLoggedIn, $v, DateTimeView $dtv, $message) {
    if (session_status() == 1) {
      session_start();
    }

      echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
            ' . $this->renderIsLoggedIn($isLoggedIn) . '

            <div class="container">
                ' . $v->response($message) . '
                
                ' . $dtv->show() . '
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