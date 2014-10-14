/*ツイートの入力された時間と現在の時間の時差の表示
をリターンするのファンクション*/

function displayTimeDiff(timeStamp)
{
	currentTime = new Date().getTime();
	timeForCompare = new Date(timeStamp).getTime();
	miliSecondsDiff = currentTime - timeForCompare;

	//時差は0秒より大木、６０秒より小さい
	secondsDiff = Math.floor(miliSecondsDiff / 1000);
	if(secondsDiff >=0 && secondsDiff<60)
		return secondsDiff+"秒前";

	//時差は一分より大きい、６０分より小さい
	minutesDiff = Math.floor(miliSecondsDiff / (60*1000));
	if(minutesDiff>0 && minutesDiff<60)
		return minutesDiff+"分ぐらい前";
	//時差は一時より大きい、２４時より小さい
	hoursDiff = Math.floor(miliSecondsDiff / (60*60*1000));
	if(hoursDiff>0 && hoursDiff<24)
		return hoursDiff+"時間ぐらい前";

	//時差は一日より大きい、30日より小さい
	daysDiff = Math.floor(miliSecondsDiff / (60*60*24*1000));
	if(daysDiff>0 && daysDiff<30)
		return daysDiff+"日ぐらい前";

	//時間はそのままにする
	time = new Date(timeStamp);
	year = time.getFullYear();
	month = time.getMonth();
	date = time.getDate();
	hour = time.getHours();
	minute = time.getMinutes();
	second = time.getSeconds();
	return year+'年'+month+'月'+date+'日、'+hour+'時'+minute+'分'+second+'秒';
}