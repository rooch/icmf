<?php
class siteMapGenerate {
	private $site;
	
	/**
	 * The HTML content of the current page the system is navigating
	 *
	 * @var string
	 */
	private $html;
	
	/**
	 * The url of the actual page the system is navigating
	 *
	 * @var string
	 */
	private $actual;
	
	/**
	 * A hash table containing all the links
	 *
	 * @var array
	 */
	private $hash;
	
	/**
	 * Constructs the SiteMapGenerator Object
	 *
	 * @param string $site
	 *        	the URL of the site that you want to generate the sitemap
	 * @param bool $navigate
	 *        	if you want the SiteMapGenerator to already start navigating through the site, default=true
	 */
	public function __construct($site, $navigate = true) {
		$this->site = $site;
		$this->hash = array ();
		if ($navigate) {
			$this->link ( $site );
		}
	}
	
	/**
	 * Gets the title of the current page, i.e.
	 * the text between <title> and </title>
	 *
	 * @return string title
	 */
	public function getTitle() {
		$preg2 = "/<title>(.*?)<\/title>/i";
		$title = array ();
		preg_match ( $preg2, $this->html, $title );
		return $title [1];
	}
	
	/**
	 * Returns all the <b>internal</b> links of the current page.
	 *
	 * @return array containing the links
	 */
	public function getLinks() {
		$preg = "/<a.*? href=(\"|')(.*?)(\"|').*?>(.*?)<\/a>/i";
		$links = array ();
		preg_match_all ( $preg, $this->html, $links );
		$urlsTemp = $links [2];
		$linksTemp = $links [4];
		$urls = array ();
		$baseUrl = '';
		$linkTexts = array ();
		
		// set base url
		
		// make sure we use real url in case of redirection
		$headers = get_headers ( $this->actual, 1 );
		if (isset ( $headers ['Location'] )) {
			if (strpos ( $headers ['Location'], $this->site ) !== false) {
				$baseUrl = $headers ['Location'];
			} else {
				$baseUrl = $this->site . '/' . $headers ['Location'];
			}
		} else {
			$baseUrl = $this->actual;
		}
		
		if (! (substr ( $baseUrl, - 1 ) == '/')) {
			if (is_dir ( $baseUrl )) { // if base url is a dir without trailing slash
				$baseUrl .= '/';
			} else if ($baseUrl != $this->site) { // base url is a file and not the root
				$baseUrl = str_replace ( basename ( $baseUrl ), '', $baseUrl );
			}
		}
		
		foreach ( $urlsTemp as $i => $url ) {
			if (strstr ( $url, $this->site )) { // If it has link to absolute url path with domain
				$urls [] = $url;
				// $linkTexts[] = $linksTemp[$i];
			} else if (substr ( $url, 0, 1 ) == '/') { // If it has link to absolute url path without domain
				$urls [] = $this->site . $url;
				// $linkTexts[] = $linksTemp[$i];
			} else if (! preg_match ( "/^(mailto|http|\#)/", $url )) { // If it has link to a relative URL.
				
				if (substr ( $url, 0, 2 ) == './') {
					$urls [] = $baseUrl . substr ( $url, 2 );
				} else if (substr ( $url, 0, 3 ) == '../') {
					$pad = substr_count ( $url, '../' );
					$baseUrlTemp = $baseUrl;
					for($i = 1; $i <= $pad + 1; $i ++) {
						$baseUrlTemp = substr ( $baseUrlTemp, 0, strrpos ( $baseUrlTemp, '/' ) );
					}
					$urls [] = $baseUrlTemp . '/' . str_replace ( '../', '', $url );
				} else {
					$urls [] = $baseUrl . $url;
				}
			}
		}
		
		return $urls;
	}
	
	/**
	 * Redirect the object to a new page
	 *
	 * @param string $link
	 *        	the URL that the system will visit
	 */
	public function link($link) {
		// remove hash portion of url to make sure the url isn't reprocessed
		$hashPos = strpos ( $link, '#' );
		if ($hashPos !== false)
			$link = substr ( $link, 0, $hashPos );
		if (! empty ( $link ) && ! isset ( $this->hash [$link] )) {
			$this->actual = $link;
			$this->navigate ();
		}
	}
	
	/**
	 * Navigates through the page collecting the data
	 */
	public function navigate() {
		$this->html = file_get_contents ( $this->actual );
		
		if ($this->html) { // make sure we have something to parse
		                   // remove html comments in order to avoid hidden urls
			$this->html = preg_replace ( '/<!--.*?-->/s', '', $this->html );
			$title = $this->getTitle ();
			$this->hash [$this->actual] = $title;
			
			if ($title == null || $title == "") {
				$this->hash [$this->actual] = "Untitled";
			}
			
			$links = $this->getLinks ();
			foreach ( $links as $link ) {
				echo $link;
				$this->link ( $link );
			}
		}
	}
	
	/**
	 * Returns the Hashtable with the links and titles of each page.
	 * e.g
	 *
	 * <code>
	 * Array (
	 * "http://blog.feliperibeiro.com" => "Felipe Ribeiro Home"
	 * )
	 * </code>
	 *
	 * @return array
	 */
	public function getHash() {
		return $this->hash;
	}
	
	/**
	 * Generates the SiteMap in XML format, according to the default specs
	 * https://www.google.com/webmasters/tools/docs/en/protocol.html
	 *
	 * @return string well formed xml
	 */
	public function generate() {
		$xml = new SimpleXMLElement ( "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"></urlset>" );
		foreach ( $this->hash as $url => $title ) {
			$urlNode = $xml->addChild ( "url" );
			$urlNode->addChild ( "loc", $url );
			$priority = 0.5;
			if ($url == $this->site) {
				$priority = 1.0;
			}
			$urlNode->addChild ( "priority", $priority );
		}
		return $xml->asXML ();
	}
	/**
	 * @param string $sitemap_url
	 */
	
	public function ping($sitemap_url) {
		$curl_req = array ();
		$urls = array ();
		$urls [] = "http://www.google.com/webmasters/tools/ping?sitemap=" . urlencode ( $sitemap_url );
		$urls [] = "http://www.bing.com/webmaster/ping.aspx?siteMap=" . urlencode ( $sitemap_url );
		$urls [] = "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=YahooDemo&url=" . urlencode ( $sitemap_url );
		$urls [] = "http://submissions.ask.com/ping?sitemap=" . urlencode ( $sitemap_url );
		
		foreach ( $urls as $url ) {
			$curl = curl_init ();
			curl_setopt ( $curl, CURLOPT_URL, $url );
			curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $curl, CURL_HTTP_VERSION_1_1, 1 );
			$curl_req [] = $curl;
		}
		// initiating multi handler
		$multiHandle = curl_multi_init ();
		
		// adding all the single handler to a multi handler
		foreach ( $curl_req as $key => $curl ) {
			curl_multi_add_handle ( $multiHandle, $curl );
		}
		
		do {
			$multi_curl = curl_multi_exec ( $multiHandle, $isactive );
		} while ( $isactive || $multi_curl == CURLM_CALL_MULTI_PERFORM );
		
		$success = true;
		foreach ( $curl_req as $curlO ) {
			if (curl_errno ( $curlO ) != CURLE_OK) {
				$success = false;
			}
		}
		curl_multi_close ( $multiHandle );
		return $success;
	}
}

?>