<?php
require_once "lang/de.php";
require_once "include/function_html_basic.php";
startHTML();
?>

<div class="container" style="padding-top: 60px;">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">Start</a></li>
        </ol>
    </div>
    <div class="jumbotron">
        <h1>Hello, Civilist of Altis!</h1>
        <p>You can watch here your ingame Inventory, your Houses and your Cars, Helicopters and Boats. <br>
            Plan your next Travel on Altis, even if your are offline. Here you can watch your ingame inventory, your houses and your vehicles. <br>
            Plan your next tour on Altis, even if you are offline.</p>
        <form method="post" action="player.php" role="form" >
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter your Steam ID here" name="steam_id" >
                <span class="input-group-btn">
                    <button class="btn btn-success" type="submit" >Get Your Data!</button>
                </span>
                
            </div>
        </form>
        <p><a class="btn btn-default" href="steam_id.php" role="button">How to find your Steam User ID</a></p>
</div>
</div>

<?php
closeHTML();

       