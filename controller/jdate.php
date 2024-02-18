<?php
class JdateController{
	private static  function toDigit($number){
		if($number < 10){
			$number = '0' . $number;
		}
		return $number;
	}
	public static function converDate($gregorianDate){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($gregorianDate)){
			$output['error']['status'] = true;
			$output['error']['code'] = '404';
			$output['error']['type'] = 'ENTITY_NOT_FOUND';
			$output['error']['message'] = 'Entity Not Found';
			echo json_encode($output);
			return ;
		}

		$enteredtime = false;

		if (strHas(' ',$gregorianDate)){
			$enteredtime = true;
			$timeEntered = explode(' ',$gregorianDate);
			$gregorianDate = $timeEntered[0];
			$timeInDate 	 = $timeEntered[1];
		}
		$timestamp = strtotime($gregorianDate);
		$secondInOneDay = 24*60*60 ;
		$daysPassed = floor($timestamp / $secondInOneDay ) + 1 ;

		$days 	= $daysPassed;
		$day 		= 12;
		$month 	= 11 ;
		$year 	= 1348 ;
		$days  -= 19;

		$daysInMonth = [31,31,31,31,31,31,30,30,30,30,30,29];
		while (true){
			if($days > $daysInMonth[$month - 1]){
				$days -= $daysInMonth[$month - 1];
				$month++;
				if ($month ==13){
					$year++;
					if(($year - 1347) % 4 ==0){
						$days--;
					}
					$month = 1;
				}
			}else{
				break;
			}
		}


		if ($enteredtime){
			$JlaliDate = $year . '-' . JdateController::toDigit($month) .'-' . JdateController::toDigit($days) . ' ' . $timeInDate;
		}else{
			$JlaliDate = $year . '-' . JdateController::toDigit($month) .'-' . JdateController::toDigit($days);
		}
		return ($JlaliDate);
	}
}