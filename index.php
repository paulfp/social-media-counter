<?php
require('./db.php');

// Get slider settings
$sql = 'SELECT * FROM settings WHERE id = 1';
foreach ($dbh->query($sql) as $row) {
	$scrollDirection = $row['scrollDirection'];
	$intervalTime = $row['intervalTime'];
	$animationSpeed = $row['animationSpeed'];
	$refreshIntervalMinutes = $row['refreshIntervalMinutes'];
	$refreshIntervalSeconds = (int)$refreshIntervalMinutes * 60;
}

// This is the width/height in pixels of the display,
// made up of RGB LED Matrix boards. Eg. 64x16
$counterWidth = "64";
$counterHeight = "16";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="<?php echo $refreshIntervalSeconds;?>" >
<style type="text/css">
body {
	background-color: black;
	margin: 0;
	padding: 0;
}

div.countValue p {
	margin: 0;
	padding: <?=$counterHeight/8;?>px 0;
	height: <?=$counterHeight;?>px;
	overflow: hidden;
	color: white;
	font-family: Arial, sans-serif;
	font-size: <?=round(($counterHeight/16)*15);?>px;
	line-height: <?=round(($counterHeight/16)*15);?>px;
	font-weight: bold;
	/*border: 1px solid lime;*/
}

div.counterWrapper {
	/*border: 1px solid white;*/
}

div.counterWrapper, 
#slider .viewport, 
#slider .overview, 
#slider .overview li {
	width: <?=$counterWidth;?>px;
}

div.counterWrapper, 
#slider .viewport, 
#slider .overview, 
#slider .overview li,
div.networkLogo {
	height: <?=$counterHeight;?>px;
}

div.networkLogo img {
	width: <?=$counterHeight;?>px;
	height: <?=$counterHeight;?>px;
}

div.networkLogo {
	float: left;
}

div.countValue {
	text-align: right;
}

/* Tiny Carousel */
#slider { 
	height: 1%;
	overflow: hidden;
	
}
#slider .viewport { 
	float: left; 
	padding: 0px; 
	overflow: hidden; 
	position: relative; 
}
#slider .overview { 
	list-style: none; 
	position: absolute; 
	padding: 0; 
	margin: 0; 
	left: 0; 
	top: 0; 
}
#slider .overview li { 
	float: left; 
	margin-right: 20px;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="./tinycarousel/jquery.tinycarousel.js"></script>
	<script type="text/javascript">
		/**/
		$(document).ready(function()
		{
			$('#slider').tinycarousel({
				 axis   		: "<?=$scrollDirection;?>",
				 interval 		: "true",
				 intervalTime 	: <?=$intervalTime;?>,
				 animationTime	: <?=$animationSpeed;?>
			});
		});
	</script>
</head>
<body>
<?php
// Accounts to monitor
$sql = 'SELECT * FROM social_accounts WHERE id = 1';
foreach ($dbh->query($sql) as $row) {
	$twitterUsername = $row['twitterUsername'];
	$youTubeChannel = $row['youTubeUsername'];
	$facebookPage = $row['facebookPage'];
	$instagramUsername = $row['instagramUsername'];
}

// Credentials needed
$sql = 'SELECT * FROM credentials WHERE id = 1';
foreach ($dbh->query($sql) as $row) {
	$apiKey_youtube = $row['googleApiKey'];
	$facebookAppID = $row['facebookAppId'];
	$facebookAppSecret = $row['facebookSecret']; 
}

$ch = curl_init();
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

// Get YouTube subscribers
if(!is_null($youTubeChannel)) {
	$url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername='.$youTubeChannel.'&key='.$apiKey_youtube;
	curl_setopt($ch,CURLOPT_URL,$url);
	$output = curl_exec($ch);

	$youTubeData = json_decode($output, true);
	$youTubeSubscribers = $youTubeData['items'][0]['statistics']['subscriberCount'];
}

// Get Twitter followers
if(!is_null($twitterUsername)) {
	$url = 'https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names=' . $twitterUsername;
	curl_setopt($ch,CURLOPT_URL,$url);
	$output = curl_exec($ch);

	$twitterData = json_decode($output, true);
	$twitterFollowers = $twitterData[0]['followers_count'];
}

// Get Facebook page likes
if(!is_null($facebookPage)) {
	$url = 'https://graph.facebook.com/v2.9/'.$facebookPage.'/?fields=fan_count&access_token=' . $facebookAppID . '|' . $facebookAppSecret;
	curl_setopt($ch,CURLOPT_URL,$url);
	$output = curl_exec($ch);

	$facebookData = json_decode($output, true);
	$facebookLikes = $facebookData['fan_count'];
}

// Get Instagram followers
if(!is_null($instagramUsername)) {
	$url = 'https://www.instagram.com/web/search/topsearch/?query=' . $instagramUsername;
	curl_setopt($ch,CURLOPT_URL,$url);
	$output = curl_exec($ch);

	$instagramData = json_decode($output, true);	
	$userNotFound = 1;
	foreach($instagramData["users"] as $instagramResult) {
		if($instagramResult["user"]["username"] == $instagramUsername) {
				$instagramFollowers = $instagramResult["user"]["follower_count"];
				$userNotFound = 0;
				break;
		}
	}
	if($userNotFound) {
		$instagramFollowers = NULL;
	}
}
curl_close($ch);
?>
	<div id="slider">
		<div class="viewport">
			<ul class="overview">
				<?php if(!is_null($youTubeChannel)) { ?><li>
					<div class="counterWrapper">
						<div class="networkLogo">
							<img src="./logos/YouTube-social-squircle_red_128px.png" />
						</div>
						<div class="countValue">
							<p><?=number_format($youTubeSubscribers);?></p>
						</div>
					</div>
				</li><?php } 
						if(!is_null($twitterUsername)) { ?>
				<li>
					<div class="counterWrapper">
						<div class="networkLogo">
							<img src="./logos/Twitter_Logo_Blue_cropped.png" />
						</div>
						<div class="countValue">
							<p><?=number_format($twitterFollowers);?></p>
						</div>
					</div>
				</li><?php } 
						if(!is_null($facebookPage)) { ?>
				<li>
					<div class="counterWrapper">
						<div class="networkLogo">
							<img src="./logos/FB-f-Logo__blue_144.png" />
						</div>
						<div class="countValue">
							<p><?=number_format($facebookLikes);?></p>
						</div>
					</div>
					</li><?php }
				if(!is_null($instagramFollowers)) { ?>
				<li>
					<div class="counterWrapper">
						<div class="networkLogo">
							<img src="./logos/IG_Glyph_Fill.png" />
						</div>
						<div class="countValue">
							<p><?=number_format($instagramFollowers);?></p>
						</div>
					</div>
					</li><?php } ?>
			</ul>
		</div>
	</div>

</body>
</html>