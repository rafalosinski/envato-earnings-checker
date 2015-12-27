<?php

class Envato {
	private $bearer = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
	private $apiAccountUrl = "https://api.envato.com/v1/market/private/user/account.json";
	private $apiItemUrl = "https://api.envato.com/v3/market/catalog/item?id=xxxxxxxxx";
	private $apiUserUrl = "https://api.envato.com/v1/market/user:osinskirafal.json";
	private $header = [ ];
	private $filename = "xxxxxxxxx.txt";

	public function curlResponse( $url ) {
		$bearer            = 'Bearer ' . $this->bearer;
		$this->header[ 0 ] = 'Content-type: application/json; charset=utf-8';
		$this->header[ 1 ] = 'Authorization: ' . $bearer;

		$curl_init = curl_init( $url );

		curl_setopt( $curl_init, CURLOPT_HTTPHEADER, $this->header );
		curl_setopt( $curl_init, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl_init, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl_init, CURLOPT_CONNECTTIMEOUT, 5 );

		$curl_value = curl_exec( $curl_init );
		curl_close( $curl_init );

		return json_decode( $curl_value );
	}

	public function getBalance() {

		$getCurlResponse = $this->curlResponse( $this->apiAccountUrl );

		if ( '' !== $getCurlResponse ) {
			$this->saveBalance( $current );

			return $getCurlResponse->account->balance;
		} else {
			return false;
		}

	}

	public function getUserSales() {
		$getCurlResponse = $this->curlResponse( $this->apiUserUrl );

		return $getCurlResponse->user->sales;
	}

	public function getItemsSales() {
		$getCurlResponse = $this->curlResponse( $this->apiItemUrl );

		return $getCurlResponse->number_of_sales;

	}

	public function saveBalance( $current ) {
		$file = fopen( $this->filename, 'a' );

		if ( $file ) {
			$last = file_get_contents( $this->filename );

			if ( $current > $last ) {
//				mail('YOUR EMAIL', 'Envato Balance', $current) or die("error. not sent.");
				file_put_contents( $this->filename, $current );
			}

		}
	}

}


$envato = new Envato();

echo $envato->getBalance();
echo $envato->getItemsSales();
echo $envato->getUserSales();
?>