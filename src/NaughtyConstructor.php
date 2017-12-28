<?php
namespace App;

class NaughtyConstructor
{
    public $html;

    public function __construct($url)
    {
        $this->html = file_get_contents($url);
    }

    public function getMetaTags()
    {
        $mime = 'text/plain';
        $filename = "data://{$mime};base64," . base64_encode($this->html);

        return get_meta_tags($filename);
    }

    public function getTitle()
    {
        preg_match("#<title>(.+)</title>#siU", $this->html, $matches);

        return !empty($matches[1]) ? $matches[1] : false;
    }
}