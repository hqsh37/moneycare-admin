<?php

class App
{
    public $root;
    public $app_folder;
    public $http_host;
    public $urls;
    public $uri;
    public $method;


    public function __construct()
    {
        $root = str_replace('/index.php', '', $_SERVER["SCRIPT_FILENAME"]);
        $uri = $_SERVER['REQUEST_URI'];
        $app_folder = str_replace('/index.php', '', $_SERVER["SCRIPT_NAME"]);
        $http_host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $app_folder;
        $url = $uri;
        while (strpos($url, '//') !== false) {
            $url = str_replace('//', '/', $url);
        }
        $url = str_replace('noithemdeloai' . $app_folder . '/', '', "noithemdeloai" . $url);
        $url = explode('?', $url)['0'];
        $url = rtrim($url, '/');
        $urls = explode('/', $url);
        $method = $_SERVER["REQUEST_METHOD"];

        $this->root = $root;
        $this->app_folder = $app_folder;
        $this->http_host = $http_host;
        $this->urls = $urls;
        $this->uri = $uri;
        $this->method = $method;
    }

    public function geturl($path)
    {
        return $this->http_host . '/' . $path;
    }

    public function geturlParent()
    {
        return $this->urls[0] == "" ? "home" : $this->urls[0];
    }


    public function getmethod()
    {
        $methodNew = $this->method;
        return $methodNew;
    }

    public function convertDate($date)
    {
        $date = explode('-', $date);
        return $date[2] . '/' . $date[1] . '/' . $date[0];
    }

    public static function getCurrentDate($format = 'Y-m-d')
    {
        return date($format);
    }


    function convertToVND($number)
    {
        $vndString = number_format($number, 0, ',', '.') . '₫';

        return $vndString;
    }

    // func generate UUID from string
    function generateId($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    // func generate random number
    function generateRandomNumbers($length)
    {
        $numberString = '';

        for ($i = 0; $i < $length; $i++) {
            $numberString .= rand(0, 9);
        }

        return $numberString;
    }


    // funtion covert persent
    public function convertPersent($persent)
    {
        $persent = $persent * 100;
        $persent = number_format($persent, 0, ',', '.') . '%';
        return $persent;
    }

    // check 404 page
    public function check404Page()
    {
        if (count($this->urls) == 0 || $this->urls[0] == '') {
            return false;
        }

        $path_page = 'views/' . $this->urls[0] . '.php';
        if (!file_exists($path_page)) {
            return true;
        }

        return false;
    }


    public function run()
    {
        if (count($this->urls) == 0 || $this->urls[0] == '') {
            include 'views/home.php';
        } elseif (count($this->urls) > 0) {
            $path_page = 'views/' . $this->urls[0] . '.php';
            if (file_exists($path_page)) {
                require $path_page;
            } else {
                include 'views/404.php';
            }
        }
    }
}
