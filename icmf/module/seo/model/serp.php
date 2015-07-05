<?php
class serp {
	
	var $resultSearchMax;
	var $resultPerPage;
	var $defultPosition;
	
	function __construct(){
		
		// How many results to search through.
		$this->resultSearchMax = 100;
			
		// The number of hits per page.
		$this->resultPerPage = 10;
			
		// This will be our rank
		$this->defultPosition = 0;
	}
	
	public function position($keyword, $url) {
		
		if (! empty ( $keyword ) && ! empty ( $url )) {
			$query = str_replace ( " ", "+", $keyword );
			$query = str_replace ( "%26", "&", $query );
			
			for($i = 0; $i < $this->resultSearchMax; $i += $this->resultPerPage) {
				
				$filename = "http://www.google.com/search?as_q=$query" . "&num=$this->resultPerPage&hl=en&ie=UTF-8&btnG=Google+Search" . "&as_epq=&as_oq=&as_eq=&lr=lang_fa&as_ft=i&as_filetype=" . "&as_qdr=all&as_nlo=&as_nhi=&as_occt=any&as_dt=i" . "&as_sitesearch=&safe=images&start=$i";
				
				$var = file_get_contents ( $filename );
				// split the page code by "<h3 class" which tops each result
				$fileparts = explode ( "<h3 class=", $var );
				for($f = 1; $f < sizeof ( $fileparts ); $f ++) {
					$this->defaultPosition ++;
					if (strpos ( $fileparts [$f], $url )) {
						return $this->defaultPosition;
					}
				}
			}
		}
	}
}

?>