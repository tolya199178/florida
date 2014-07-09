<?php


/**
 * Paypal transaction processing utility class
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * IpnVerify is a Paypal transaction processing utility classl. Used for trx debugging.
 *
 * @package Components
 * @version 1.0
 */

class IpnVerify
{

	private $sandbox_api_ipn_url   = 'www.sandbox.paypal.com';
	private $api_ipn_url           = 'www.paypal.com';

	public $error                  = '';
	public $uri                    = '';


	public function validateIpn($data, $sandbox)
	{
		return $this->ppValidIpnCheck($data, $sandbox);
	}

	private function ppValidIpnCheck($data, $sandbox = true)
	{

		$host = $sandbox ? $this->sandbox_api_ipn_url : $this->api_ipn_url;

		$this->uri = 'ssl://' . $host;

		$req = 'cmd=_notify-validate';

		if(function_exists('get_magic_quotes_gpc'))
		{
			$get_magic_quotes_exists = true;
		}

		foreach ($data as $key => $value)
		{

			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
			{
				$value = urlencode(stripslashes($value));
			}
			else
			{
				$value = urlencode($value);
			}

			$req .= "&$key=$value";
		}

		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Host: " . $host . "\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ($this->uri, 443, $errno, $errstr, 30);

		$result = false;

		if (!$fp)
		{
			// HTTP ERROR
			$this->error = 'http error';
		}
		else
		{
			fputs ($fp, $header . $req);

			while (!feof($fp))
			{
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0)
				{
					$result = true;
				}
				else if (strcmp ($res, "INVALID") == 0)
				{
					$result = false;
					$this->error = $res;
				}
			}

		}
		fclose ($fp);

		return $result;
	}

}
