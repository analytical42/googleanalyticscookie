<?php

namespace Analytical42\GoogleAnalyticsCookie;

/**
 * Makes Google Analytics use a server side HTTP cookie instead of the default javascript cookie set with document.cookie.
 */
class Cookie
{
    protected $clientId;
    protected $cookieName;
    protected $cookieDomain;
    protected $secure;
    
    /**
     * Create the server side Google Analytics cookie
     *
     * @param string $cookieName
     * @param string $cookieDomain
     * @param boolean $secure
     */
    public function __construct( $cookieName = '_ga', $cookieDomain = '', $secure = true )
    {
        $this->cookieName = $cookieName;
        $this->cookieDomain = ( !empty( $cookieDomain ) ) ? $cookieDomain : $_SERVER['HTTP_HOST'];
        $this->secure = $secure;
        $this->clientId = $this->readClientId();

        $this->setGaCookie();
    }

    /**
     * Set Google Analytics cookie and Client ID storage cookie
     *
     * @return void
     */
    private function setGaCookie()
    {
        $options = [
            'expires'  => time() + 24*60*60*365*2,
            'path'     => '/',
            'domain'   => $this->cookieDomain,
            'secure'   => $this->secure,
            'httponly' => false
        ];

        $storage  = setcookie( '_ga_storage', $this->clientId, $options['expires'], $options['path'], $options['domain'], $options['secure'], true );
        $gaCookie = setcookie( $this->cookieName, $this->clientId, $options['expires'], $options['path'], $options['domain'], $options['secure'], $options['httponly'] );

        echo $options['expires'];
        return $gaCookie;
    }

    /**
     * Get Client ID from storage cookie or from Google Analytics cookie or generate a new Client ID
     *
     * @return void
     */
    private function readClientId()
    {
        // Get Client ID from storage cookie if it exists
        if( isset( $_COOKIE['_ga_storage'] ) && !empty( $_COOKIE['_ga_storage'] ) )
        {
            $clientId = $_COOKIE['_ga_storage'];
        }
        // Or get Client ID from GA cookie
        elseif( isset( $_COOKIE[$this->cookieName] ) && !empty( $_COOKIE[$this->cookieName] ) )
        {
            $clientId = $_COOKIE[$this->cookieName];
        }
        // Or generate a new Client ID
        else
        {
            $clientId = $this->generateClientId();
        }

        return $clientId;
    }

    /**
     * Generates a Google Analytics Client ID
     *
     * @return void
     */
    private function generateClientId()
    {
        $client = 'GA1';
        $domain = count( explode( '.', $this->cookieDomain ) );
        $random = rand( 1000000000, 9999999999 );
        $time   = time();
        
        return implode( '.', ['GA1', $domain, $random, $time] );
    }

    /**
     * Getter for Client ID (in case it needs to be exposed in e.g. HTML code)
     *
     * @return void
     */
    public function getClientId()
    {
        return $this->clientId;
    }
}