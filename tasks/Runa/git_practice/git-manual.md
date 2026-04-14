# Git Manual
Created by: Runa

## 1.OverView　/　概要
- This is a summary of basic Git workflows and rules
- Gitのルールと使い方について

---

## 2.Basic Commands / 基本コマンド

- **git clone**:
  - Copy a remoto repository to my local machine.
  - リモートリポジトリーをローカルにコピーする
- **git checkout -b [branch name]**:
  - Create a new branch
  - 新しいブランチを作成して切り替える
- **git add**:
  - Add changes to the staging area.
  - 変更をステージングエリアに追加する
- **git commit**:
  - Record the changes to the repository.
  - 変更をリポジトリに追加する
- **git push**:
  - Upload local changes to GitHub.
  - ローカルの変更をGitHubにアップする

---

## 3.Branch Naming Rule / ブランチ命名規則
Often used to organize projects

- **feature/**:
  - Adding new features or completing assignments.
  - 新機能の追加や課題の作成
- **fix/**:
  - Bug fixes.
  - バクの修正
- **docs/**:
  - Updates to documentation.
  - ドキュメントの更新のみ

---

## 4. Conventional Commits / コミットメッセージのルール
Include a type at the beginning of the message to describe the change.

- **feat:**
  - A new feature.
  - 新機能ついか
- **fix:**
  - A bug fix.
  - バグの修正
- **docs:**
  - Documentation only changes.
  - ドキュメントのみの修正
- **style:**
  - Changes that do not affect the meaning of the code
  - コードの意味に影響しない変更（セミコロンの追加など）
- **refector:**
  - Code changes that neither fix a bug nor add a feature.
  - バグ修正や新機能追加ではないコードの構造変更
- **chore:**
  - Maintenance taskes
  - その他雑務

> **Benefit / メリット**:
> Makes it easy to understand the purpose
> 履歴を確認する際にそれぞれの変更の目的を理解しやすくなる