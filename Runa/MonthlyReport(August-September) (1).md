# Runa_Internship 月次研修報告書（8月〜9月）及び10月の計画


| **作成者**  | Danh                    |
| -------- | ----------------------- |
| **作成日**  | 2026/08/17              |
| **更新日**  | 2026/09/25              |
| **対象期間** | 2026/08/17 ～ 2026/09/25 |


この報告書は、Runaさんの研修の実績（対象期間：2026/08/17〜 2026/09/25）をまとめたものです。

---

## 1. 概要

- 8月に予定していた課題（Action Patternへのリファクタリング、APIの再テスト・ユニットテスト作成）はすべて期日どおりに完了し、Backend側の学習は計画どおり終了しました。
- 9月はFrontendフェーズに入り、ReactJSプロジェクトの初期設定、TypeScript、Reactの基本は全て理解しました（JSX、state、Hooks、Router）、
- および Zustand Auth Store（トークン永続化）までを計画どおり完了しました。
- 対象期間全体を通じて、研修はスケジュールどおりに進んでおり、特に大きな問題は報告されていません。日報・PR・レビュー対応のフローも安定しています。
- 実際の演習を通じて、業務システムに必要な機能を作る力と、保守しやすいコードを書く意識が高まりました。一方で、Reactの内部的な仕組み（state・rendering・lifecycle）の理解は、今後さらに深める必要があります。
- 10月からは、Backendで作成したAPIを活用し、Fahasaを参考にしたオンライン書店（ユーザー向けサイト＋Management System）をFinal Taskとして進める予定です。

---



## 2. 計画／実績（8月〜9月）

> 8月・9月に予定していたタスクはすべて計画どおりに完了しました。


| 週     | 内容                                                                                                                                                                                                                 | 状況   |
| ----- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---- |
| 8月第3週 | 以前のタスクをAction Patternを使ってリファクタリングする。                                                                                                                                                                               | ✅ 完了 |
| 8月第4週 | 機能を再テストし、実装したAPIのユニットテストを作成する。                                                                                                                                                                                     | ✅ 完了 |
| 9月第1週 | ReactJSプロジェクトを初期設定する。TypeScriptのtypes、interfaces、genericsを復習する。Vite + React + TypeScript、フォルダ構成、環境変数（env）を設定する。Tailwind CSSを設定し、shadcn/ui（Button、Card）を初期設定する。実践練習をする。                                             | ✅ 完了 |
| 9月第2週 | Reactの基本を学習する。JSXの基本：props、条件付きレンダリング、リスト、keys。Eventとlocal state：filter input、controlled components。React Hooks：useEffect、useMemo、useCallback。React Router：layout、nested routes、useParams、useSearchParams。実践練習をする。 | ✅ 完了 |
| 9月第3週 | Reactライブラリ Zustand Auth Store：トークンの永続化。                                                                                                                                                                            | ✅ 完了 |


---



## 3. 習得内容

- ReactJSの基本的な使い方を学び、Reactプロジェクトの始め方を理解しました。
- TypeScriptについて学び、基本的なデータの種類（types、interfaces、generics）を指定する方法を練習しました。
- Reactプロジェクトの基本的な構成（Vite、フォルダ構成、環境変数、Tailwind CSS、shadcn/ui）を学び、ファイルやフォルダの整理方法を理解しました。
- Reactで基本的な画面を作成し、props、条件付きレンダリング、リスト、keysを使って画面の各部分にデータを渡す方法を練習しました。
- Eventとlocal state（filter input、controlled components）、React Hooks（useEffect、useMemo、useCallback）、React Router（layout、nested routes、useParams、useSearchParams）を学び、練習問題を通して使い方を確認しました。
- Zustandを使ったAuth Storeとトークンの永続化について学び、実装を練習しました。
- 8月には、Action Patternへのリファクタリングと、実装済みAPIの再テスト・ユニットテスト作成を通じて、Backend側の保守しやすい構成とテストの書き方も定着しました。

**評価**

Runaさんは、Reactの基本的な使い方を理解しており、実際に機能を作ることができます。  
しかし、Reactがどのように動いているのか、また、それぞれの機能がどのようにつながっているのかについては、まだ十分に理解できていません。  
今後は、Reactの基本的な仕組み（state、rendering、lifecycle）についてさらに学習し、理解を深める必要があります。

---



## 4. 対応コスト


| 担当         | 工数（週あたり） | 主な内容                                 |
| ---------- | -------- | ------------------------------------ |
| My         | 約5時間     | 課題準備、研修計画作成、コードレビュー、フィードバック、定例会（週2回） |
| Hanh, Danh | 約1時間     | 定例会（週2回）                             |


---



## 5. メンターレビュー

**作業フローについて：** Runaさんは、プルリクエストの作成、フィードバックへの対応、レビューコメントをもとにした修正など、決められた開発フローに沿って、安定して取り組めています。また、日報のルールも守っており、進捗の共有やコミュニケーションもスムーズに行えています。

**学習・実践内容について：** Runaさんは、8月のBackend課題（Action Pattern、API再テスト・ユニットテスト）に続き、9月はReactJS、TypeScript、React Hooks、React Router、プロジェクト初期設定、Zustand Auth Store（トークン永続化）など、計画した内容を完了しました。実践を通して、学習した知識をWebアプリケーションの基本機能の開発に活用できるようになっています。

**改善点について：** Runaさんは、Reactのsyntaxやfunction、state、hooksの基本的な使い方を理解していますが、それらの内部の仕組みについては、まださらに学習する必要があります。次の段階（10月のFinal Task）では、Reactにおけるstate、rendering、lifecycleなどの仕組みをより深く理解し、学んだ知識をより効果的に活用できるようになることを期待します。メンターは、ターゲットを絞ったコードレビューやディスカッションを通じて、この理解を深められるようサポートします。

**進捗について：** 全体として、Runaさんは8月〜9月の計画どおりに学習と実装を進めており、担当したタスクもスケジュールに沿って完了できています。10月のFinal Task（Fahasa参考のオンライン書店）へ進める状態にあります。

---



## 6. 次フェーズの計画（10月）

RunaさんがBackendで作成したAPIをもとに、Final Taskとして[Fahasa](https://www.fahasa.com/)を参考にしたオンライン書店のWebサイトを作成することを提案したいです。この課題では、ユーザー向けのWebサイトと、システムを管理するためのManagement Systemの両方を作成します。以前の課題で作成したAPIを使用して開発します。 ( 3ヶ月予定）

開発中は、それぞれの機能の要件に応じて、APIの修正や追加が必要になる場合があります。このプロジェクトを通して、RunaさんはFrontendとBackendで学んだ知識を組み合わせて、1つの完成したプロジェクトを作る経験ができます。また、この課題を通して、機能の開発、API連携、データ管理、開発中に発生する追加要件への対応など、実際のプロジェクトに近い流れと要件で開発する経験ができると考えています。

### 6.1 共通タスク（出社準備）


| No. | タスク                                       | 担当     | 期限         | 状況   |
| --- | ----------------------------------------- | ------ | ---------- | ---- |
| 1   | 会社の就業規則・社内ルール（出退勤、服装、セキュリティ、情報管理）を説明する。   | Huyen  | 2026/10/09 | 未着手  |
| 2   | 秘密保持契約（NDA）・誓約書を確認し、署名してもらう。              | Huyen  | 2026/10/09 | 未着手  |
| 3   | オフィスの入館カード・Wi-Fi・座席・PCなどの業務環境を準備する。       | Huyen  | 2026/10/09 | 未着手  |
| 4   | 会社のGoogleアカウント（メール・カレンダー）を発行する。           | Suzawa | 2026/10/02 | ✅ 完了 |
| 5   | Slackアカウントを発行し、必要なチャンネルに招待する。             | Suzawa | 2026/10/02 | ✅ 完了 |
| 6   | Google Driveの必要なフォルダ（研修資料、報告書、日報など）を共有する。 | Suzawa | 2026/10/06 | 未着手  |
| 7   | Googleカレンダーに定例会（月曜日・木曜日）を登録し、招待する。        | Danh   | 臨時         | 未着手  |




### 6.2 研修体制・勤務ルール

> 10月から、研修はオンラインではなくオフィスでの出社形式に変更します。


| 項目                 | 内容                               |
| ------------------ | -------------------------------- |
| **勤務形式**           | 会社に来る                            |
| **勤務場所**           | ホーチミン                            |
| **トレーナー**          | My                               |
| **サポート担当**         | Danh                             |
| **主なコミュニケーション言語**  | 英語                               |
| **勤務日**            | 12日から                            |
| **1日の勤務時間**        | ５時間（8時から〜15時まで）                  |
| **休憩時間**           | １時間                              |
| **日報のルール**         | グーグルカレンダーに登録します。 それから日報を出してもらう   |
| **定例会**            | 今までと一緒。１週２回（月曜日、木曜日）             |
| **PR・コードレビューのルール** | 今までと一緒                           |
| **連絡ツール**          | Slack                            |
| **休暇・遅刻の連絡ルール**    | うちの社員と同じように、Slackに指導者に許可をもらってから。 |
| **その他**            |                                  |




### 6.3 週次計画


| 週   | 内容                                                                                                                             | 状況  |
| --- | ------------------------------------------------------------------------------------------------------------------------------ | --- |
| 第1週 | 最初にBEで作成したアイデアをもとに、参考になるWebサイトを検索・調査する。オンライン書店の機能を確認し、FahasaのUIと機能を理解・整理する。共通コンポーネントを作成する。Axiosのinstance、エラーハンドリング、typesを設定する。 | 未着手 |
| 第2週 | ログイン画面のUIを作成し、ログインAPIを連携する。Routerの認証を設定する。登録画面のUIを作成する。登録APIを連携する。ホーム画面のUIを作成する。                                               | 未着手 |
| 第3週 | ホーム画面のUIを作成する。ホーム画面のAPIを連携する。                                                                                                  | 未着手 |
| 第4週 | 書籍詳細画面のUIを作成する。書籍詳細画面のAPIを連携する。ショッピングカート画面のUIを作成する。注文APIを連携する。注文詳細画面のUIを作成する。                                                  | 未着手 |


---

---



# Runa_Internship Monthly Training Report (August - September)


| **Creator**          | Danh                    |
| -------------------- | ----------------------- |
| **Created at**       | 2026/08/17              |
| **Updated at**       | 2026/09/25              |
| **Reporting period** | 2026/08/17 ～ 2026/09/25 |


This report summarizes Runa's training progress for the period 2026/08/17 – 2026/09/25.

---



## 1. Summary

- All August tasks (refactoring into the Action Pattern, retesting APIs, and writing unit tests) were completed on time. Backend learning finished as planned.
- In September she moved to the Frontend phase and completed ReactJS project setup, TypeScript, React essentials (JSX, state, Hooks, Router), and the Zustand Auth Store (token persistence) as planned.
- Across the full reporting period, training stayed on schedule, with no major issues reported. Daily reports, PRs, and review follow-up also remained stable.
- Through hands-on exercises, Runa improved her ability to implement essential business-system features and write maintainable code. At the same time, she still needs to deepen her understanding of React internals (state, rendering, and lifecycle).
- From October, the plan is to proceed with the Final Task: an online bookstore (user-facing site + Management System) based on Fahasa, using the APIs she built on the Backend.

---



## 2. Plan & Actual (August - September)

> All tasks scheduled for August and September were completed as planned.


| Week       | Content                                                                                                                                                                                                                                                                             | Status |
| ---------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------ |
| Aug Week 3 | Refactor previous task into Action Pattern.                                                                                                                                                                                                                                         | ✅ Done |
| Aug Week 4 | Retest the functionality and write unit tests for the implemented APIs.                                                                                                                                                                                                             | ✅ Done |
| Sep Week 1 | Initial ReactJS project setup. Review TypeScript: types, interfaces, and generics. Set up Vite + React + TypeScript, folder structure, and environment variables (env). Set up Tailwind CSS and initialize shadcn/ui (Button, Card). Practice.                                      | ✅ Done |
| Sep Week 2 | React essentials. JSX essentials: props, conditional rendering, lists, and keys. Events and local state: filter inputs and controlled components. React Hooks: useEffect, useMemo, and useCallback. React Router: layouts, nested routes, useParams, and useSearchParams. Practice. | ✅ Done |
| Sep Week 3 | React Libraries — Zustand Auth Store: token persistence.                                                                                                                                                                                                                            | ✅ Done |


---



## 3. Skills Acquired

- Learned the basic usage of ReactJS and understood how to start a React project.
- Learned the basics of TypeScript and practiced defining types, interfaces, and generics.
- Learned the basic structure of a React project (Vite, folder structure, environment variables, Tailwind CSS, shadcn/ui) and how to organize files and folders.
- Practiced creating basic screens with React and passing data with props, conditional rendering, lists, and keys.
- Learned events and local state (filter inputs, controlled components), React Hooks (useEffect, useMemo, useCallback), and React Router (layouts, nested routes, useParams, useSearchParams), and practiced them through exercises.
- Learned Zustand Auth Store and token persistence, and practiced implementing them.
- In August, through refactoring into the Action Pattern and writing/re-running unit tests for implemented APIs, she also reinforced maintainable Backend structure and testing habits.

**Assessment**

Runa understands the basic concepts of React and can use them to develop features. However, she still needs to improve her understanding of how React works and how its different parts work together. She should continue learning the basic principles behind React (state, rendering, and lifecycle) to improve her development skills.

---



## 4. Response Cost


| Person     | Cost (per week) | Activities                                                                           |
| ---------- | --------------- | ------------------------------------------------------------------------------------ |
| My         | ~5 hours        | Preparing homework, training plan, code review, feedback, regular meetings (2x/week) |
| Hanh, Danh | ~1 hour         | Regular meetings (2x/week)                                                           |


---



## 5. Mentor Review

**Regarding the development workflow:** Runa has been consistently following the defined development workflow, including creating pull requests, responding to feedback, and making changes based on review comments. She also follows the daily reporting rules, which helps ensure smooth progress sharing and communication.

**Regarding learning and practice:** Following the August Backend tasks (Action Pattern, API retesting, and unit tests), in September Runa completed the planned Frontend topics, including ReactJS, TypeScript, React Hooks, React Router, project setup, and Zustand Auth Store (token persistence). Through practice, she has been able to apply what she has learned to develop basic features of a web application.

**Regarding areas for improvement:** Runa understands the basic syntax and how to use functions, state, and hooks in React, but she still needs to learn more about how they work internally. In the next phase (October Final Task), she should focus on gaining a deeper understanding of concepts such as state, rendering, and the lifecycle in React so that she can apply her knowledge more effectively. The mentor will support this through targeted code reviews and discussions.

**Regarding progress:** Overall, for August–September Runa has progressed with her learning and implementation as planned, and she completed her assigned tasks on schedule. She is ready to move on to the October Final Task (online bookstore based on Fahasa).

---



## 6. Next Phase Plan (October)

Based on the APIs that Runa has developed on the Backend, I would like to propose that her Final Task be to build an online book-selling website, using [Fahasa](https://www.fahasa.com/) as a reference. The task will include both a user-facing website and a Management System for managing the system, based on the APIs developed in the previous tasks.

During the development process, depending on the requirements of each function, Runa may need to update or add new APIs. Through this project, she will be able to apply and combine the knowledge she has learned in both Frontend and Backend to build a complete project. I think this task will also give Runa an opportunity to work on a project with a workflow and requirements that are relatively close to a real-world project, from developing features and integrating APIs to managing data and handling additional requirements that may arise during development.

### 6.1 Common Tasks (Onboarding for Office Work)


| No. | Task                                                                                                    | Person in charge | Deadline   | Status      |
| --- | ------------------------------------------------------------------------------------------------------- | ---------------- | ---------- | ----------- |
| 1   | Explain company rules and internal policies (attendance, dress code, security, information management). | Huyen            | 2026/10/09 | Not Started |
| 2   | Review and sign the NDA and pledge documents.                                                           | Huyen            | 2026/10/09 | Not Started |
| 3   | Prepare the office environment (access card, Wi-Fi, desk, PC, etc.).                                    | Huyen            | 2026/10/09 | Not Started |
| 4   | Create a company Google account (email and calendar).                                                   | Suzawa           | 2026/10/02 | ✅ Done      |
| 5   | Create a Slack account and invite her to the required channels.                                         | Suzawa           | 2026/10/02 | 2026/10/02  |
| 6   | Share the required Google Drive folders (training materials, reports, daily reports, etc.).             | Phuoc            | 2026/10/06 | Not Started |
| 7   | Register the regular meetings (Monday and Thursday) in Google Calendar and send invitations.            | Hanh             | Ad hoc     | Not Started |




### 6.2 Training Setup & Working Rules

> From October, the training will change from online to on-site work at the office.


| Item                                  | Details                                                                  |
| ------------------------------------- | ------------------------------------------------------------------------ |
| **Working style**                     | On-site (working at the office)                                          |
| **Work location**                     | Ho Chi Minh City                                                         |
| **Trainer**                           | My                                                                       |
| **Supporters**                        | Danh                                                                     |
| **Main communication language**       | English                                                                  |
| **Working days**                      | From October 12                                                          |
| **Working hours per day**             | 5 hours (8:00 – 15:00)                                                   |
| **Break time**                        | 1 hour                                                                   |
| **Daily report rules**                | Register the schedule in Google Calendar, then submit a daily report.    |
| **Regular meetings**                  | Same as before: twice a week (Monday and Thursday).                      |
| **PR & code review rules**            | Same as before.                                                          |
| **Communication tools**               | Slack                                                                    |
| **Leave & late arrival notification** | Same as our employees: get approval from the mentor on Slack in advance. |
| **Others**                            |                                                                          |




### 6.3 Weekly Plan


| Week   | Content                                                                                                                                                                                                                                                                           | Status      |
| ------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------- |
| Week 1 | First, search for and research reference websites based on the ideas created in the BE. Check the features of online bookstores to understand and organize the UI and functionality of Fahasa. Create common components. Configure the Axios instance, error handling, and types. | Not Started |
| Week 2 | Build the Login UI and integrate the Login API. Set up authentication for the Router. Build the Register UI. Integrate the Register API. Build the UI for the Home page.                                                                                                          | Not Started |
| Week 3 | Build the UI for the Home page. Integrate the API for the Home page.                                                                                                                                                                                                              | Not Started |
| Week 4 | Build the UI for the Book Detail page. Integrate the API for the Book Detail page. Build the UI for the Shopping Cart page. Integrate the Order API. Build the UI for the Order Detail page.                                                                                      | Not Started |


