<?php

class TokenProject  implements JsonSerializable
{
	//----- is tokenmarket.net  -----------//

	public $domain;
	public $name;
	public $symbol;
	public $logoLink;

	public $status = 'ICO';

	public $description;

	// Token sale dates
	public $tokenSaleStartDate;
	public $tokenSaleStartInWords;
	public $tokenSaleEndDate;
	public $tokenSaleEndInWords;

	//Social links
	public $blog;
	public $faceBook;
	public $twitter;
	public $twitter_followers;
	public $linkedIn;
	public $slack;
	public $telegram;
	public $gitHub;
	public $reddit; // is crypto compare
	public $reddit_subscribers; 
	public $reddit_active_users;
	public $bitCoinTalk; // is crypto compare

	//----------- coinmarketcap  ----------------//

	public $rank;
	
	public $price_usd;
	public $price_btc;
	public $price_eth;

	public $volume_usd_24h;
	public $volume_btc_24h;
	public $volume_eth_24h;
	
	public $market_cap_usd;
	public $market_cap_btc;
	public $market_cap_eth;
	
	public $percent_change_24h;

	// ----------- Crypto Compare --------- //

	public $fundsRaised;
	public $tokenStartPrice;

	public $histoMinute;
	public $histoHour;
	public $histoDay;

	public $icorating;
	public $icocritic;
	public $cryptorated;
	public $tokentops;
	public $icobench;
	public $icobazaar;
	public $digrate;

	//Similar Web

	public $TotalVisits;  
	public $TimeOnSite;	
	public $PagesViews;
	public $BounceRate;
	public $graph;


	public function __construct() {}

	public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}




include_once('simple_html_dom.php');

if (isset($_GET['link'])){
	
	$tp = new TokenProject();
	
	$link = $_GET['link'];

	$arr = explode("://", $link);

	$domain = $arr[1];
		
	$arr = explode("/", $domain);
	$domain = $arr[0];
	$arr = explode("?", $domain);
	$domain = $arr[0];
	$arr = explode("#", $domain);
	$domain = $arr[0];

//	echo $domain . '<br>';

	$tp->domain = $domain;

			// from domain get link to TokenMartket
	/*	$html = file_get_html('https://www.bing.com/search?q=site%3Atokenmarket.net+'.$domain);
		$element = $html->find('.b_algo'); 
		$x = $element[0]; 
		$x = $x->find('a');
		$tokenMarketLink = $x[0]->href;
	*/

	$tokenMarketLink = //'https://tokenmarket.net/blockchain/ethereum/assets/1world-online/';
	//'https://tokenmarket.net/blockchain/blockchain/assets/ammbr/';
	'https://tokenmarket.net/blockchain/ethereum/assets/cofound.it/';
	$html = file_get_html($tokenMarketLink);
						 
	$name = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[2]/div[1]/h1'); 
	$a = $name[0]->find('text');
	$name = $a[3];
	$tp->name = trim($name->plaintext);

	
	$description = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[2]/div[1]/p[1]'); 
	$a = $description[0]->find('text');
	$smb = $a[0];
	$tp->description = trim($smb->plaintext);

	$symbol = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[1]/table[1]/tbody/tr[1]/td'); 
	$s = $symbol[0]->find('text');
	$symbol = $s[0];
	$tp->symbol = trim($symbol->plaintext);
	
	$logoLink = $html->find('//*[@id="asset-logo-primary"]'); 
	if (isset($logoLink[0]->attr['src'])) {
		$s = $logoLink[0]->attr['src'];
	}
	else{
		$s = $logoLink[0]->attr['data-cfsrc'];
	}

	$logoLink = $s;
	$tp->logoLink = trim($logoLink);


	
	$tokenSaleStartDate = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[1]/table[1]/tbody/tr[2]/td'); 
	$s = $tokenSaleStartDate[0]->find('text');
	$tokenSaleStartDate = $s[1];
	$tp->tokenSaleStartDate = trim($tokenSaleStartDate->plaintext);

	$tokenSaleStartInWords = $s[4];
	$tp->tokenSaleStartInWords = trim($tokenSaleStartInWords->plaintext);



	$tokenSaleEndDate = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[1]/table[1]/tbody/tr[3]/td'); 
	$s = $tokenSaleEndDate[0]->find('text');
	$tokenSaleEndDate = $s[1];
	$tp->tokenSaleEndDate = trim($tokenSaleEndDate->plaintext);

	$tokenSaleEndInWords = $s[4];
	$tp->tokenSaleEndInWords = trim($tokenSaleEndInWords->plaintext);

	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[2]/td/a'); 
	
	if (count($tmp)>0)
	 { $tp->blog = $tmp[0]->href; }
	
	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[4]/td/a'); 
	if (count($tmp)>0)
	{ $tp->faceBook = $tmp[0]->href;	}
	
	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[5]/td/a'); 
	if (count($tmp)>0)
	{ $tp->twitter = $tmp[0]->href;	}

	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[6]/td/a'); 
	if (count($tmp)>0)
	{ $tp->linkedIn = $tmp[0]->href;	}
	
	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[7]/td/a'); 
	if (count($tmp)>0)
	{ $tp->slack = $tmp[0]->href;	}

	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[8]/td/a'); 
	if (count($tmp)>0)
	{ $tp->telegram = $tmp[0]->href; }	
		
	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[2]/table[1]/tbody/tr[9]/td/a'); 
	if (count($tmp)>0)
	{ $tp->gitHub = $tmp[0]->href;	}
	

//	public $reddit; // is crypto compare
//	public $bitCoinTalk; // is crypto compare

	$tmp = $html->find('//*[@id="page-wrapper"]/main/div[2]/div[3]/div[1]/table[1]/tbody/tr[4]/td/span'); 
	if (count($tmp)>0){ 
		$tp->status = 'trading';	
	}

	if ($tp->status == 'trading'){

		// from domain get link to TokenMartket
		/*	$html = file_get_html('https://www.bing.com/search?q=site%3Atokenmarket.net+'.$domain);
			$element = $html->find('.b_algo'); 
			$x = $element[0]; 
			$x = $x->find('a');
			$tokenMarketLink = $x[0]->href;
		*/
		$coinMarketCapLink = 'https://api.coinmarketcap.com/v1/ticker/edgeless/';
		
		$json = file_get_contents($coinMarketCapLink);
		$obj = json_decode($json);

		
        $tp->rank = $obj[0]->rank; 
        $tp->price_usd = $obj[0]->price_usd;
        $tp->price_btc = $obj[0]->price_btc;
        $tp->volume_usd_24h = $obj[0]->{'24h_volume_usd'};
        $tp->market_cap_usd = $obj[0]->market_cap_usd;
		$tp->percent_change_24h = $obj[0]->percent_change_24h;
        
        $coinMarketCapLinkBtc = $coinMarketCapLink. '/?convert=btc';
		$json = file_get_contents($coinMarketCapLinkBtc);
		$obj = json_decode($json);
 
        $tp->volume_btc_24h = $obj[0]->{'24h_volume_btc'};
		$tp->market_cap_btc = $obj[0]->market_cap_btc;

        $coinMarketCapLinkEth = $coinMarketCapLink. '/?convert=eth';
		$json = file_get_contents($coinMarketCapLinkEth);
		$obj = json_decode($json);

        $tp->price_eth = $obj[0]->price_eth;
        $tp->volume_eth_24h = $obj[0]->{'24h_volume_eth'};
		$tp->market_cap_eth = $obj[0]->market_cap_eth;

	}

	// ------ Crypto Compare -------- //

			/*	$html = file_get_html('https://www.bing.com/search?q=site%3Atokenmarket.net+'.$domain); ???
			$element = $html->find('.b_algo'); 
			$x = $element[0]; 
			$x = $x->find('a');
			$tokenMarketLink = $x[0]->href;
		*/
	/*	$cryptoCompareLink =  'https://www.cryptocompare.com/coins/edg/overview/USD';
		$html = file_get_html($tokenMarketLink);

		$tokenStartPrice = $html->find('//*[@id="tbl_icos"]/tbody/tr[3]/td[3]'); 
		$s = $tokenStartPrice[0]->find('text');
		$tokenStartPrice = $s[1];
*/



	if ($tp->status == 'trading'){

			$tp->tokenStartPrice = '$0.55'; // trim($tokenStartPrice->plaintext);
		
				
			$coinScheduleLink =  'https://www.coinschedule.com/icos.php';
			$html = file_get_html($coinScheduleLink);
	
			// $fundsRaised = $html->find('//*[@id="tbl_icos"]/tbody/tr/td[3][contains(., "edgeless.io")]/../td[5]/text()'); 
			// [contains(text(), 'edgeless.io')]
			// $fundsRaised = $html->find("//*[@id='tbl_icos']/tbody/tr/td[3][text()='https://bitjob.io/']"); 
			$tp->fundsRaised =  '$10m'; //trim($fundsRaised[10]->plaintext);
		
			$cryptoCompareLink = 'https://www.cryptocompare.com/api/data/coinlist/';
			$json = file_get_contents($cryptoCompareLink);
			$obj = json_decode($json);
			$id = $obj->Data->{$tp->symbol}->Id;


			$tp->histoMinute = 'https://min-api.cryptocompare.com/data/histominute?fsym='.$tp->symbol.'&tsym=USD&limit=60&aggregate=3&e=CCCAGG'; 
			$tp->histoHour = 'https://min-api.cryptocompare.com/data/histohour?fsym='.$tp->symbol.'&tsym=USD&limit=60&aggregate=3&e=CCCAGG';
			$tp->histoDay = 'https://min-api.cryptocompare.com/data/histoday?fsym='.$tp->symbol.'&tsym=USD&limit=60&aggregate=3&e=CCCAGG';

	}
	if ($tp->status == 'ICO'){
		$tp->icorating = "4"; 
		$tp->icocritic = "4.4";
		$tp->cryptorated = "4.5";
		$tp->tokentops = "4.3";
		$tp->icobench = "4.2";
		$tp->icobazaar = "4.1";
		$tp->digrate = "4.0";
	}


	if (isset($id)){
		$cryptoCompareSocialLink = 'https://www.cryptocompare.com/api/data/socialstats/?id='.$id;  
		$json = file_get_contents($cryptoCompareSocialLink);
		$obj = json_decode($json);

		if (property_exists($obj->Data, 'Reddit')){
			$tp->reddit = $obj->Data->Reddit->link;
			$tp->reddit_subscribers = $obj->Data->Reddit->subscribers;
			$tp->reddit_active_users = $obj->Data->Reddit->active_users;
		}
		
		if (property_exists($obj->Data, 'Twitter')){
			$tp->twitter = $obj->Data->Twitter->link;
			$tp->twitter_followers = $obj->Data->Twitter->followers;
		}
	}

	$tp->TotalVisits = "1564";  
	$tp->TimeOnSite = "15s";	
	$tp->PagesViews = "2";
	$tp->BounceRate = "50%";
	$tp->graph = "https://widget.similarweb.com/traffic/". $tp->domain;


	//	echo $name;
	header('Content-type: application/json');
	$x = json_encode($tp);

	echo $x;
//	echo $tp->name;
}
else echo "Link is not set";





?>
