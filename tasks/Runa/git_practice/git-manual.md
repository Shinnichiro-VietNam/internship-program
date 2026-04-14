# Git Manual

Created by: Runa

## 1.KeyKey Concepts / 基本概要

- This is a summary of basic Git workflows and rules
- Gitのルールと使い方について

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

### Version control system / バージョンコントロールシステム

- A version control system is a tool that records and manages changes to files, allowing you to track history, revert to previous versions, and collaborate safely with others.
- バージョン管理システムとは、ファイルの変更履歴を記録・管理し、過去の状態に戻したり、複数人で安全に作業できるようにする仕組み

### Centralized / 集中型(CVS,Subversion)

- A system where a single central server stores all history, and everyone works by accessing it.
- １つの中央サーバーで履歴を管理し、全員がそこにアクセスして作業する方法

### Distributed / 分散型(Git,Mercurial)

- A system where each user has a full copy of the repository, and history is managed in a distributed way.
- 各自が完全な履歴を持つリポジトリを持ち、分散して管理する方法

---

## 2.Basic Commands / 基本コマンド

- **git clone**:
  - Copy a remote repository to my local machine.
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
- **git pull**:
  - Bring the latest remote status to your local machine.
  - リモートの最新情報を取得する(他人の変更をもらう)

### Staged vs　Unstaged
- Staged(ステージング済み)
  - Added to the staging area via `git add` and ready to be committed.
  - `git add`によって保存するリストに追加され、コミットする準備が整った状態
- Unstaged(未ステージング)
  - Changes that have not been added with `git add` yet.
  - まだ`git add`していない状態

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
- **refactor:**
  - Code changes that neither fix a bug nor add a feature.
  - バグ修正や新機能追加ではないコードの構造変更
- **chore:**
  - Maintenance tasks
  - その他雑務

> **Benefit / メリット**:
> Makes it easy to understand the purpose
> 履歴を確認する際にそれぞれの変更の目的を理解しやすくなる

---

## 5. How to Resolve Merge Conflicts / コンフリクトの解消方法

### Steps to Resolve / 解消の手順

1. **Pull the latest changes / 最新の変更を取り込む**:
  - Fetch and Merge the latest version from the remote repository.
  - リモートから最新の変更を取得してマージを試みる
  - `git pull origin main`

2. **Identify the conflict / 変更を選択する**:
  - Open the files marked as 'both modified' in VS Code.
  - Vs Codeとかで両方が変更されましたと表示されているファイルを開く

3. **Choose the changes / 変更を選択する変更を選択する**:
  - Use VS Code UI to choose button
  - Vs Codeのボタンを使い選択する（現在の変更とか両方の残すなど）

4. **Commit the fix / 修正を記録する**:
  - After resolving stage the file and commit.
  - 解消したらファイルをステージしてコミットする
  - `git add <file>`
  - `git commit -m "fix: resolve merge conflict"`

---

##　6. Undoing changes / 変更をもとに戻す

Methods to undo mistakes or go back to a previous state.
ミスを修正したり、以前の状態に戻したりする方法

### 1. Undo the last commit / 直前のコミットを取り消す（作業内容は残す）
- `git reset --soft HEAD~1`

### 2. Discard all changes / すべての変更を捨ててもとに戻す
- `git reset --hard HEAD`

### 3. Undo a published commit (revert) / 公開済みコミットを打ち消す
- `git revert <commit_id>`

### Key Difference / 使い分けのポイント
- **reset**:
  - Used to "rewind time" within my own local PC.
  - 自分のPCの中だけで時間を巻き戻すときに使う
- **revert**:
  - Used on GitHub when others have already seen the changes.
  - すでにみんながみているGitHub上で上書きする時

---

## 7. Git Rebase / リベース

### What is Rebase? / リベースとは？
Rebase is the process of moving or combining a sequence of commits to a new base commit.
リベースとは、コミットの履歴を別のコミットの上に移動させ、一本の線につなぎ直す操作

### Basic Command / 基本コマンド
1. `git checkout feature/my-task`
2. `git rebase main`

> **Note / 注意**:
> Avoid rebasing branches that have already been pushed and are being used by others.
> すでにGitHubにプッシュし他の人と共有しているブランチでリベースを行わないこと（履歴が書き換わってしまうから）

## 8.Branch Management / ブランチ管理

- **git branch**:
  - List local branches. The current branch is highlighted.
  - ローカルブランチの一覧を表示する
- **git branch [branch_name]**:
  - Create a new branch with the specified name.
  - 指定した名前で新しいブランチを作成する
- **git branch -a**:
  - List all branches (both local and remote).
  - ローカルとリモートの両方を含む、すべてのブランチを確認する
- **git branch -r**:
  - List remote branches only.
  - リモートブランチのみを確認します。

## 9.Elements of Git / Gitの要素

- Working Directory:
  - The actual location where you are editing the file
  - 実際にファイルを編集している場所
- Staging Area:
  - The location where you are preparing the commits
  - コミットを準備する場所
- Repository:
  - Where the change history is saved
  - 変更履歴が保存される場所

## 10.Tools and Platforms / Gitツールとプラットフォーム

- **Platforms**: GitHub, GitLab, Bitbucket
- **GUI Tools**: Source Tree, GitKraken, Vs Code built in functions

## 11.Main vs Supporting

- **Main Branches**:
  - `main`: Always ready for release, production use
  - `develop`: Mainline of development

- **Supporting branches**:
  - `feature/`: for new features
  - `release/`: for release preparation
  - `hotfix/`: for emergency correction
