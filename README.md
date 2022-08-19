## サブスクリプションのための構築です。

# 大前提
サブスク用なので一回払いはまた違う構成になります。
demoページ( https://codecourse-laravel-subscriptions.flc.cfbx.jp/ )と下の方にある 使い方 / できること をご参照下さい。
あと、講座が英語なので出来上がり品も英語です。実装時は適宜日本語に書き換えてください。

## インストール方法
･controllerやmodel、viewの作り方はcashierの影響を受けないのでやりやすいように作って大丈夫です。
このリポジトリを既存リポジトリにボーンと上書きしてみて、適宜mregeする…で行ける気がする。
composer.json であたらしく入ったものを確認の上、
- composer update
- composer install
していただくと、追加で必要なものが入るかと思います。
･gitのcommitの様子を追っかけてもらってもいいかもです。
デアゴスティーニ式なのでちょっとまどろっこしいのと、一時期 .lh フォルダというのがいたのですが、これの履歴は無視してください。

## 補足
### ●Models
App\Models\User で、Billableをuseしてます。これがcashierを使えるようにする準備です。
支払い絡みで色々出てくるメソッドの実装や、｢こんな事はできないのかな?｣といったことを確認したいときはこの trait Billable( vendor/laravel/cashier/src/Billable.php ) の中身(さらにいろいろtraitが入ってる)を追っかけるとやりたいことが見つかるかもしれません。

### ●Views
blade componentで作ってます。

### ●Controllers
講座を作った人( https://codecourse.com/courses/laravel-subscriptions-platform )の癖なのか、routes/web.php を見るとなにか as 別名にしたりしてややこしいことをやってますが、もっとわかりやすく、この通りにやらなくても大丈夫です。

### ●その他
･app/Policies/SubscriptionPolicy.php 作って、app/Providers/AuthServiceProvider.php に登録してます
･app/Http/Middleware/NotSubscribed.php と app/Http/Middleware/Subscribed.php 作って、app/Http/Kernel.php に登録してます。
･app/Rules/ValidCoupon.php 作ってます。
･app/Presenters 配下作ってます。 Model Subscription がstripeプラグイン由来のものなので、それを直接ゴニョゴニョするのが気が引けるから。多分…だいぶまとめに入ってて説明がよくわからんかった。


## stripe補足
stripeを利用しているのでアカウントを作ってください。開発用のテスト環境がデフォルトで存在しますので、無料でテストできます。
以下すべて｢テスト環境｣で実施する。本番は申請しないと作れないけど。

### ●色々キーを取得、 .env に貼り付ける
テストアカウントを作成後stripeのダッシュボード｢開発者｣のところからstripeの情報を色々コピーして .env に追記してください。
コピーする内容を下記に記します。

･1 stripeに接続するためのキー

左のメニューから｢API キー｣を開きます
```
STRIPE_KEY=｢API キー｣の 公開可能キー(pk_test_某 みたいの)
STRIPE_SECRET=｢API キー｣の シークレットキー(sk_test_某 みたいの)
```

･2 stripeの管理画面から色々したときに接続するためのキーと設定
※1 stripeの管理画面からなにかすることは無い、ということなら設定不要
※2 ローカルで開発してるときは、stripe側からローカルは狙えないので、 https://expose.dev/ を活用すると良い…て講座では言ってたけどインターネット上で構築してたので試してない。やり方分からない。めんどくさかったら上記と同じく設定しないで飛ばしちゃってもいいかも。

･ https://readouble.com/laravel/8.x/ja/billing.html#webhooks-csrf-protection を参考に app/Http/Middleware/VerifyCsrfToken.php に 'stripe/*', を追記。
･左のメニューから｢Webhook｣を開いて、｢エンドポイントを追加｣を押す、
｢エンドポイント URL｣に
URL + stripe/webhook
を入れる。例えば https://laravel-dayo.com/ なら
https://laravel-dayo.com/stripe/webhook

･｢リッスンするイベントの選択｣の +イベントを選択 を押して https://readouble.com/laravel/8.x/ja/billing.html#handling-stripe-webhooks の｢Stripeコントロールパネルで有効にする必要があるすべてのWebフックの完全なリストは次のとおりです。｣に載ってるやつを登録。
･最後に｢イベントを追加｣ボタンを押して出来上がったらWebhookの一覧から｢オンラインエンドポイント｣の中にある今作ったURLをクリック、｢ステータス｣とか｢リッスン対象｣とか並んでるところの｢署名シークレット｣の｢表示｣を押すと出てくる whsec_某 みたいなやつを入れる。

```
STRIPE_WEBHOOK_SECRET=whsec_某 みたいなやつ
```

･3 以下このまま貼り付けてください。
```
CASHIER_CURRENCY=jpy
CASHIER_PAYMENT_NOTIFICATION=Laravel\Cashier\Notifications\ConfirmPayment
```

### ●商品を追加する
･｢商品｣から左メニューの｢すべての製品｣→｢+商品を追加｣を押す
適宜設定していくが、サンプルの都合上
･料金体系モデル→標準の料金体系
･料金情報→月次 と 年次 を作ります。金額は明確な差をつけておいたほうがテストがし易いです。

出来上がった商品情報をみると、料金欄に月次と年次の商品が並んでいます。
月次の方をクリック(例えば ￥1,000 / 月 の部分)して、右上の方に小さく price_某 みたいのがあればコレをコピーしてDBの plans テーブルの stripe_id に貼り付ける。

php artisan migrate:fresh --seed の操作で stripe_id にすでに何か price_某 が入ってると思いますが、上書きしちゃってください。
頻繁にfreshとかするようならseederも書き換えとくといいかも。
こんな感じで、stripeで商品作る→テーブルに同じものを用意する という手順になります。
※普通の物販みたいのとは実装が異なります。

### ●｢クーポンを追加｣する
･｢商品｣から左メニューの｢クーポン｣→｢+新規｣を押す。いろんな条件で作れます。

## これで準備は完了です。たぶん。

## 使い方 / できること
https://codecourse-laravel-subscriptions.flc.cfbx.jp/ ご自由に登録ください。なにかの拍子に消えることがあるかも知れません。
テストカードは https://stripe.com/docs/testing#cards
4242424242…が、特に意図がないときは便利です。

以下ログイン後の前提です。

### ●客がサブスクを登録する
上メニューのPlansを押す→MonthlyとYearlyがあるので好きな方を押す→Name on card はTEST とかでOK、Card details に4242424…とか入れる。最初はクーポンは入れずにどうなるか確認されることをお勧めします。
サブスクが登録されると、 subscriptions テーブルと subscription_items テーブルにデータが増えます。
また、stripe管理画面の｢顧客｣にもメールアドレスがあって、それを開くとサブスクリプションの結果などがあります。
※｢サブスクリプション｣という表示のすぐ下の枠の右の方に 鉛筆、×、… のボタンがありここから色々操作することもできます。が一旦触らずに次をお試しください。

### ●客がサブスクをキャンセルする
この段階で subscriptions テーブルを見ると ends_at はnullです。
左メニューの Cancel subscription を押すとCANCELボタンがあるので押すとキャンセルされます。
subscriptions テーブルを見ると ends_at に日付が入っています。
stripe管理画面の｢顧客｣の該当ユーザを開くと｢サブスクリプション｣のところに｢○/○でキャンセル｣という表示があります。
次回の支払いは発生しません。
※webhookを設定しているようなら上記、一旦触らずにおいた 鉛筆、×、… のボタン …ボタンから、｢サブスクリプションをキャンセル｣→現在の期間の終了日→｢サブスクリプションのキャンセル｣が、サイトからのキャンセルと同じ挙動になります。webhook経由でサイトのテーブルも同じようにends_atに日付が入ります。

テストの都合登録したサブスクを消したいことがあると思いますが、



