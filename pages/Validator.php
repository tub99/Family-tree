
<?php
	class Validator{
		function validateDate($date){
    			$d = DateTime::createFromFormat('Y-m-d', $date);
    			return $d && $d->format('Y-m-d') === $date;
		}
		function validateName($name) {
			if(strlen($name)<=100)
				return true;
			else
				return false;
		}
		function validateId($id){
			$p_id=(int)$id;
			if(is_nan($p_id)==false)
				return true;
			else 
				return false;
		}
		
	}

?>