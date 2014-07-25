<?php

class Application_Plugin_Front_HHTag extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopShutdown()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $authors = new Application_Model_AuthorMapper;
        $response = $this->getResponse();
        $dom = new DomDocument;
        @$dom->loadHTML($response->getBody());
        $tags = $dom->getElementsByTagName('hh-user');
        while ($tags->length > 0) {
            $tag = $tags->item(0);
            $userName = $tag->getAttribute('name');
            $tag->removeAttribute('name');
            $user = $authors->findByName($userName);
            if ($user) {
                $link = $dom->createElement('a');
                $link->setAttribute('href', $frontController->getBaseUrl()."/user/{$user->username}");
                if(!$tag->childNodes->length) {
                    $link->nodeValue = $user->displayName ?: $user->username;
                }
            } else {
                $link = $dom->createElement('span');
                if(!$tag->childNodes->length) {
                    $link->nodeValue = $userName;
                }
            }
            $link->setAttribute('class', trim($tag->getAttribute('class') . ' hh-user'));
            $tag->removeAttribute('class');
            $link->setAttribute('data-username', $userName);
            foreach ($tag->childNodes as $child){
                $link->appendChild($child->cloneNode(true));
            }
            $attributes = $tag->attributes;
            while ($attributes->length > 0) {
                $attribute = $attributes->item(0);
                if (!is_null($attribute->namespaceURI)) {
                  $link->setAttributeNS('http://www.w3.org/2000/xmlns/',
                                              'xmlns:'.$attribute->prefix,
                                              $attribute->namespaceURI);
                }
                $link->setAttributeNode($attribute);
            }
            $tag->parentNode->replaceChild($link, $tag);
        }
        $content = $dom->saveHTML();
        $response->setBody($content);
    }


}
