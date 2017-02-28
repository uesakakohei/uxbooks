<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>
なんちゃらFukuokaの本棚
</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
body {
	font-family: "Hiragino Sans", sans-serif;
	background: #666;
	color: #eee;
	padding: 0 0.2em;
}

a {
	color: #eee;
	font-weight: 100;
}

hr {
	height: 0;
	margin: 1.0em 0 0.4em 0;
	padding: 0;
	border: 0;
	border-top: 1px solid #999;
}

footer {
	margin-bottom: 1.4em;
}

h1 {
	font-size: 2.0em;
	font-weight: 200;
	margin: 0.4em auto 0.4em auto;
	line-height: 1.2em;
}

h1 .material-icons {
 	vertical-align: -10%;
 	font-size: 1.0em;
}

.material-icons, svg {
	vertical-align: -24%;
}

.bookImage {
	height: 160px;
	margin: 0 0.3em 1.0em 0;
}

#tags {
	margin-bottom: 1.0em;
}

.select {
	border-bottom:solid 1px #000;
	padding-bottom:5px;
}

#tags span {
	cursor:pointer;	
	margin-right: 0.6em;
	font-weight: 100;
}

#tags span.select , #tags span:hover {
	border-bottom:solid 1px #fff;
	padding-bottom: 0.1em;
}

#choice {
	line-height: 1.0em;
}
</style>

<script>

// 以下の処理を定義した要素に実行
$(function() {

// 「#tags」内の「span」がクリックされると以下の処理を実行
$("#tags span").click(function() {

// 変数「tags」を定義する
var tags = $(this).attr('id');

// クリックされたタブにのみ「.select」を与える
$("#tags span").removeClass('select');
$(this).addClass('select');

// クリックされたタブに紐づいた要素を表示、それ以外を非表示にする
$("#choice a").fadeOut(0);
if(tags) {
$("#choice ."+tags).fadeIn(600);
} else {
$("#choice a").fadeIn(600);
}
});
});

</script>

</head>

<body>

<h1><i class="material-icons">local_library</i> &#147;User Experience Fukuoka&#148;の本棚</h1>


<?php
// 以下はスプレッドシートからのJSONの読み取り

$data = "https://spreadsheets.google.com/feeds/list/1ugU9_YVPf0vemhaJGcXDPi_-VAaRyZDal0FEdn5hIas/od6/public/values?alt=json";
$json = file_get_contents($data);
$json_decode = json_decode($json);

// jsonデータ内の『entry』部分を複数取得して、postsに格納
// 本表示用とタグ表示用として、2つの変数に格納
$posts = $json_decode->feed->entry;
$posts2 = $json_decode->feed->entry;

// タグの列の文字列をスペース区切りで、子配列にいれて、それを親配列に入れる
foreach ($posts2 as $post2) {
	$koHairetsu = explode(" ", $post2->{'gsx$tag'}->{'$t'});
	foreach ( $koHairetsu as $val ) {
		 $oyaHairetsu[] = $val;
	}
}

// 配列内の重複を排除
$oyaHairetsuUnique = array_unique($oyaHairetsu);

// 配列から空の要素を削除
$oyaHairetsuUnique = array_filter($oyaHairetsuUnique, 'strlen');

// 配列の番号の飛び番を無くす
$oyaHairetsuUnique = array_values($oyaHairetsuUnique);

// print_r($oyaHairetsuUnique);

// タグメニューの表示
echo '<div id="tags">';
// echo '<span><i class="material-icons">label</i></span>';
echo '<span class="select">All</span>';

// 配列内容表示
for($i = 0 ; $i < count($oyaHairetsuUnique); $i++){
	$cTag = $oyaHairetsuUnique[$i];
    echo '<span id="';
    echo $cTag;
    echo '">#';
    echo $cTag;
    echo '</span>';
}
echo '</div>';


// 以下本の表示
echo '<div id="choice">';

// postsに格納したデータをループしつつ表示する
foreach ($posts as $post) {
	echo '<a href="https://www.amazon.co.jp/dp/';
	echo $post->{'gsx$asin'}->{'$t'};
	echo '" target="_blank" class="';
	echo $post->{'gsx$tag'}->{'$t'};
	echo '" title="';
	echo $post->{'gsx$title'}->{'$t'};
	echo '">';
	if ($post->{'gsx$image'}->{'$t'}){
		echo '<img class="bookImage" src="';
		echo $post->{'gsx$image'}->{'$t'};
		echo '">';
	} else {
		echo '<img class="bookImage" src="http://images-jp.amazon.com/images/P/';
		echo $post->{'gsx$asin'}->{'$t'};
		echo '.09._SCMZZZZZZZ_.jpg">';
	}
	echo '</a>';
}
echo '</div>';
?>

<footer>
<hr>
<a href="https://www.facebook.com/uxfukuoka/" target="_blank">
<svg style="width:24px;height:24px" viewBox="0 0 24 24">
    <path fill="#ddd" d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M18,5H15.5A3.5,3.5 0 0,0 12,8.5V11H10V14H12V21H15V14H18V11H15V9A1,1 0 0,1 16,8H18V5Z" />
</svg>
&#147;UX Fukuoka&#148; at Facebook</a>



</footer>

</body>
</html>
