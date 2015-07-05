<?php

class sitemap extends system{

	public $dom;
	public $xpath;
	public $aTags = array();
	private $site;

	function __construct(){
		
		ini_set('xdebug.max_nesting_level', 100000);
		ini_set('max_execution_time', 3000);
		$this->site = $_SERVER['SERVER_NAME'];

		libxml_use_internal_errors(true);
		$this->dom = new DOMDocument('1.0', 'UTF-8');
	}

	public function createFile($file='sitemap.xml') {

		$xmlstr = "<? xml version='1.0' encoding='UTF-8' ?>\n" . "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"></urlset>";
		$xml = new SimpleXMLElement($xmlstr);

		$xml->addAttribute('encoding', 'UTF-8');
		//		print_r($this->aTags);
		foreach($this->aTags as $url) {
			$urlNode = $xml->addChild('url');
			$urlNode->addChild('loc',$url);
			$priority = 0.5;
			if($url == $this->site) {
				$priority = 1.0;
			}
			$urlNode->addChild('priority',$priority);
		}

		$f = fopen($file, 'w');
		if(fwrite($f, $xml->asXML()))
		$this->ping($this->site . $file);
		fclose($f);
	}

	public function generate($url, $file='sitemap.xml'){

		$this->dom->loadHTMLFile($url);

		$this->xpath = new DOMXPath($this->dom);

		$tags = $this->xpath->query('//a'); //get all a tags
		for($i = 0; $i < $tags->length; $i++){
			$tag = $tags->item($i); //select an a tag
			$newURL = $tag->getAttribute('href');
				
			$newURL = ($newURL[0] == '/') ? ltrim($newURL, '/') : $newURL;

			if(!empty($newURL)){
				$urlSections = parse_url($newURL);
				if(empty($urlSections['scheme'])){
					if(empty($urlSections['host'])){
						$this->aTags[] = 'http://' . $this->site . '/' . $newURL;
						$this->generate($newURL);
					}else{
						$this->aTags[] = 'http://' . $newURL;
					}
				}else{
					if(empty($urlSections['host'])){
						$this->aTags[] = $this->site . '/' . $newURL;
						$this->generate($newURL);
					}else{
						$this->aTags[] = $newURL;
					}
				}

			}
		}
		$this->createFile($file);
	}

	public function ping($sitemapUrl){
		$curl_req = array();
		$urls = array();
		$urls[] = 'http://www.google.com/webmasters/tools/ping?sitemap=' . urlencode($sitemapUrl);
		$urls[] = 'http://www.bing.com/webmaster/ping.aspx?siteMap=' . urlencode($sitemapUrl);
		$urls[] = 'http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=YahooDemo&url=' . urlencode($sitemapUrl);
		$urls[] = 'http://submissions.ask.com/ping?sitemap=' . urlencode($sitemapUrl);

		foreach ($urls as $url){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURL_HTTP_VERSION_1_1, 1);
			$curl_req[] = $curl;
		}
		//initiating multi handler
		$multiHandle = curl_multi_init();

		// adding all the single handler to a multi handler
		foreach($curl_req as $key => $curl){
			curl_multi_add_handle($multiHandle,$curl);
		}

		do{
			$multi_curl = curl_multi_exec($multiHandle, $isactive);
		}
		while ($isactive || $multi_curl == CURLM_CALL_MULTI_PERFORM );

		$success = true;
		foreach($curl_req as $curlO){
			if(curl_errno($curlO) != CURLE_OK){
				$success = false;
			}
		}
		curl_multi_close($multiHandle);
		return $success;
	}

}

?>