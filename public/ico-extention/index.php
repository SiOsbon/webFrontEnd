<?php


if (isset($_GET['link'])){
	
	
	$link = $_GET['link'];

	$arr = explode("://", $link);

	$domain = $arr[1];
		
	$arr = explode("/", $domain);
	$domain = $arr[0];
	$arr = explode("?", $domain);
	$domain = $arr[0];
	$arr = explode("#", $domain);
	$domain = $arr[0];


  $json = '';

  //ammbr.com
  

  switch ($domain) {
    case 'cofound.it':
        $json = '{"domain":"cofound.it","name":"Cofound.it","symbol":"CFI","logoLink":"https:\/\/tokenmarket.net\/blockchain\/ethereum\/assets\/cofound.it\/logo_big.png","status":"trading","description":"A distributed VC ecosystem for the distributed future","tokenSaleStartDate":"7. Jun 2017","tokenSaleStartInWords":"5 months ago","tokenSaleEndDate":"31. May 2017","tokenSaleEndInWords":"6 months ago","blog":"https:\/\/medium.com\/cofoundit","faceBook":null,"twitter":"https:\/\/twitter.com\/cofound_it","twitter_followers":7310,"linkedIn":"https:\/\/www.linkedin.com\/company-beta\/18004039\/","slack":"http:\/\/cofoundit.herokuapp.com\/","telegram":null,"gitHub":"https:\/\/tokenmarket.net\/what-is\/slack\/","reddit":"https:\/\/www.reddit.com\/r\/cofoundit\/","reddit_subscribers":887,"reddit_active_users":74,"bitCoinTalk":null,"rank":"93","price_usd":"0.646817","price_btc":"0.00009650","price_eth":"0.0021365525","volume_usd_24h":"1278920.0","volume_btc_24h":"190.809332858","volume_eth_24h":"4224.5019512","market_cap_usd":"53068934.0","market_cap_btc":"7918.0","market_cap_eth":"175296.0","percent_change_24h":"3.64","fundsRaised":"$10m","tokenStartPrice":"$0.55","histoMinute":"https:\/\/min-api.cryptocompare.com\/data\/histominute?fsym=CFI&tsym=USD&limit=60&aggregate=3&e=CCCAGG","histoHour":"https:\/\/min-api.cryptocompare.com\/data\/histohour?fsym=CFI&tsym=USD&limit=60&aggregate=3&e=CCCAGG","histoDay":"https:\/\/min-api.cryptocompare.com\/data\/histoday?fsym=CFI&tsym=USD&limit=60&aggregate=3&e=CCCAGG","icorating":null,"icocritic":null,"cryptorated":null,"tokentops":null,"icobench":null,"icobazaar":null,"digrate":null,"TotalVisits":"1564","TimeOnSite":"15s","PagesViews":"2","BounceRate":"50%","graph":"https:\/\/widget.similarweb.com\/traffic\/cofound.it"}';
        break;
    case 'ammbr.com':
        $json = '{"domain":"www.ammbr.com","name":"Ammbr","symbol":"AMMBR","logoLink":"https:\/\/tokenmarket.net\/blockchain\/blockchain\/assets\/ammbr\/logo_big.png","status":"ICO","description":"Global Bandwidth Tokenization","tokenSaleStartDate":"14. Nov 2017","tokenSaleStartInWords":"in 2 days","tokenSaleEndDate":"14. Dec 2017","tokenSaleEndInWords":"in a month","blog":"http:\/\/blog.ammbr.com\/","faceBook":"https:\/\/www.facebook.com\/AmmbrPlatform\/","twitter":"https:\/\/twitter.com\/ammbrplatform","twitter_followers":null,"linkedIn":"https:\/\/www.linkedin.com\/company\/22332635\/","slack":"https:\/\/tokenmarket.net\/what-is\/slack\/","telegram":"https:\/\/t.me\/ammbrICO","gitHub":"https:\/\/github.com\/ammbrteam","reddit":null,"reddit_subscribers":null,"reddit_active_users":null,"bitCoinTalk":null,"rank":null,"price_usd":null,"price_btc":null,"price_eth":null,"volume_usd_24h":null,"volume_btc_24h":null,"volume_eth_24h":null,"market_cap_usd":null,"market_cap_btc":null,"market_cap_eth":null,"percent_change_24h":null,"fundsRaised":null,"tokenStartPrice":null,"histoMinute":null,"histoHour":null,"histoDay":null,"icorating":"4","icocritic":"4.4","cryptorated":"4.5","tokentops":"4.3","icobench":"4.2","icobazaar":"4.1","digrate":"4.0","TotalVisits":"1564","TimeOnSite":"15s","PagesViews":"2","BounceRate":"50%","graph":"https:\/\/widget.similarweb.com\/traffic\/www.ammbr.com"}';
        break;
    default :
        $json = '{"error": "'. $domain .' Not Found" }';
        break;
  }

}

else $json = '{"error":"Variable \'link\' is not set" }';

header('Content-type: application/json');
//$x = json_encode($tp);

echo $json;

?>
