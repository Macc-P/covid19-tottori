<?php 
//JSとして反応させる
header('content-type: text/javascript; charset=utf-8');

//スプレッドシートのIDとグラフで使う色を指定
$spread_id = '1rEuzuQYLDQQ0hsjTdtfXXxdbhrtJkf9OLn6zXjibRY8';
$graph_color = '#1A4472';
$graph_color2 = '#b22222';
$day_format = 'MM/DD';

$org_data = json_decode(file_get_contents("https://spreadsheets.google.com/feeds/list/".$spread_id."/1/public/values?alt=json"),true);
//シート2の取り出し（未使用）
//$org_data_city = json_decode(file_get_contents("https://spreadsheets.google.com/feeds/list/".$spread_id."/2/public/values?alt=json"),true);


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
    $postrue_data[total][] = (int)$day_data['gsx$陽性累計']['$t'];
    $postrue_data[day][] = (int)$day_data['gsx$pcr陽性']['$t'];

    //PCR陰性
    $posfalse_data[total][] = (int)$day_data['gsx$陰性累計']['$t'];
    $posfalse_data[day][] = (int)$day_data['gsx$pcr陰性']['$t'];

}

    //PCR検査数
    $pcrtested_total[datasets][] = array('data'=>$postrue_data[total],'label'=>'陽性','backgroundColor'=>$graph_color2 , 'yAxisID'=>'pcr_bar');
    $pcrtested_total[datasets][] = array('data'=>$posfalse_data[total],'label'=>'陰性','backgroundColor'=>$graph_color , 'yAxisID'=>'pcr_bar');
    $pcrtested_total[datasets][] = array('data'=>$pcrtested_data[total],'label'=>'検査数','backgroundColor'=>'rgba(0,0,255,0)','borderColor'=>'rgba(0,0,255,0)','yAxisID'=>'pcr_line','type' => 'line','fill'=>false);
    $pcrtested_total[labels] = $date;

    $pcrtested_day[datasets][] = array('data'=>$postrue_data[day],'label'=>'陽性','backgroundColor'=>$graph_color2 , 'yAxisID'=>'pcr_bar');
    $pcrtested_day[datasets][] = array('data'=>$posfalse_data[day],'label'=>'陰性','backgroundColor'=>$graph_color , 'yAxisID'=>'pcr_bar');
    $pcrtested_day[datasets][] = array('data'=>$pcrtested_data[day],'label'=>'検査数','backgroundColor'=>'rgba(0,0,255,0)','borderColor'=>'rgba(0,0,255,0)','yAxisID'=>'pcr_line','type' => 'line','fill'=>false);
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
        legend:{
            display:true,
            labels:{
                filter: function(items,chartData){
                    return items.text !== '検査数';
                }
            },
        },
        tooltips:{
            mode:'index',
            intersect:false,
        },
        scales: {
            xAxes:[{
                stacked:true,
                type:'time',
                time:{
                    unit:'week',
                    displayFormats:{
                        week: '<?php echo $day_format;?>'
                    },
                },
                stepSize:1,

            }],
            yAxes:[{
                id:'pcr_bar',
                stacked:true,

            },{
                id:'pcr_line',
                stacked:false,
                display:false,
            }]
        },

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
        legend:{
            display:true,
            labels:{
                filter: function(items,chartData){
                    return items.text !== '検査数';
                }
            },
        },
        tooltips:{
            mode:'index',
            intersect:false,
        },
        scales: {
            xAxes:[{
                stacked:true,
                type:'time',
                time:{
                    unit:'week',
                    displayFormats:{
                        week: '<?php echo $day_format;?>'
                    },
                },
                stepSize:1,

            }],
            yAxes:[{
                id:'pcr_bar',
                stacked:true,

            },{
                id:'pcr_line',
                stacked:false,
                display:false,
            }]
        },
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
        scales:{
            xAxes: [{
                type:'time',
                time:{
                    unit:'week',
                    displayFormats:{
                        week: '<?php echo $day_format;?>'
                    },
                },
                stepSize:1,
            }]
        }
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
        scales:{
            xAxes: [{
                type:'time',
                time:{
                    unit:'week',
                    displayFormats:{
                        week: '<?php echo $day_format;?>'
                    },
                },
                stepSize:1,
            }]
        }
    }
});
document.getElementById('tel_total_bad').innerHTML = '<?php echo end($tel_data[total]);?>件';