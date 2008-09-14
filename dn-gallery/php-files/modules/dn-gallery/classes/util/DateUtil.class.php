<?
/*
 * DateUtil.class.php
 *
 * Created on January 3, 2006, 4:35 AM
 *
 */

/**
 *
 * @author Adam
 */
class DateUtil {
	var $conn = "";
	var $num_days = array("31","28","31","30","31","30","31","31","30","31","30","31");

	function DateUtil(){
		global $db;
		$this->conn =& $db;
		$m = intval(date("m"));
		$m = 2;
		$daysKabisat = 28;
		if ($m == 2) {
			$y = date("Y");
			if ($y % 100 == 0) {
				if ($y % 400 == 0) {
					$num_days[1] = 29;
				}
			}
			else {
				if ($y % 4 == 0) {
					$num_days[1] = 29;
				}
			}
		}
	}

	function getDate($date) {
		$expl = explode(" ",$date);
		$expl2 = explode(":",$expl[0]);

		$date["Y"] = $expl2[0];
		$date["m"] = $expl2[1];
		$date["d"] = $expl2[2];

		return $date;
	}

	function getTime($date) {
		$expl = explode(" ",$date);
		$expl2 = explode(":",$expl[1]);

		$time["h"] = $expl2[0];
		$time["i"] = $expl2[1];
		$time["s"] = $expl2[2];

		return $time;
	}

	function toDate($date) {
		$sql = "SELECT DATEDIFF('".date("Y-m-d")."','".$date."') AS REMAINING";
		$list = $this->conn->Execute($sql);
		$sisa = intval($list->fields("REMAINING"));
		if ($sisa > 365) {
			$thn = intval($sisa / 365);
			$sisa = $sisa % 365;
		}
		
		$expl = explode("-",$date);
		$m1 = intval(date("m"));
		$y1 = intval(date("y"));

		$m2 = intval($expl[1]);
		$y2 = intval($expl[0]);

		$bln = 0;
		if ($sisa > $this->num_days[$m1-1]) {
			$i=0;
			while ($sisa > $this->num_days[$m1-1] && $i <= 13) {
				if ($m1 == 12) {
					$m1 = 1;
				}
				$sisa = $sisa - $this->num_days[$m1-1];
				$i++;
				$bln++;
				$m1++;
			}
		}	
		$str = "";
		if ($thn != "0" && $thn != "") {
			$str .= " ".$thn." Tahun";
		}
		if ($bln != "0" && $bln != "") {
			$str .= " ".$bln." Bulan";
		}
		if ($sisa != "0" && $sisa != "") {
			$str .= " ".$sisa." Hari";
		}

		return $str;
	}

	function diff($date) {
		$sql = "SELECT DATEDIFF('".date("Y-m-d")."','".$date."') AS REMAINING";
		$list = $this->conn->Execute($sql);
		$sisa = intval($list->fields("REMAINING"));
		if ($sisa > 365) {
			$thn = intval($sisa / 365);
			$sisa = $sisa % 365;
		}
		
		$expl = explode("-",$date);
		$m1 = intval(date("m"));
		$y1 = intval(date("y"));

		$m2 = intval($expl[1]);
		$y2 = intval($expl[0]);

		$bln = 0;
		if ($sisa > $this->num_days[$m1-1]) {
			$i=0;
			while ($sisa > $this->num_days[$m1-1] && $i <= 13) {
				if ($m1 == 12) {
					$m1 = 1;
				}
				$sisa = $sisa - $this->num_days[$m1-1];
				$i++;
				$bln++;
				$m1++;
			}
		}	
		$str = "";
		unset($arr_out);
		if ($thn != "0" && $thn != "") {
			$arr_out["y"] = $thn;
		}
		if ($bln != "0" && $bln != "") {
			$arr_out["m"] = $bln;
		}
		if ($sisa != "0" && $sisa != "") {
			$arr_out["d"] = $sisa;
		}

		return $arr_out;
	}
}

?>