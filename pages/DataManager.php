<?php
	include 'connManagr.php';
	class DataManager{
		private $totRelArray=[];
		var $parentList=[];
		 public static $cnt = 0;
		 function getNameFromId($id){
		 	for($j=0;$j<count($this->totRelArray);$j++){
		 		if($id==$this->totRelArray[$j]->id)
		 			return $this->totRelArray[$j]->name;
		 	}
		 	echo "undefined";
		 }

		 function getParentFromId($id){
		 	for($j=0;$j<count($this->totRelArray);$j++){
		 		if($id==$this->totRelArray[$j]->id)
		 			return $this->totRelArray[$j]->parent;
		 	}
		 	echo "Person with the following id does not exist!";
		 	return array();
		 }

		function getParent($id){
			self::$cnt++;
			$arr=$this->getParentFromId($id);
			if(count($arr)>0){
				//iterate thru array and get names of the arrays
				for($i=0;$i<count($arr);$i++){
					if(self::$cnt>1){
						$pName=$this->getNameFromId($arr[$i]);
						if($pName != "undefined"){
							if(!in_array($pName,$this->parentList))
								array_unshift($this->parentList,$pName);
						}
				

					}
				}
			}
			else
				return;

			for($i=0;$i<count($arr);$i++){
				$this->getParent($arr[$i]);
			}

			
		}
		function printGrands(){
			$arr=$this->parentList;
			for($i=0;$i<count($arr);$i++)
				echo "".$arr[$i]."<br>";
		}

		function parseRelationData(){
			$pArr=[];
			$relArr=[];$totalArr=[];
			$dbObj = new Db();
			$dbObj->openMySQLiConn("localhost","root","","familytree");
			$pArr=$dbObj->getAllFromDb("person");
			//print_r($pArr[0]);
			$relArr=$dbObj->getRelation("parent");
			//print_r($relArr[0]);
			for($x=0;$x<count($pArr);$x++){
				 $obj = new stdClass;
		    	$obj->id=$pArr[$x]->id;
				$obj->name = $pArr[$x]->name;
				$obj->dob=$pArr[$x]->dob;
				$temp=[];
				for($y=0;$y<count($relArr);$y++){
					if($pArr[$x]->id==$relArr[$y]->c_id){
						array_push($temp,$relArr[$y]->p_id);
					}
					
				}
				$obj->parent=$temp;
				array_push($totalArr,$obj);
			}
			//print_r($totalArr);
			$this->totRelArray=$totalArr;
			return $totalArr;
			
		}
		function getChildWithOneParent(){
			$oneParentArr=[];
			for($j=0;$j<count($this->totRelArray);$j++){
				if(count($this->totRelArray[$j]->parent)==1)
					//array_push($oneParentArr,$this->totRelArray[$j]);
					echo "".$this->totRelArray[$j]->name." has only 1 parent. <br>";
			}
			return $oneParentArr;
		}
		function getChildWithParentLink($id){
			for($j=0;$j<count($this->totRelArray);$j++){
				if($id == $this->totRelArray[$j]->id)
					return $this->totRelArray[$j];
			}
			return "Person with following id doesnot exist";
		}
	}

?>