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

## Supporting Branches / 作業ブランチ
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