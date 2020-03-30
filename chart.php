<?php 
//JSとして反応させる
header('content-type: text/javascript; charset=utf-8');

//スプレッドシートのIDとグラフで使う色を指定
$spread_id = '1rEuzuQYLDQQ0hsjTdtfXXxdbhrtJkf9OLn6zXjibRY8';
$graph_color = '#1A4472';

$org_data = json_decode(file_get_contents("https://spreadsheets.google.com/feeds/list/".$spread_id."/1/public/values?alt=json"),true);
//シート2の取り出し（未使用）
//$org_data_city = json_decode(file_get_contents("https://spreadsheets.google.com/feeds/list/".$spread_id."/2/public/values?alt=json"),true);

//更新日時をとりだす
date_default_timezone_set('Asia/Tokyo');
$update = date("y年m月d日",strtotime($org_data[feed][updated]['$t']));

foreach($org_data[feed][entry] as $day_data){
    //日付のデータを作る
    $date[] = $day_data['gsx$日付']['$t'];

    //PCR検査数
    $pcrtested_data[total][] = (int)$day_data['gsx$pcr累計']['$t'];
    $pcrtested_data[day][] = (int)$day_data['gsx$pcr日']['$t'];

    //相談件数
    $tel_data[total][] = (int)$day_data['gsx$相談件数累計']['$t'];
    $tel_data[day][] = (int)$day_data['gsx$相談件数']['$t'];

    //PCR陽性
    $pos_data[total][] = (int)$day_data['gsx$陽性累計']['$t'];
    $pos_data[day][] = (int)$day_data['gsx$pcr陽性']['$t'];

}

    //PCR検査数
    $pcrtested_total[datasets][] = array('data'=>$pcrtested_data[total],'label'=>'累計','backgroundColor'=>$graph_color);
    $pcrtested_total[labels] = $date;

    $pcrtested_day[datasets][] = array('data'=>$pcrtested_data[day],'label'=>'日','backgroundColor'=>$graph_color);
    $pcrtested_day[labels] = $date;

    //相談件数
    $tel_total[datasets][] = array('data'=>$tel_data[total],'label'=>'累計','backgroundColor'=>$graph_color);
    $tel_total[labels] = $date;

    $tel_day[datasets][] = array('data'=>$tel_data[day],'label'=>'日','backgroundColor'=>$graph_color);
    $tel_day[labels] = $date;

    //PCR陽性
    $pos_total[datasets][] = array('data'=>$pos_data[total],'label'=>'累計','backgroundColor'=>$graph_color);
    $pos_total[labels] = $date;

    $pos_day[datasets][] = array('data'=>$pos_data[day],'label'=>'日','backgroundColor'=>$graph_color);
    $pos_day[labels] = $date;


foreach($org_data_city[feed][entry] as $day_data){
    $city[] = array('city'=>$day_data['gsx$市町村']['$t'], 'value' => (int)$day_data['gsx$感染者数']['$t']);
}

?>

//データの最終更新日
document.getElementById('lastedit').innerHTML = '（<?php echo $update;?>更新）';

//PCR日別
var ctx = document.getElementById('pcrtest_1').getContext('2d');
var chart = new Chart(ctx, {
    // 作成したいチャートのタイプ
    type: 'bar',

    // データセットのデータ
    data: <?php echo json_encode($pcrtested_day,JSON_UNESCAPED_UNICODE);?>
    
    ,

    // ここに設定オプションを書きます
    options: {

    }
});
document.getElementById('pcrtest_day_bad').innerHTML = '<?php echo end($pcrtested_data[day]);?>件（<?php echo preg_replace('#\d{4}/#','',end($date));?>）';

//PCR累計
var ctx = document.getElementById('pcrtest_2').getContext('2d');
var chart = new Chart(ctx, {
    // 作成したいチャートのタイプ
    type: 'bar',

    // データセットのデータ
    data: <?php echo json_encode($pcrtested_total,JSON_UNESCAPED_UNICODE);?>
    
    ,

    // ここに設定オプションを書きます
    options: {

    }
});

document.getElementById('pcrtest_total_bad').innerHTML = '<?php echo end($pcrtested_data[total]);?>件';

//相談日別
var ctx = document.getElementById('tel_1').getContext('2d');
var chart = new Chart(ctx, {
    // 作成したいチャートのタイプ
    type: 'bar',

    // データセットのデータ
    data: <?php echo json_encode($tel_day,JSON_UNESCAPED_UNICODE);?>
    
    ,

    // ここに設定オプションを書きます
    options: {

    }
});
document.getElementById('tel_day_bad').innerHTML = '<?php echo end($tel_data[day]);?>件（<?php echo preg_replace('#\d{4}/#','',end($date));?>）';

//相談累計
var ctx = document.getElementById('tel_2').getContext('2d');
var chart = new Chart(ctx, {
    // 作成したいチャートのタイプ
    type: 'bar',

    // データセットのデータ
    data: <?php echo json_encode($tel_total,JSON_UNESCAPED_UNICODE);?>
    
    ,

    // ここに設定オプションを書きます
    options: {

    }
});
document.getElementById('pos_total_bad').innerHTML = '<?php echo end($pos_data[total]);?>件';

//陽性日別
var ctx = document.getElementById('pos_1').getContext('2d');
var chart = new Chart(ctx, {
    // 作成したいチャートのタイプ
    type: 'bar',

    // データセットのデータ
    data: <?php echo json_encode($pos_day,JSON_UNESCAPED_UNICODE);?>
    
    ,

    // ここに設定オプションを書きます
    options: {

    }
});
document.getElementById('pos_day_bad').innerHTML = '<?php echo end($pos_data[day]);?>件（<?php echo preg_replace('#\d{4}/#','',end($date));?>）';

//陽性累計
var ctx = document.getElementById('pos_2').getContext('2d');
var chart = new Chart(ctx, {
    // 作成したいチャートのタイプ
    type: 'bar',

    // データセットのデータ
    data: <?php echo json_encode($pos_total,JSON_UNESCAPED_UNICODE);?>
    
    ,

    // ここに設定オプションを書きます
    options: {

    }
});
document.getElementById('tel_total_bad').innerHTML = '<?php echo end($tel_data[total]);?>件';
