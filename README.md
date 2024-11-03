# リポジトリ初回作成手順

- ローカルマシンでSSHキーを作成
```
ssh-keygen -t rsa -b 4096 -C "{{メルアド}}" -f ~/.ssh/{{ファイル名}}

例：ssh-keygen -t rsa -b 4096 -C "hogehoge@gmail.com" -f ~/.ssh/id_rsa_personal
```
- ~/.ssh/configを設定
```
vim ~/.ssh/config
```
```
# configファイル内
Host github-workinfo
  HostName github.com
  User git
  IdentityFile ~/.ssh/id_rsa_workinfo
  IdentitiesOnly yes

# Hostは任意
# HostName、Userは固定
# IdentityFileは先ほどのSSHキー
```

## 作業リポジトリを作成
GitHubアカウントは作成済みとする。以下bash
```
mkdir Udemy-Laravel-Next.js
cd Udemy-Laravel-Next.js
git init
git branch -m main
git config user.name "{{your name}}"
git config user.email "{{your email}}"
```

- GitHubブラウザ上でリモートリポジトリを作成。Udemy-Laravel-Next.jsなど
- SSHを控えておく（git@github.com:mitocon/Udemy-Laravel-Next.js.git）
- ローカルで以下のコマンドを実行してremote add
```
# configで設定したエイリアスを使用時
git remote add origin git@github-workinfo:mitocon/Udemy-Laravel-Next.js.git

# git@{{エイリアス}}:{{ユーザー名}}/{{リポジトリ名}}
# git remote -v でリモートリポジトリを確認できる
```

- 確認
```
ssh -T git@github-workinfo

# @以降はエイリアス
# Hi xxx! You've successfully authenticated, but GitHub does not provide shell access.
# この表示でOK
```

## commit, push
- 適当なファイルを作ってadd, commit, pushする
```
touch README.md
git add .
git commit -m "initial commit"
git push -u origin main
```

完了
