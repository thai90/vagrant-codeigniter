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
loginPageUrl="/user/login HTTP/1.1"
regPageUrl="/user/register HTTP/1.1"
homePageUrl="/user/homepage HTTP/1.1"

#アクセス解析結果をアウトプットのフィアル
outFile="/vagrant/bin/access_count.txt"

accessLoginNum=$(accessCount "$logFilePath" "$loginPageUrl")
accessRegNum=$(accessCount "$logFilePath" "$regPageUrl")
accessHomepageNum=$(accessCount "$logFilePath" "$homePageUrl")

cat > $outFile << _EOF_
$accessLoginNum : $loginPageUrl
$accessRegNum : $regPageUrl
$accessHomepageNum : $homePageUrl
_EOF_
echo "hello"

#アクセス解析の結果をユーザにメール送る
mail -s "Daily access report" thai@realworld.jp < $outFile
