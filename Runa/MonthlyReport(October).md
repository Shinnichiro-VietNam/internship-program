# Runa_Internship 月次研修報告書（10月）

| | |
| --- | --- |
| **作成者** | Danh |
| **作成日** | 2026/10/30 |
| **対象期間** | 2026/10/12 ～ 2026/10/30 |

10月12日から、Runaさんは出社して研修を行い、最終課題として [Fahasa](https://www.fahasa.com/) を参考にしたオンライン書店のWebサイト作成を開始しました。バックエンド側のデータ処理は、これまでの課題で作成済みです。対象期間の作業は3週間です（10/12〜10/16、10/19〜10/23、10/26〜10/30）。

---

## 1. 概要

10月12日から、研修はオンラインからホーチミンのオフィスでの出社形式に変わりました。1日の勤務時間は8:00〜15:00で、昼休みは1時間です。トレーナーは引き続きMyで、Danhが必要に応じてサポートします。主なコミュニケーション言語は英語で、定例会は週2回（月曜日・木曜日）です。毎日の終わりにGoogleカレンダーへ作業内容を記録し、日報を提出します。休暇や遅刻の場合は、事前にSlackで指導者へ連絡します。

10月にRunaさんが行った作業は次のとおりです。

- 新しいプロジェクトへ移行し、以前の課題の続きではなく、書籍販売Webサイトを作成した。
- Fahasaを参考に必要な機能を整理し、次の3つに分類した。購入を完了するために必要な機能、後から追加できる機能、課題の範囲外の機能。
- ButtonやInputなどの共通コンポーネントを作成し、各画面で再利用して見た目を揃えた。
- 次の3つのツールに慣れ、実践した。
  - **Zustand：** ユーザーのログイン状態を管理し、保存する。
  - **Axios：** APIを呼び出し、Webサイトとサーバーの間でデータを取得・送信する。
  - **Formik：** ログインと登録のフォームを処理し、送信前に入力内容を確認する。

10月末時点の結果：

- 登録、ログイン、アカウント情報画面を完了した。
- Webサイトで使う書籍一覧のデータを用意した。
- ホーム、書籍詳細、カート、注文の画面は未完了である。10月は土台の完成を優先したためであり、これらの画面は11月に続ける。

---

## 2. 計画／実績

| 週 | 内容 | 状況 |
| --- | --- | --- |
| 第1週（10/12〜10/16） | Fahasaを参照し、ホーム、カテゴリ、書籍詳細、検索、カート、ログイン、登録などの主な機能を記録した。新しいWebサイトを初期設定した。ButtonとInputなどの共通コンポーネントを作成し、動作確認用の画面を作った。 | ✅ 完了 |
| 第2週（10/19〜10/23） | 登録、ログイン、ログアウト、ログイン後のアカウント情報画面を完了した。 | ✅ 完了 |
| 第3週（10/26〜10/30） | 書籍一覧APIを準備し、フロントエンドのルートを定義した。 | ✅ 完了 |

---

## 3. 習得内容

- Fahasaのような実際の販売サイトを参考にし、主な機能を調べ、課題で実装する機能を決める方法を学んだ。
- 新しいWebサイトを立ち上げ、ButtonやInputなどの共通コンポーネントを作り、複数の画面で使い回して見た目を揃え、修正しやすくする方法を学んだ。
- APIを整理して使い、フロントエンドがバックエンドからデータを取得する方法を理解した。
- フロントエンドのルートを作成・管理し、APIを各画面につなぐ方法を学んだ。
- 登録、ログイン、ログアウトを実装し、ログイン状態の扱い方を理解した。
- 作成後にコンポーネントと機能の動作を確認し、作業中の不具合を見つけて直す方法を学んだ。

**評価**

Runaさんは、要件の整理、共通コンポーネントの作成、API連携、ログイン機能まで、オンライン書店の土台を完了しました。これにより、フロントエンドの各部分がバックエンドとどのようにつながり、データがどのように処理されるかを、初歩的に理解できています。

一方、現時点の機能は土台に集中しており、書店サイトの画面はまだ完成していません。11月は、これまでに作った部分をつなぎ、ヘッダー、フッター、ホーム、書籍詳細、カートを完成させる必要があります。また、機能を個別に終わらせるだけでなく、ユーザーの操作のあと、画面がどのようにデータを更新するかについても、より深く理解する必要があります。

---

## 4. 対応コスト

| 担当 | 工数（週あたり） | 主な内容 |
| --- | --- | --- |
| My | 約5時間 | 課題準備、研修計画作成、コードレビュー、フィードバック、定例会（週2回） |
| Hanh, Danh | 約1時間 | 定例会（週2回） |

---

## 5. メンターレビュー

**作業の進め方について：** Runaさんは、会社での出社勤務に慣れ始めています。課題の中で要件を受け取り、指導者と相談し、フィードバックに沿って作業を調整できています。

**実施内容について：** Runaさんは、書籍販売サイトの土台となる作業を完了しました。内容は、Fahasaの画面調査、機能範囲の整理、共通コンポーネントの作成、登録・ログイン・ログアウト、フロントエンド向けのAPIとルートの準備です。

**今後の改善について：** 機能の動き方と、プロジェクト内の各部分のつながりを、より自分から調べる必要があります。要件どおりに機能を終えるだけでなく、データがどのように処理され、画面にどのように表示されるかを理解する必要があります。分からないことや問題があるときは、時間を失わないよう、早めに指導者へ相談してください。

**進捗について：** 10月はプロジェクトの土台を完了しました。一方、画面はまだ十分に作れていません。11月は、登録・ログイン、ホーム、書籍詳細、カート、注文機能の画面を優先して完成させてください。

---

## 6. 次フェーズの計画（11月）

最終課題は引き続き書籍販売Webサイトです。お客様向けのサイトと、管理者向けの管理画面の両方を作成します。期間は約3か月で、10月12日から開始しています。

11月に続ける作業は次のとおりです。

- 画面の仕上げ：ログインと登録の画面を直し、ホーム画面を作成する。
- ホーム：APIを接続し、書籍一覧を表示する。検索、読み込み中、0件、エラーの状態も扱う。
- 書籍詳細：画面を作成し、APIを接続して各書籍の詳細を表示する。
- カート：ショッピングカートの画面を作成する。
- 管理画面：管理レイアウト、書籍一覧、追加と編集を作成する。APIを接続し、書籍一覧を取得して表示する。

| 週 | 内容 |
| --- | --- |
| 第1週 | ログインと登録の画面を直す。ホーム画面に着手する（ヘッダー、バナー、書籍一覧の領域）。 |
| 第2週 | ホーム画面を完成させ、APIを接続して実際の書籍を1冊ずつ表示する。読み込み中、0件、エラーを表示する。書籍詳細画面に着手する。 |
| 第3週 | 書籍詳細画面を完成させ、APIで正しい情報を表示する。カート画面を作成する（選択した書籍、数量の増減、合計金額）。 |
| 第4週 | 管理画面の枠を作成する（サイドメニュー、ヘッダー）。管理側の書籍一覧を作成し、APIで実データを取得する。書籍の追加・編集フォームの画面を作成する。 |

---

# Runa_Internship Monthly Training Report (October)

| | |
| --- | --- |
| **Creator** | Danh |
| **Created at** | 2026/10/30 |
| **Reporting period** | 2026/10/12 – 2026/10/30 |

From October 12, Runa started working at the office and began the final task: an online bookstore website based on [Fahasa](https://www.fahasa.com/). The data handling on the backend was already built in earlier tasks. This period covers three working weeks: October 12–16, October 19–23, and October 26–30.

---

## 1. Summary

From October 12, training changed from online study to on-site work at the office in Ho Chi Minh City. Working hours are 8:00–15:00, with a one-hour lunch break. My remains the main trainer, and Danh supports when needed. Communication is mainly in English, with regular meetings twice a week, on Monday and Thursday. At the end of each day, Runa records the work in Google Calendar and submits a daily report. Leave and late arrival must be reported to the mentor on Slack in advance.

In October, Runa completed the following work:

- Moved to a new project and started building a bookstore website, instead of continuing the previous exercises.
- Studied Fahasa to identify the features to build, then grouped them into three sets: features required to complete a purchase, features that can be added later, and features outside the scope of this task.
- Built shared components such as Button and Input so later screens can reuse them and keep a consistent interface.
- Practiced three tools:
  - **Zustand:** manages and stores the user's login state.
  - **Axios:** calls APIs to fetch and send data between the website and the server.
  - **Formik:** handles the login and registration forms and checks the input before it is sent.

Results at the end of October:

- Registration, login, and the account page are done.
- Book-list data is ready for the website.
- The home page, book detail page, cart, and order screens are not finished. In October, Runa focused on the foundation first. These screens will continue in November.

---

## 2. Plan and actual

| Week | Work done | Status |
| --- | --- | --- |
| Week 1 (Oct 12–16) | Reviewed Fahasa and noted the main features: home, category, book detail, search, cart, login, and registration. Set up the new website. Created shared components such as Button and Input, and built a trial page to check that they work. | ✅ Done |
| Week 2 (Oct 19–23) | Finished registration, login, logout, and the account page after login. | ✅ Done |
| Week 3 (Oct 26–30) | Prepared the book-list API and defined the frontend routes. | ✅ Done |

---

## 3. Skills acquired

- Learned how to study a real shopping site such as Fahasa, identify the main features, and decide which ones belong in the task.
- Learned how to start a new website and build shared components such as Button and Input, reuse them across screens, keep the interface consistent, and make later changes easier.
- Understood how to organize and use APIs so the frontend can get data from the backend.
- Learned how to create and manage frontend routes so each screen is connected to the matching API.
- Practiced registration, login, and logout, and learned how the user's login state is handled.
- Learned how to check components and features after building them, then find and fix problems during the work.

**Assessment**

Runa completed the foundation of the bookstore website, from understanding the requirements and building shared components to connecting APIs and handling login. Through this work, she has begun to see how the parts of the frontend connect to the backend and how the data is processed.

The work so far is still concentrated on that foundation, and the bookstore screens are not finished. In November, Runa needs to connect the parts already built and complete the header, footer, home page, book detail page, and cart. She also needs a clearer understanding of how the screen updates its data after each user action, rather than only finishing each feature on its own.

---

## 4. Response cost

| Person | Hours per week | Main work |
| --- | --- | --- |
| My | about 5 hours | Preparing tasks, training plan, code review, feedback, regular meetings (twice a week) |
| Hanh, Danh | about 1 hour | Regular meetings (twice a week) |

---

## 5. Mentor review

**Working style.** Runa has started to get used to working on-site at the company. During the task, she can take in requirements, discuss them with the mentor, and adjust the work based on feedback.

**Work completed.** Runa finished the foundation of the bookstore website. This includes studying the Fahasa screens, defining the feature scope, building shared components, completing registration, login, and logout, and preparing the API and routes for the frontend.

**What to work on next.** Runa needs to look more actively into how each feature works and how the parts of the project connect. Finishing a feature as requested is not enough. She needs to understand how the data is processed and shown on the screen. When something is unclear or a problem comes up, she should ask the mentor early so time is not lost.

**Progress.** In October, Runa completed the foundation of the project. The screens are not fully in place yet. In November, the focus should be the registration and login screens, the home page, the book detail page, the cart, and the ordering features.

---

## 6. November plan

The final task is still the bookstore website, with two parts: a site for customers and an admin site. The expected duration is about three months, starting from October 12.

In November, Runa will continue with the following:

- Finish the screens: update the login and registration screens, and build the home page.
- Home page: connect the API to show the book list, and handle search, loading, empty, and error states.
- Book detail: build the screen and connect the API so each book shows its details.
- Cart: build the shopping-cart screen.
- Admin: build the admin layout, the book list, and the add and edit features. Connect the API to load and show the book list.

| Week | Work |
| --- | --- |
| Week 1 | Revise the login and registration screens. Start the home page: header, banner, and the book-list area. |
| Week 2 | Finish the home page and connect the API so real books appear one by one. Show loading, empty, and error states. Start the book detail screen. |
| Week 3 | Finish the book detail screen and connect the API so each book shows the correct information. Build the cart screen: selected books, quantity changes, and the total price. |
| Week 4 | Build the admin frame (side menu and header). Build the admin book list and connect the API to load real data. Build the add-book and edit-book forms. |
