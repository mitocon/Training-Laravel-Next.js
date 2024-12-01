## 実装内容
#### 目次
- PJ作成
- BE実装内容
- FE実装内容

### PJ作成
- GitHubリポジトリ作成
- ローカル環境の設定
- back-end（BE）をLaravelで作成
- front-end（FE）をReact Next.jsで作成
- README.mdの作成

### BE実装内容
- APIを作成
  - `getSecuritiesReportList`を作成（SecuritiesReport＝有価証券報告書）
    - DBから決算データを取得するAPIのつもり
    - 現状はダミーデータを返している
  - `get_xbrl_from_edinet`を作成中 ※未完成
    - EDINETというサービスから有価証券報告書を取得する
    - しかし、取得したデータをDBに格納できていない
- cors設定を追加
  - FEからAPIリクエストを受け付けるように設定

### FE実装内容
- 決算一覧画面の作成（デフォルト `localhost:3000/company/list`）
  - API`getSecuritiesReportList`を叩けるように実装
  - API`getSecuritiesReportList`のレスポンスを表にして表示
    - MUIコンポーネントライブラリを使って表を実装
