<?php
	function convertTime($timeStamp){
		$time = strtotime($timeStamp);
		$diffInSecond = time() - $time;
		$seconds = $diffInSecond;
		$minutes = floor($diffInSecond/(60));
		$hours = floor($diffInSecond/(60*60));
		$days = floor($diffInSecond/(60*60*24));

		if($days > 0 )
		{
			if($days <= 30)
				return $days.'日ぐらい前';
			$year = date('Y',$time);
			$month = date('m',$time);
			$date = date('d',$time);
			$hour = date('H',$time);
			$minute = date('i',$time);
			$second = date('s',$time);
			$displayTime = $year.'年'.$month.'月'.$date.'日、'.$hour.'時'.$minute.'分'.$second.'秒';
			return $displayTime;
		}
		if($hours>0) 
			return $hours.'時ぐらい前';
		if($minutes>0)
			return $minutes.'分ぐらい前';
		if($seconds>=0) 
			return $seconds.'秒ぐらい前';
	} 
?>