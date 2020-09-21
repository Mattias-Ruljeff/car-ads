<?php

class LayoutView {

  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv) {
    if (session_status() == 1) {
      echo "session started";
      session_start();
    }

    // if ($_POST) {
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
                ' . $v->response() . '
                
                ' . $dtv->show() . '
            </div>
           </body>
        </html>
      ';


    // } else {
          // echo '<!DOCTYPE html>
          //   <html>
          //     <head>
          //       <meta charset="utf-8">
          //       <title>Login Example</title>
          //     </head>
          //     <body>
          //       <h1>Assignment 2</h1>
          //       ' . $this->renderIsLoggedIn($isLoggedIn) . '
                
          //       <div class="container">
                    
          //           ' . $dtv->show() . '
          //       </div>
          //      </body>
          //   </html>
          // ';
    // }
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '
      <h2>Not logged in</h2>
      <form action="?register" method="post">
      <input type="submit" name="Register new user" value="registerNewUser"/>
      </form>
      ';
    }
  }
}