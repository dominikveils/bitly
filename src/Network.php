<?php

namespace DominikVeils\Bitly;

/**
 * Class Network
 * @package DominikVeils\Bitly
 */
class Network
{
    /**
     * @var int|null
     */
    private $last_response_code;
    
    /**
     * Make POST request
     *
     * @param $url
     * @param array $data
     *
     * @return mixed
     */
    public function post($url, array $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
        $result = curl_exec($curl);
        $this->last_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        return $result;
    }
    
    /**
     * Make GET request
     *
     * @param string $url
     *
     * @return mixed
     */
    public function get($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $this->last_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        return $result;
    }
    
    /**
     * @return int
     */
    public function getLastResponseCode()
    {
        return (int)$this->last_response_code;
    }
    
}