
<div class="container ">
    <div class="row">
        <div class="col-sm-12">
            <h1><?php echo $h1; ?></h1>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2>OuDia Onlineについて</h2>
            <h3>概要</h3>
            <p>OuDia Onlineは、take-okm氏の<a href="http://take-okm.a.la9.jp/oudia/index.html">OuDia</a>をWeb版に移植したものです。</p>
            <p>
                作者hirattiがWebフレームワークによる設計開発の勉強を目的に作ったもので、以下の仕様的な特徴があります。
                <ul>
                    <li>PHPとhttpdとMySQLさえ動けばどこでも動作可能</li>
                    <li>Composerでのワンタッチインストール</li>
                    <li>CakePHP3+TwitterBootstrapUIによるレスポンシブデザイン導入</li>
                </ul>
            </p>
            <p>
                残念ながらまだ作成段階のため<u>編集機能</u>及び<u>ダイヤグラムビュー</u>はありませんが、通常の時刻表ビューに加えて以下の機能が利用可能です。
                <ul>
                    <li>各駅の駅時刻表ビュー</li>
                    <li>列車ビュー</li>
                </ul>
            </p>
            <h3>動作環境</h3>
            <p>OuDia OnlineはWebサーバ内で動作します。</p>
            <p>
                推奨動作環境は以下のとおりです。
                <ul>
                    <li>PHP 7.2.2</li>
                    <li>MariaDB 10.1.30</li>
                </ul>
                ざっと依存性を見た感じだと、PHP7.1以降+MySQL5.6以降なら動作をすると思います。
            </p>
            <p>OuDia Onlineの特徴でもありますが、OSへの依存は今の所確認されていません。Windows10上のXAMPP、MacOSX(HighSierra)上のMAMP、CentOS7上のLAMPの3種類で動作を確認しています。</p>
            <p>後述の利用許諾でも説明させていただきますが、OuDia Onlineは無保証です。動作環境に関するサポートには一切対応できません。</p>
            <h3>インストール方法</h3>
            <p>
                インストール手順は以下の通りです(以下環境にかかわらずbashを使えるものとして説明いたします)。
                <ol>
                    <li>github.comからソースをcloneする</li>
                    <li>ディレクトリに入ってcomposer installを実行する</li>
                    <li>config/db.sqlを使ってデータベースを作成する</li>
                    <li>config/app.phpの中のデータベース情報等を環境に合わせて変更する</li>
                </ol>
            </p>
            <p>config/app.phpが存在しない場合は、config/app.default.phpをコピーして作成してください(基本的にはcomposer install時に勝手に作られるはずです)。</p>
            <h3>使い方</h3>
            <p>使い方は、あえて書かなくてもいいほどには直感的にわかるようになっていると思います。</p>
            <p>トップページのアップロードフォームからoudファイルをアップロードすれば、次回からトップページにダイヤの一覧が表示されます。</p>
            <p>あとは各ダイヤのページに移動して・・・という感じです。</p>
            <p>※ 現状まだ未完成です。機能が追記され次第こちらにも必要に応じて追記いたします。</p>
        </div>
        <div class="col-sm-12">
            <h3>利用許諾</h3>
            <p>OuDia Onlineは、GNU General Public License(以下『GNU GPL』)が適用されるフリーソフトウェアです。</p>
            <p>
                <ol>
                    <li>
                        このソフトウェアは、無保証かつ無償にて頒布いたします。<br>
                        そのため、このソフトウェアの作者(以下『hiratti』)は、このソフトウェアの使用・改造・再頒布等によって発生したいかなる損害に対しても責任を負いません。
                    </li>
                    <li>
                        このソフトウェアは再頒布可能です。<br>
                        ただし、ソフトウェアを再頒布した場合、再頒布されたソフトウェアを受け取った人にも再頒布の自由が認められます。<br />
                        従って、再頒布したソフトウェアに対して、再頒布を制限するような条件を付与して再頒布することは認められません。
                    </li>
                    <li>
                        このソフトウェアを再頒布する場合は、改造の有無等にかかわらず、必ずソースファイルを同時に頒布する必要があります。
                    </li>
                    <li>
                        ソフトウェアを改造した上での再頒布は可能です。<br>
                        ただし、改造版を世に出す場合は、その改造版にもまたGNU GPLの適用が必要です。<br>
                        つまり、改造版を公開するにあたって、その改造版に対しても
                        <ul>
                            <li>ソースコードの公開</li>
                            <li>ソフトウェアの再頒布の許可</li>
                        </ul>
                        が必要となります。<br>
                        従って、ソースコードを非公開としたままでの再頒布は認められません。
                    </li>
                </ol>
            </p>
            <p>
                その他詳細については、以下のGNU GPL本文を参照してください。
                <ul>
                    <li>
                        <a href="https://www.gnu.org/licenses/gpl-3.0.html">GNU General Public License V3</a>
                    </li>
                    <li>
                        <a href="https://ja.osdn.net/projects/opensource/wiki/licenses%252FGNU_General_Public_License_version_3.0">GNU General Public License V3 日本語訳</a>
                    </li>
                </ul>
            </p>
        </div>
    </div>
</div>

