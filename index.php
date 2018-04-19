<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Twitter Sentiment Analysis App</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <a class="navbar-brand" href="#">Twitter Sentiment Analysis</a>
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="https://twitter.com/codestellar" target="_blank">Find Me on Twitter</a>
            </li>
            <li>
                <a href="https://www.facebook.com/roots.gaurav" target="_blank">Facebook</a>
            </li>
        </ul>
    </nav>


<div class="container" style="margin-top:5%;">

 <div class="row">
<div class="col-md-12">

        <form method="GET" lass="form-horizontal">
        <div class="form-group">
            <legend>Twitter Sentiment Analysis:</legend>
        </div
        <div class="form-group">
            <div class="col-md-8">
                <input type="text" placeholder="Enter keyword" name="q" class="form-control" value="">
            </div>
            <div class="col-md-4">
                <input type="submit" class="btn btn-info" />
            </div>            
        </div>

        </form>
        </div>
<?php

if(isset($_GET['q']) && $_GET['q']!='') {
    include_once(dirname(__FILE__).'/config.php');
    include_once(dirname(__FILE__).'/lib/TwitterSentimentAnalysis.php');

    $TwitterSentimentAnalysis = new TwitterSentimentAnalysis(DATUMBOX_API_KEY,TWITTER_CONSUMER_KEY,TWITTER_CONSUMER_SECRET,TWITTER_ACCESS_KEY,TWITTER_ACCESS_SECRET);

    //Search Tweets parameters as described at https://dev.twitter.com/docs/api/1.1/get/search/tweets
    $twitterSearchParams=array(
        'q'=>$_GET['q'],
        'lang'=>'en',
        'count'=>10,
    );
    $results=$TwitterSentimentAnalysis->sentimentAnalysis($twitterSearchParams);


    ?>
    <h1>Results for "<?php echo $_GET['q']; ?>"</h1>


<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th>Id</th>
            <th>User</th>
            <th>Text</th>
            <th>Twitter Link</th>
            <th>Sentiment</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php
        foreach($results as $tweet) {
            
            $color=NULL;
            if($tweet['sentiment']=='positive') {
                $color='#00FF00';
            }
            else if($tweet['sentiment']=='negative') {
                $color='#FF0000';
            }
            else if($tweet['sentiment']=='neutral') {
                $color='#FFFFFF';
            }
            ?>
            <tr style="background:<?php echo $color; ?>;">
                <td><?php echo $tweet['id']; ?></td>
                <td><?php echo $tweet['user']; ?></td>
                <td><?php echo $tweet['text']; ?></td>
                <td><a href="<?php echo $tweet['url']; ?>" target="_blank">View</a></td>
                <td><?php echo $tweet['sentiment']; ?></td>
            </tr>
            </tbody>
            <?php
        }
        ?>    
    </table>
    <?php
}

?>
</div>
</div>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
