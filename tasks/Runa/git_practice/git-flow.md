# GitFlow Learning

## What is GitFlow? / GitFlowとはなんですか？
- GitFlow means Git's recommended strategic branch management methods for projects.
- プロジェクトにおけるGitが推奨している戦略的なブランチの管理方法

## Main Branches / メインブランチ
* **Main**:
  - already released, production-ready code
  - 公開済みで、本番向けコード
* **Develop**:
  - the base for the next version
  - 次のバージョンの基盤

## Sub Branches / 作業ブランチ
* **Feature branches**:
  - branch for additional features
  - 追加機能などのブランチ
* **Release branches**:
  - branch for release
  - リリースするためのブランチ
* **Hotfix branches**:
  - branch for emergency fixes
  - 緊急修正用のブランチ

## Development Procedure / 開発手順

### Normal / 通常版
1. create a `feature branch` from the `develop branch` / `develop branch`から`feature branch`を切る
2. work / 作業をする
3. Pull request
4. work and debugging are complete → merge/ 作業とデバックなどが終了　→　merge
5. on the release day, We'll go from development to release / リソース当日は`develop`から`release`にする
6. merge `release` into `main(master)` and `develop` / `release`を`main(master)`と`develop`にMerge
7. if we are managing the project, change the ticket / プロジェクトを管理している場合はチケットを変更させる（本番用に）

### Emergency / 緊急対応版
1. create a `hotfix` from the `main` / `main`から`hotfix`を作る
2. once you've finished the `feature`, send a pull request to `hotfix` / `feature`が終わったら`hotfix`にプルリクを送る
3. merge `hotfix` into `main` and `develop` / `hotfix`を`main`と`develop`にmerge

## Deployable Branch Strategies / デプロイ可能なブランチ戦略
Methods for maintaining a state where you can safely release to the production environment at any time.
いつでも安全に本番環境へリリースできる状態を維持するための方法

1. GitHub Flow
- Features
  - The `main branch` is always deployable.
  - It is widely adopted and popular among many web development teams.
  - 常に`main`ブランチがデブロイ可能
  - 多くのWEB開発チームで採用されている最も人気が高い

2. Trunk-Based Development(TBD)
- Features
  - Everyone works on a single branch.
  - Because everyone always shares the latest code, merge conflicts do not occur.
  - A strategy that prioritizes speed
  - 全員が１つのブランチで作業する
  - 常に最新のコードを全員が共有するためマージ地獄がおこらない
  - スピードを重視した戦略

3. GitFlow
- Features
  - This is suitable for situations where you need to ensure a precise release timing for mobile apps or embedded software.
  - Even after development is complete, you must go through the steps of `develop` → `release` → `main`.
  - モバイルアプリや組み込むソフトなどリリースタイミングをしっかりさせるときに適している
  - 開発が終わっても`develop`→`release`→`main`と段階を踏まなければならない