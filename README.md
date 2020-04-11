# 開発終了
[東京都サイトのfork版](https://github.com/tottori-covid19)が開発されましたのであとはそちらにおまかせします。

# covid19-tottori
Googleスプレッドシートに記録している新型コロナウイルスのデータをPHPで読み出し、自動でグラフにするサイトです。

# ライセンス
スプレッドシートのデータは商用・非商用問わずご自由にどうぞ。

何らかの手段で連絡していただけると嬉しいです。

こちらのリポジトリのソースコードはMITライセンスです。

# 使いかた
[Googleスプレッドシート](https://docs.google.com/spreadsheets/d/1rEuzuQYLDQQ0hsjTdtfXXxdbhrtJkf9OLn6zXjibRY8/edit?usp=sharing)のコピーを作成し、水色部分のみ入力します。

黄緑部分やシート2は現在使っていません。白色部分は自動計算にしていますが手動で入力することもできます。

スプレッドシートで「ファイル」→「ウェブに公開」を開き「ドキュメント全体」を公開します。

chart.phpの$spread_idにスプレッドシートの固有ID（公開URLのd/e/のうしろ）を入れてindex.phpのOGPやアイコン、メッセージ部分を書き換えるだけで動くはずです。
