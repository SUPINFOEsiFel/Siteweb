<?php
/**
 * Created by PhpStorm.
 * User: jitrixis
 * Date: 10/05/15
 * Time: 00:47
 */

namespace FEL\AdminBundle\Meteor\Api;

use Buzz\Browser;
use Buzz\Exception as BuzzException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DefaultBrowser
{

    protected static $browser = null;
    private $security_context;
    private $meteor_host;
    private $meteor_port;
    private $meteor_secure;

    /**
     * @param TokenStorage $security_context
     * @param $meteor_host
     * @param $meteor_port
     * @param $meteor_secure
     */
    public function __construct(TokenStorage $security_context, $meteor_host, $meteor_port, $meteor_secure)
    {
        if (self::$browser == null) {
            self::$browser = new Browser();
        }
        $this->security_context = $security_context;
        $this->meteor_host = $meteor_host;
        $this->meteor_port = $meteor_port;
        $this->meteor_secure = $meteor_secure;
    }

    /**
     * @param $url
     * @param array $urlData
     * @param bool $anon
     * @param array $appendHeader
     * @param bool $returnJson
     * @return mixed
     */
    public function get($url, $urlData = array(), $anon = false, $appendHeader = array(), $returnJson = true)
    {
        try {
            $response = self::$browser->get(
                $this->getBaseURL($url.$this->url_encode($urlData, "?")),
                $this->getTokenHeader($anon, $appendHeader)
            );
            if ($returnJson) {
                return json_decode($response->getContent(), true);
            } else {
                return $response;
            }
        } catch (BuzzException\RequestException $e) {
            throw new ServiceUnavailableHttpException(
                null,
                "Meteor Service Unavailable, cannot reach the server. ".$e->getMessage()
            );
        }
    }

    public function post(
        $url,
        $headerData = array(),
        $urlData = array(),
        $anon = false,
        $appendHeader = array(),
        $returnJson = true
    ) {
        try {
            $response = self::$browser->post(
                $this->getBaseURL($url.$this->url_encode($urlData, "?")),
                $this->getTokenHeader($anon, $appendHeader),
                $this->url_encode($headerData)
            );
            if ($returnJson) {
                return json_decode($response->getContent(), true);
            } else {
                return $response;
            }
        } catch (BuzzException\RequestException $e) {
            throw new ServiceUnavailableHttpException(
                null,
                "Meteor Service Unavailable, cannot reach the server. ".$e->getMessage()
            );
        }
    }

    public function head($url, $urlData = array(), $anon = false, $appendHeader = array(), $returnJson = false)
    {
        try {
            $response = self::$browser->head(
                $this->getBaseURL($url.$this->url_encode($urlData, "?")),
                $this->getTokenHeader($anon, $appendHeader)
            );
            if ($returnJson) {
                return json_decode($response->getContent(), true);
            } else {
                return $response;
            }
        } catch (BuzzException\RequestException $e) {
            throw new ServiceUnavailableHttpException(
                null,
                "Meteor Service Unavailable, cannot reach the server. ".$e->getMessage()
            );
        }
    }

    public function patch(
        $url,
        $headerData = array(),
        $urlData = array(),
        $anon = false,
        $appendHeader = array(),
        $returnJson = true
    ) {
        try {
            $response = self::$browser->patch(
                $this->getBaseURL($url.$this->url_encode($urlData, "?")),
                $this->getTokenHeader($anon, $appendHeader),
                $this->url_encode($headerData)
            );
            if ($returnJson) {
                return json_decode($response->getContent(), true);
            } else {
                return $response;
            }
        } catch (BuzzException\RequestException $e) {
            throw new ServiceUnavailableHttpException(
                null,
                "Meteor Service Unavailable, cannot reach the server. ".$e->getMessage()
            );
        }
    }

    public function put(
        $url,
        $headerData = array(),
        $urlData = array(),
        $anon = false,
        $appendHeader = array(),
        $returnJson = true
    ) {
        try {
            $response = self::$browser->put(
                $this->getBaseURL($url.$this->url_encode($urlData, "?")),
                $this->getTokenHeader($anon, $appendHeader),
                $this->url_encode($headerData)
            );
            if ($returnJson) {
                return json_decode($response->getContent(), true);
            } else {
                return $response;
            }
        } catch (BuzzException\RequestException $e) {
            throw new ServiceUnavailableHttpException(
                null,
                "Meteor Service Unavailable, cannot reach the server. ".$e->getMessage()
            );
        }
    }

    public function delete(
        $url,
        $headerData = array(),
        $urlData = array(),
        $anon = false,
        $appendHeader = array(),
        $returnJson = true
    ) {
        try {
            $response = self::$browser->delete(
                $this->getBaseURL($url.$this->url_encode($urlData, "?")),
                $this->getTokenHeader($anon, $appendHeader),
                $this->url_encode($headerData)
            );
            if ($returnJson) {
                return json_decode($response->getContent(), true);
            } else {
                return $response;
            }
        } catch (BuzzException\RequestException $e) {
            throw new ServiceUnavailableHttpException(
                null,
                "Meteor Service Unavailable, cannot reach the server. ".$e->getMessage()
            );
        }
    }

    /**
     * @param $array
     * @param string $prepend
     * @return string
     */
    private function url_encode($array, $prepend = "")
    {
        $ret = "";
        foreach ($array as $key => $value) {
            switch (gettype($value)) {
                case "boolean":
                case "integer":
                case "double":
                case "string":
                case "array":
                    $ret .= "&".(string)$key."=".urlencode((string)$value);
                    break;
                case "object":
                    if ($value instanceof \DateTime) {
                        $ret .= "&".(string)$key."=".urlencode($value->format("d/m/Y H:i"));
                    } else {
                        throw new Exception("Unknown type to be converted in string");
                    }
                    break;
                default:
                    throw new Exception("Unknown type to be converted in string");
            }
        }
        if (substr($ret, 1)) {
            return $prepend.substr($ret, 1);
        } else {
            return "";
        }
    }

    /**
     * @param bool $anon
     * @param array $append
     * @return array
     */
    private function getTokenHeader($anon = false, $append = array())
    {
        if (!$anon) {
            return array_merge(
                array(
                    'X-User-Id' => $this->security_context->getToken()->getUser()->getUserid(),
                    'X-Auth-Token' => $this->security_context->getToken()->getUser()->getMeteortoken(),
                ),
                $append
            );
        }

        return $append;
    }

    /**
     * @param string $append
     * @return string
     */
    private function getBaseURL($append = "")
    {
        return "http".(($this->meteor_secure) ? 's' : '')."://".$this->meteor_host.":".(($this->meteor_port == null) ? "3000" : $this->meteor_port)."/api/".$append;
    }

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return self::$browser;
    }
}