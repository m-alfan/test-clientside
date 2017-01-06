<?php

namespace app\components;

use Yii;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\httpclient\RequestEvent;
use yii\httpclient\Response;

class MaClient extends Client
{
    /**
     * Creates 'GET' request.
     * @param string $url target URL.
     * @param array|string $data if array - request data, otherwise - request content.
     * @param array $headers request headers.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function get($url, $data = null, $headers = [], $options = [])
    {
        return $this->createRequestShortcut('get', $url, $data, $headers, $options);
    }

    /**
     * Creates 'POST' request.
     * @param string $url target URL.
     * @param array|string $data if array - request data, otherwise - request content.
     * @param array $headers request headers.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function post($url, $data = null, $headers = [], $options = [])
    {
        return $this->createRequestShortcut('post', $url, $data, $headers, $options);
    }

    /**
     * Creates 'PUT' request.
     * @param string $url target URL.
     * @param array|string $data if array - request data, otherwise - request content.
     * @param array $headers request headers.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function put($url, $data = null, $headers = [], $options = [])
    {
        return $this->createRequestShortcut('put', $url, $data, $headers, $options);
    }

    /**
     * Creates 'PATCH' request.
     * @param string $url target URL.
     * @param array|string $data if array - request data, otherwise - request content.
     * @param array $headers request headers.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function patch($url, $data = null, $headers = [], $options = [])
    {
        return $this->createRequestShortcut('patch', $url, $data, $headers, $options);
    }

    /**
     * Creates 'DELETE' request.
     * @param string $url target URL.
     * @param array|string $data if array - request data, otherwise - request content.
     * @param array $headers request headers.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function delete($url, $data = null, $headers = [], $options = [])
    {
        return $this->createRequestShortcut('delete', $url, $data, $headers, $options);
    }

    /**
     * Creates 'HEAD' request.
     * @param string $url target URL.
     * @param array $headers request headers.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function head($url, $headers = [], $options = [])
    {
        return $this->createRequestShortcut('head', $url, null, $headers, $options);
    }

    /**
     * Creates 'OPTIONS' request.
     * @param string $url target URL.
     * @param array $options request options.
     * @return Request request instance.
     */
    public function options($url, $options = [])
    {
        return $this->createRequestShortcut('options', $url, null, [], $options);
    }

    /**
     * This method is invoked right before request is sent.
     * The method will trigger the [[EVENT_BEFORE_SEND]] event.
     * @param Request $request request instance.
     * @since 2.0.1
     */
    public function beforeSend($request)
    {
        $event          = new RequestEvent();
        $event->request = $request;
        $this->trigger(self::EVENT_BEFORE_SEND, $event);
    }

    /**
     * This method is invoked right after request is sent.
     * The method will trigger the [[EVENT_AFTER_SEND]] event.
     * @param Request $request request instance.
     * @param Response $response received response instance.
     * @since 2.0.1
     */
    public function afterSend($request, $response)
    {
        $event           = new RequestEvent();
        $event->request  = $request;
        $event->response = $response;
        $this->trigger(self::EVENT_AFTER_SEND, $event);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array|string $data
     * @param array $headers
     * @param array $options
     * @return Request request instance.
     */
    private function createRequestShortcut($method, $url, $data, $headers, $options)
    {
        if (empty($headers)) {
            $headers = $this->configDefaultHeader();
        }

        $request = $this->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->addHeaders($headers)
            ->addOptions($options);
        if (is_array($data)) {
            $request->setData($data);
        } else {
            $request->setContent($data);
        }
        return $request;
    }

    /**
     * Default header
     * 
     * @return array
     */
    protected function configDefaultHeader()
    {
        $auth_key = Yii::$app->params['tokenDefault'];
        $token    = Yii::$app->params['tokenDefault'];
        if (!Yii::$app->user->isGuest) {
            $auth_key = Yii::$app->user->identity->auth_key;
            $token    = Yii::$app->user->identity->token;
        }

        return [
            'content-type' => 'application/json',
            'auth-key'     => $auth_key,
            'token'        => $token,
        ];
    }
}
