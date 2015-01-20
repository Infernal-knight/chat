<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

class MessageProcessorService extends ContainerAware
{
    protected static $IMG_EXTS = array('gif', 'jpg', 'jpeg', 'png');


    public function process($message) {

        $message = strip_tags($message);
        $message = $this->urlify($message);
        $message = $this->container->get('markdown.parser')->transformMarkdown($message);
        $message = str_replace(PHP_EOL, '</p><p>', $message);
        //removing paragraphs after markdown
        //$message = str_replace(array('<p>','</p>'),'',$message);
        return $message;
    }

    protected function urlify($text)
    {
        $regexpUrl = '/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]+(\/\S*)?/';

        preg_match_all($regexpUrl, $text, $matches);
        foreach ($matches[0] as $match) {
            if ($this->isImage($match)) {
                $text = str_replace($match, '<a href="'.$match.'" target="_blank"><img src="'.$match.'" width="100" height="100"></a>', $text);
            } else {
                $text = str_replace($match, '<a href="'.$match.'" target="_blank">'.$match.'</a>', $text);
            }

        }

        return $text;
    }

    protected function isImage($url)
    {
        $urlExt = pathinfo($url, PATHINFO_EXTENSION);
        if (in_array($urlExt, self::$IMG_EXTS)) {
            return true;
        }

        return false;
    }



    //slow one, but true
    /*protected function isImage($url)
    {
        $params = array('http' => array(
            'method' => 'HEAD'
        ));
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp)
            return false;  // Problem with url

        $meta = stream_get_meta_data($fp);
        if ($meta === false)
        {
            fclose($fp);
            return false;  // Problem reading data from url
        }

        $wrapper_data = $meta["wrapper_data"];
        if(is_array($wrapper_data)){
            foreach(array_keys($wrapper_data) as $hh){
                if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19
                {
                    fclose($fp);
                    return true;
                }
            }
        }

        fclose($fp);
        return false;
    }*/

}