<?php

namespace Analytical42\GoogleAnalyticsCookie;

class Cookie
{
    protected $clientId;
    protected $cookieName;
    protected $cookieDomain;
    protected $secure;
    
    public function __construct( $cookieName = '_ga', $cookieDomain = '', $secure = true )
    {
        $this->cookieName = $cookieName;
        $this->cookieDomain = ( !empty( $cookieDomain ) ) ? $cookieDomain : $_SERVER['HTTP_HOST'];
        $this->secure = $secure;
        $this->clientId = $this->readClientId();

        $this->setGaCookie();
    }

    private function setGaCookie()
    {
        $options = [
            'expires'  => time() + 24*60*60*365*1,
            'path'     => '/',
            'domain'   => $this->cookieDomain,
            'secure'   => $this->secure,
            'httponly' => false
        ];

        $cookie = setcookie( $this->cookieName, $this->clientId, $options );

        return $cookie;
    }

    private function readClientId()
    {
        // Get Client ID from cookie if it exists
        if( isset( $_COOKIE[$this->cookieName] ) && !empty( $_COOKIE[$this->cookieName] ) ) {
            $clientId = $_COOKIE[$this->cookieName];
        }
        
        // ...or generate a new Client ID
        if( !isset( $clientId ) ) {
            $clientId = $this->generateClientId();
        }

        return $clientId;
    }

    private function generateClientId()
    {
        // Function by Sean Behan; http://www.seanbehan.com/how-to-generate-a-uuid-in-php/
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 

        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return 'GA1.2.' . $uuid;
    }

    public function getClientId()
    {
        return $this->clientId;
    }
}