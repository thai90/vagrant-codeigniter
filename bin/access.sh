#!/bin/bash
#下のファンクションはアクセス解析を担当する。
#@param1: サーバーのアクセスログフィアル経路
#@param2: アクセス対象のページ
function accessCount
{
    accessNum=0
    if [ -f "$1" ]; then
        while read line
        do
            if [[ "$line" == *$2* ]]; then
                ((accessNum++))
            fi
        done <$1
        echo $accessNum
    else
        echo "File not found"
    fi
}

logFilePath="/var/log/httpd/vagrant-codeigniter-access_log"
loginPageUrl="GET /user/login HTTP/1.1"
regPageUrl="GET /user/register HTTP/1.1"
homePageUrl="GET /user/homepage HTTP/1.1"

#アクセス解析結果をアウトプットのフィアル
outFile="/vagrant/bin/access_count.txt"

#アクセス解析を実施、結果を取る
accessLoginNum=$(accessCount "$logFilePath" "$loginPageUrl")
accessRegNum=$(accessCount "$logFilePath" "$regPageUrl")
accessHomepageNum=$(accessCount "$logFilePath" "$homePageUrl")

#解析結果をファイルに記述
cat > $outFile << _EOF_
$accessLoginNum : $loginPageUrl
$accessRegNum : $regPageUrl
$accessHomepageNum : $homePageUrl
_EOF_

#アクセス解析の結果をユーザにメール送る
mail -s "Daily access report" thai@realworld.jp < $outFile
