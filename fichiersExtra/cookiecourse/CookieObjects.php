<?php 
#############################################################
#
# CookieObject Class
#
#       version 0.1
#		License GPL
#
# (c) 2004 Guillermo de Jesus Perez Chavero
#		E-mail: chavero81@yahoo.es
#		Description: allow you to add "n" Single Objects with  "m" Items, and you can set a tipe off objects, all into a cookie
#		Example:
#		My objects:
#			- Cup: Color, size, type
#			- plate: Color, size, Type
#			- spoon: Color, size, Type
#
#		Set cookie
#		$cookie_k = new CookieObjects("cookie_kitchen",'Table');
#		$cookie_k->NewObject();
#		$cookie_k->addItem( "Cup" );
#		$cookie_k->addItem( "Red" );
#		$cookie_k->addItem( 10 );
#		$cookie_k->addItem( "porcelain" );
#		$cookie_k->NewObject();
#		$cookie_k->addItem( "Plate" );
#		$cookie_k->addItem( "White" );
#		$cookie_k->addItem( 11 );
#		$cookie_k->addItem( "porcelain" );
#		$cookie_k->NewObject();
#		$cookie_k->addItem( "Spoon" );
#		$cookie_k->addItem( "silver" );
#		$cookie_k->addItem( 14 );
#		$cookie_k->addItem( "silver" );
#
#		Read cookie
#		$cookie_k = new CookieObjects("cookie_kitchen",'Table');
#		if ($cookie_k->Exist()) {
#			$cookie_k->ReadCookie();
#			$cookie_k->ParseCookie();
#			echo "<br>Type: ".$$cookie_k->GetOType();
#			for ($i = 0; $i<$cookie_k->CountObjects(); $i++) {
#				echo "<br>Object: $i ";
#				for ($j = 0; $j<$cookie_k->CountItemss() ; $j++) {
#					echo '$cookie_k->PData[$i][$j].' ';
#				}
#			}
#		}
#
#		Delete a object : plate
#		$cookie_k->deleteObject(0,"plate");
#
#		Remove a cookie
#		$cookie_k->RemoveCookie();
#
#		-> Have fun !!! :D
#		
##############################################################
class CookieObjects {
		const 	Tokenini = 'XXXXX';
		const 	TokenObject = 'YYYYY';
		const 	TokenData = 'ZZZZZ';
		private $Cookie_Name = '';
		private $Data = '';
		private $CountO = 0;
		private $CountI = 0;
		private $OType;
		public 	$PData = array();

		#Constructor I
		public function __construct( $Cookie_Name , $OType ) {
			$this->Cookie_Name = $Cookie_Name;
			$this->SetOTypeAndClear( $OType );
		}//Constructor I

		#Sobre escribe el OType / overwrite Object type
		public function SetOTypeAndClear ( $OType ) {
			$this->ClearData();
			$this->OType = $OType;
			$this->Data = $OType . CookieObjects::Tokenini;
		}

		#permite conocer si existe la cookie / Allow to know if a cookie exist
		public function Exist() {
			try {
				if (isset($_COOKIE[$this->Cookie_Name])) return true;
			}
			catch ( Exception $e ) {
				echo "Error - function Exist().";
				return false;
			}
			return false;
		}//Exist

		#Permite crear/Sobrescribir la cookie // Create/overwrite a cookie
		public function CreateCookie ( $Overwrite ) {
			try {
				if ($Overwrite) {
					if(setcookie ($this->Cookie_Name,$this->Data)==TRUE) return true;
				}
				else { 
					if ($this->Exist()) return false;
					else if(setcookie ($this->Cookie_Name,$this->Data)==TRUE) return true;
				}
			}
			catch ( Exception $e ) {
				echo "Error - function CreateCookie($Overwrite).";
				return false;
			}			
			return false;
		}//Create
		
		#Remueve una cookie / Remove the cookie
		public function RemoveCookie () {
			try {
				if(setcookie ($this->Cookie_Name, "", time() - 3600)==TRUE) {
					$this->ClearData();
					return true;
				}
			}
			catch ( Exception $e ) {
				echo "Error - RemoveCookie().";
				return false;
			}
			return false;
		}//Create
		
		#Borra todos los datos / Clear all data
		public function ClearData() {
			 $this->OType = ""; 
			 $this->Data = "";
			 $this->PData = null;
			 $this->CountO = 0;
			 $this->CountI = 0;
		}//ClearData
		
		#Lee el contenido de la cookie / Read the cookie
		public function ReadCookie () {
			try {
				if ($this->Exist()) {
					$this->Data = $_COOKIE[$this->Cookie_Name];
					return true;
				}
			}
			catch ( Exception $e ) {
				echo "Error - ReadCookie().";
				return false;
			}
			return false;
		}//ReadCookie
		
		#obtiene los resultados en un arreglo / Get the data into array (DATA)
		public function ParseCookie () {
			try {
				$this->PData = array();
				$Tokenini = explode( CookieObjects::Tokenini , $this->Data );  //Extract the Data OType & Objects
				$this->OType = $Tokenini[0];
				if ($Tokenini[1]!="") {
					$Objects = explode( CookieObjects::TokenObject , $Tokenini[1] );  //Extract the Data SingleObj 1 & Graphic 2
					$this->CountO = sizeof ($Objects);
					foreach ($Objects as $SingleObj) {
						$Items = explode( CookieObjects::TokenData , $SingleObj );  //Extract the Data SingleObj 1 & Graphic 2
						$this->CountI = sizeof ($Items);
						array_push ($this->PData, $Items);
					}
				}
				else $this->CountO = 0;
			}
			catch ( Exception $e ) {
				echo "Error - ParseCookie().";
				return false;
			}
		}//ParseCookie
		
		#Nos indica el tipo de objeto // return the object type
		public function GetOType() {
			return $this->OType;
		}//GETOType
		
		#regresa el numero de graficas contenidas / Count the objects
		public function CountObjects() {
			return $this->CountO;
		}//CountObjects
		
		#regresa el numero de items contenidas, debe de ser constante para todos / Count the items it must be equal for all objects
		public function CountItems() {
			return $this->CountI;
		}//CountItems
		
		#Agrega el token para reconocer que existe un nuevo objecto / allow to add a new object into the cookie
		public function NewObject() {
			if ($this->CountO>0) $this->Data .= CookieObjects::TokenObject;
			$this->CountO++;
			$this->CountI = 0;
		}//NewObject

		#agrega el token y el valor del item // add a item for object "It must be equal (number of items) for all objects"
		public function AddItem( $Item ) {
			if ($this->CountI>0)	$this->Data .= CookieObjects::TokenData . $Item;
			else 	$this->Data .= $Item;
			$this->CountI++;
			return true;
		}//addItem
		
		#borra un objeto donde coincida el valor dependiendo de index de un item / Remove the object with a value of a item (index of item)
		public function DeleteObject ( $Index, $Value ) {
			try {
				$this->ParseCookie();
				$Size_i = $this->CountO;
				$Size_j = $this->CountI;
				$this->CountO = 0;
				$this->CountI = 0;
				$this->Data = $this->OType. CookieObjects::Tokenini;
				for ( $i=0; $i<$Size_i; $i++) {
					if ($this->PData[$i][$Index]==$Value) {}
					else {
						$this->NewObject();
						for ($j=0; $j<$Size_j; $j++) {
							$this->AddItem( $this->PData[$i][$j] );
						}
					}
				}
				$this->ParseCookie();
			}
			catch ( Exception $e ) {
				echo "Erro - deleteItem ( $Index, $Value )";
				return false;
			}
		}//deleteItem
		
		#Permite la imprecion en sobrecarga
		public function __toString() {
			return $this->Data;
		}//__toString
		
		#Retorna la version de la clase
	    final function Version()  {
        	return 'CookieObject Class - Version 0.1';
    	}

}//class MySQLClass
?>
