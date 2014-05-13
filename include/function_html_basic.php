<?php
function startHTML(){
echo "<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <meta http-equiv='content-language' content='en' />
        <meta name='copyright' content='Copyright (c) 2014 Altis Life Control by Pictureclass - Revoplay.de' />
        <link href='css/bootstrap.css' rel='stylesheet' media='screen'>
        <title>Altis Life Control</title>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
        <script src='https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'></script>
        <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src='//code.jquery.com/jquery.js'></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src='js/bootstrap.js'></script>     
    </head>
<body style='background: url(img/altis_background_2.jpg); background-size: cover;'>
<div id='wrap'>
    <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class='navbar-header'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-ex1-collapse'>
      <span class='sr-only'>Toggle navigation</span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
        <a class='navbar-brand' href='index.php' style='padding-top:0 !important;padding-bottom:0 !important;'><img src='img/logo_small.png'></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class='collapse navbar-collapse navbar-ex1-collapse'>
    <ul class='nav navbar-nav navbar-right'>
      <li><a href='index.php'>Start Page</a></li>
      <li><a href='admin/login.php'>Admin Interface</a></li>
    </ul>
    
  </div><!-- /.navbar-collapse -->
  </nav>";
};
function closeHTML(){
echo"
</div><!-- Close Wrapper -->
<div id='footer' style='margin-top:30px;'>
    <div class='container' color: #999999;'>
        <p class='text-center' style='margin-top: 20px; margin-bottom: 0px !important; color: #999999;'>Copyright © 2014 Altis Life Control Version 0.1 by <a href='http://revoplay.de/'>Pictureclass</a> - <a href='http://www.revoplay.de'>Revoplay.de</a>. All Rights Reserved.<br>                                      Only for Private Use. No Commercial Use. Advanced Permissions beyond this license may be available at <a xmlns:cc='http://creativecommons.org/ns#' href='mailto:pictureclass@revoplay.de' rel='cc:morePermissions'>pictureclass@revoplay.de</a>.</p>
            <form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top' class='text-center'>
                <input type='hidden' name='cmd' value='_s-xclick'>
                <input type='hidden' name='hosted_button_id' value='P8E8XVKTZ3BKG'>
                <input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
                <img alt='' border='0' src='https://www.paypalobjects.com/de_DE/i/scr/pixel.gif' width='1' height='1'>
            </form>
    </div>
</div>
</body>
</html>
";    
};

function headerbox(){
echo"
<div class='header_all'>
</div>

";}

function endbody(){
    echo"
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) 
        <script src='//code.jquery.com/jquery.js'></script>-->
        <!-- Include all compiled plugins (below), or include individual files as needed 
        <script src='js/bootstrap.js'></script>     -->   
    </body>
</html>
            
";
}


?>

