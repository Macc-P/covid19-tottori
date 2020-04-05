<!doctype html>
<html lang="ja">
    <head>
      <!-- Bootstrap必須meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

      <!-- アイコン -->
      <link rel="icon" href="https://macchatea.net/media/cropped-logo_blog-32x32.png" sizes="32x32" />
      <link rel="icon" href="https://macchatea.net/media/cropped-logo_blog-192x192.png" sizes="192x192" />
      <link rel="apple-touch-icon-precomposed" href="https://macchatea.net/media/cropped-logo_blog-180x180.png" />
      <meta name="msapplication-TileImage" content="https://macchatea.net/media/cropped-logo_blog-270x270.png" />

      <!-- OGP -->
      <title>鳥取県新型コロナウイルスデータ</title>
      <meta property="og:type" content="blog" />
      <meta property="og:title" content="鳥取県新型コロナウイルスデータ" />
      <meta property="og:description" content="鳥取県の新型コロナウイルスデータをグラフにまとめています。" />
      <meta property="og:image" content="https://macchatea.net/media/cropped-logo_blog-270x270.png" />
      <meta name="twitter:card" content="summary" />
      
      <!-- CSS（今のところ未使用）
      <link rel="stylesheet" type="text/css" href="./css.css"> -->
    </head>

    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded" style="margin-bottom: 10px;">
      <a class="navbar-brand" href="#">鳥取県新型コロナウイルスデータ<span id="lastedit"></span></a>
    </nav>
    </div>

    <body style="margin-top: 10px;">
      <div class="container">
                              <!-- ヘッダーメッセージ -->

            <div class="row row-cols-1 row-cols-lg-2">

                  <div class="col mb-4">
                        <div class="card">
                              <div class="card-header">
                                    <i class="fas fa-vial"></i>
                                    PCR検査実施結果
                              </div>
                              <div class="card-body">
                                    <ul class="nav nav-tabs">
                                          <li class="nav-item"><a class="nav-link active" href="#pcrtest_day" data-toggle="tab">
                                                日別<span class="badge badge-info" id="pcrtest_day_bad"></span>
                                          </a></li>
                                          <li class="nav-item"><a class="nav-link" href="#pcrtest_total" data-toggle="tab">
                                                累計<span class="badge badge-info" id="pcrtest_total_bad"></span>
                                          </a></li>
                                    </ul>
                                    <div class="tab-content">
                                          <div class="tab-pane active" id="pcrtest_day">
                                                <canvas id="pcrtest_1">
                                          </div>
                                          <div class="tab-pane" id="pcrtest_total">
                                                <canvas id="pcrtest_2">
                                          </div>
                                     </div>

                              </div>
                              <div class="card-footer text-muted">
                                    <small><a href="https://www.pref.tottori.lg.jp/item/1197213.htm">鳥取県HP</a>より</small>
                              </div>

                            </div>
                  </div>

                  <div class="col mb-4">
                        <div class="card">
                              <div class="card-header">
                                    <i class="fas fa-phone-alt"></i>
                                    発熱・帰国者・接触者相談センターの相談件数
                              </div>
                              <div class="card-body">
                                    <ul class="nav nav-tabs">
                                          <li class="nav-item"><a class="nav-link active" href="#tel_day" data-toggle="tab">
                                                日別<span class="badge badge-info" id="tel_day_bad"></span>
                                          </a></li>
                                          <li class="nav-item"><a class="nav-link" href="#tel_total" data-toggle="tab">
                                                累計<span class="badge badge-info" id="tel_total_bad"></span>
                                          </a></li>
                                    </ul>
                                    <div class="tab-content">
                                          <div class="tab-pane active" id="tel_day">
                                                <canvas id="tel_1">
                                          </div>
                                          <div class="tab-pane" id="tel_total">
                                                <canvas id="tel_2">
                                          </div>


                                    </div>
                              </div>
                              <div class="card-footer text-muted">
                                    <small><a href="https://www.pref.tottori.lg.jp/item/1197213.htm">鳥取県HP</a>より</small>
                              </div>

                            </div>
                  </div>


                  <div class="col mb-4">
                        
                  </div>
            </div>
                  <!-- フッターメッセージ -->
                  <p><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#tel_modal">
                        県公式と相談件数の値が異なるのはなぜ
                  </button></p>

                  <div class="modal fade" id="tel_modal" tabindex="-1" role="dialog" aria-labelledby="tel_modal_label">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="tel_modal_label">県公式と問い合わせの値が異なる</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>鳥取県がホームページで公表している相談件数の累計値と、各日のデータを足したときの合計値が異なることがあります。（3/30等）<br>
                              少なくとも、3/29のデータでは計算が合っていましたが、そこからズレが発生しています。<br>
                              このサイトのデータは<b>日別の相談件数の合計</b>を算出しています。</p>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->


                  <small>
                        <p>鳥取県HPからのデータは<a href="https://docs.google.com/spreadsheets/d/1rEuzuQYLDQQ0hsjTdtfXXxdbhrtJkf9OLn6zXjibRY8/edit?usp=sharing">Googleスプレッドシート</a>で管理しています。</p>
                        <p>チャート生成：<a href="https://www.chartjs.org/">Chart.js</a> デザイン：<a href="https://getbootstrap.com/">Bootstrap</a> 絵文字：<a href="https://fontawesome.com/">Font Awesome</a><br>
                        サイトのソースコードは<a href="https://github.com/Macc-P/covid19-tottori">GitHub</a>で管理しています。</p>
                  </small>

      </div>


      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <!-- Chart -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
      <script src="./chart.php"></script>
      
      </body>
</html>