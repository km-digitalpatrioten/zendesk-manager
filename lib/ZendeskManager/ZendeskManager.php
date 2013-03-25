<?php

namespace ZendeskManager;

use Buzz\Browser;
use ZendeskManager\Exception;

class ZendeskManager
{

    protected $browser;
    protected $url;

    public function __construct(\Buzz\Browser $browser)
    {
        if (!$this->_isCurlInstalled()) {
            throw new Exception\MissingCurlException();
        }
        
        $this->browser = $browser;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function setUsernamePassword($userPass)
    {
        $this->browser->getClient()->setOption(CURLOPT_USERPWD, $userPass);
    }

    protected function getResponse()
    {
        $content = $this->browser->getLastResponse()->getContent();
        $response = json_decode($this->browser->getLastResponse()->getContent());

        if (isset($response->error)) {
            if ($response->error == 'RecordInvalid') {
                throw new Exception\RecordInvalidException($content);
            } else {
                throw new Exception\UnexpectedResponseException($content);
            }
        } elseif ($this->getResponseStatus() >= 300) {
            throw new Exception\UnexpectedResponseException($content);
        }

        return $response;
    }

    protected function getResponseStatus()
    {
        $headers = $this->browser->getLastResponse()->getHeaders();
        foreach ($headers as $header) {
            if (substr($header, 0, 6) == 'Status') {
                return (int) substr($header, 8, 3);
            }
        }
    }

    protected function _isCurlInstalled()
    {
        if (in_array('curl', get_loaded_extensions())) {
            return true;
        } else {
            return false;
        }
    }

}