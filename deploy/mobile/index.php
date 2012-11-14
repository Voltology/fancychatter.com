<!DOCTYPE html>
<html>
  <head>
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
  </head>
  <body>
    <div data-role="login">
      <div data-role="header">
        <h1>Log In</h1>
      </div>
      <div data-role="content">
        <label for="username" class="ui-hidden-accessible">Username</label>
        <input type="text" name="username" id="username" value="" placeholder="Username"/>
        <label for="password" class="ui-hidden-accessible">Password</label>
        <input type="text" name="password" id="password" value="" placeholder="Password"/>
      </div>
    </div>
  </body>
</html>
