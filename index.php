<?php
if (empty($_GET["list"])) {
	$list = file_get_contents("db/plist.txt");
} else {
	$list = file_get_contents("db/".htmlspecialchars($_GET["list"]));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Cloud Media Player</title>
<style>
html {
	height: 100%;
	margin: 0 auto;
	padding: 0;
	display: table;
}

body {
	min-height: 100%;
	margin: 0 auto;
	padding: 0;
	display: table-cell;
	vertical-align: middle;

	background: #222222;
}
</style>
<link href="./lib/skin/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./lib/jquery.min.js"></script>
<!--<script type="text/javascript" src="./lib/zepto.min.js"></script>-->
<!--<script type="text/javascript" src="./lib/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="./lib/jplayer.playlist.min.js"></script>-->
<script type="text/javascript" src="./lib/jquery.jplayer.js"></script>
<script type="text/javascript" src="./lib/jplayer.playlist.js"></script>

<script type="text/javascript" src="./lib/aurora/aurora.js"></script>
<!--<script type="text/javascript" src="./lib/aurora/aac.js"></script>-->
<script type="text/javascript" src="./lib/aurora/flac.js"></script>
<script type="text/javascript" src="./lib/aurora/mp3.js"></script>
<script type="text/javascript" src="./lib/aurora/ogg.js"></script>
<script type="text/javascript" src="./lib/aurora/opus.js"></script>
<script type="text/javascript" src="./lib/aurora/vorbis.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

	var pl = new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, [
		{
			title:"Incredibles Teaser",
			artist:"Pixar",
			m4v: "http://www.jplayer.org/video/m4v/Incredibles_Teaser.m4v",
			ogv: "http://www.jplayer.org/video/ogv/Incredibles_Teaser.ogv",
			webmv: "http://www.jplayer.org/video/webm/Incredibles_Teaser.webm",
			poster: "http://www.jplayer.org/video/poster/Incredibles_Teaser_640x272.png"
		},
<?=$list?>
	], {
		swfPath: "./lib",
		supplied: "mp3,m4a,flac,oga,aac,wav,flv,m4v,ogv,webmv",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		audioFullScreen: true,

		preload: 'auto',
		volume: 1,

		solution: "html,flash,aurora",
		auroraFormats: "mp3,flac,oga,wav",

//		warningAlerts: true,
		errorAlerts: true,

		keyBindings: {
				/*previous: {
					key: 52, // ←
					fn: function() {
						self.previous();
					}
				},
				next: {
					key: 54, // →
					fn: function() {
						self.next();
					}
				},
				shuffle: {
					key: 83, // s
					fn: function() {
						self.shuffle();
					}
				},*/
				/*play: {
					key: 32, // space
					fn: function(f) {
						if(f.status.paused) {
							f.play();
						} else {
							f.pause();
						}
					}
				},*/
				play: {
					key: 80, // p
					fn: function(f) {
						if(f.status.paused) {
							f.play();
						} else {
							f.pause();
						}
					}
				},
				fullScreen: {
					key: 70, // f
					fn: function(f) {
						if(f.status.video || f.options.audioFullScreen) {
							f._setOption("fullScreen", !f.options.fullScreen);
						}
					}
				},
				muted: {
					key: 77, // m
					fn: function(f) {
						f._muted(!f.options.muted);
					}
				},
				volumeUp: {
					key: 190, // .
					fn: function(f) {
						f.volume(f.options.volume + 0.1);
					}
				},
				volumeDown: {
					key: 188, // ,
					fn: function(f) {
						f.volume(f.options.volume - 0.1);
					}
				},
				loop: {
					key: 76, // l
					fn: function(f) {
						f._loop(!f.options.loop);
					}
				}
		}
	});

	// for quit
	$(window).on("beforeunload", function(e) {
		localStorage.setItem("select", pl.current);
	});
	// for startup
	//pl.select(localStorage.select);
	pl.current = localStorage.select;
});
//]]>
</script>
</head>

<body>
<div id="jp_container_1" class="jp-video jp-video-270p" role="application" aria-label="media player">
	<div class="jp-type-playlist">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-previous" role="button" tabindex="0">previous</button>
						<button class="jp-play" role="button" tabindex="0">play</button>
						<button class="jp-next" role="button" tabindex="0">next</button>
						<button class="jp-stop" role="button" tabindex="0">stop</button>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-toggles">
						<button class="jp-repeat" role="button" tabindex="0">repeat</button>
						<button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
						<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
					</div>
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jp-playlist">
			<ul>
				<li>&nbsp;</li>
			</ul>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>
<a href="plist.php">プレイリスト更新</a>
</body>
</html>
