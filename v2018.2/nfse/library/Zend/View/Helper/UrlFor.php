<?php
require_once 'Zend/View/Helper/Abstract.php';

class Zend_View_Helper_UrlFor extends Zend_View_Helper_Abstract {

    /**
     * Return the URL
     *
     * @param string|array $urlOptions
     * @param string       $name
     * @param bool         $reset
     * @param bool         $encode
     * @return string
     */
    public function urlFor($urlOptions, $name = null, $reset = false, $encode = true) {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        if (is_string($urlOptions)) {
            $urlOptions = '/' . ltrim($urlOptions, '/'); // Case the first character is a '?
            $request = new Zend_Controller_Request_Http(); // Creates a cleaned instance of request http
            $request->setBaseUrl($front->getBaseUrl());
            $request->setRequestUri($urlOptions);
            $route = $router->route($request); // Return the request route with params modifieds
            $urlOptions = $route->getParams();
            /*var_dump($route->getParams());
            die();*/
        }
        return $router->assemble((array) $urlOptions, $name, $reset, $encode);
    }

}