<?php

namespace DominikVeils\Bitly;

use RuntimeException;

/**
 * Class Bitly
 * @package DominikVeils\Bitly
 */
class Bitly
{
    const BASE_SHORT_URL = 'https://api-ssl.bitly.com/v3/shorten?access_token=%s&longUrl=%s';
    const BASE_EXPAND_URL = 'https://api-ssl.bitly.com/v3/expand?access_token=%s&shortUrl=%s';
    
    /**
     * @var string
     */
    private $api_key;
    
    /**
     * @var Network
     */
    private $network;
    
    /**
     * @param string $api_key
     * @param Network $network
     */
    function __construct($api_key, Network $network = null)
    {
        $this->api_key = $api_key;
        $this->network = is_null($network) ? new Network : $network;
    }
    
    /**
     * @param string $long_url
     *
     * @return mixed
     * @throws RuntimeException
     */
    public function shorten($long_url)
    {
        $url = sprintf(static::BASE_SHORT_URL, $this->api_key, urlencode($long_url));
        $response = $this->network->get($url);
        
        if ($response) {
            if ($this->network->getLastResponseCode() !== 200) {
                throw new RuntimeException($response, $this->network->getLastResponseCode());
            }
            
            $decoded_response = json_decode($response, true);
            
            return $decoded_response['data']['url'];
        }
    
        throw new RuntimeException("Could not create short url!");
    }
    
    /**
     * @param string $short_url
     *
     * @return string
     * @throws RuntimeException
     */
    public function expand($short_url)
    {
        $url = sprintf(static::BASE_EXPAND_URL, $this->api_key, urlencode($short_url));
        
        $response = $this->network->get($url);
    
        if ($response) {
            $decoded_response = json_decode($response, true);
            if ($this->network->getLastResponseCode() !== 200 || intval($decoded_response['status_code']) !== 200) {
                throw new RuntimeException($response, $this->network->getLastResponseCode());
            }
            
            return $decoded_response['data']['expand'][0]['long_url'];
        }
    
        throw new RuntimeException("Could not expand url!");
    }
}