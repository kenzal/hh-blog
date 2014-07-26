<?php

class Application_View_Helper_Date extends Zend_View_Helper_Abstract
{
    public function date(DateTime $date)
    {
        $format = DateTime::RFC850;
        if($date->format('s') == '00') {
            $format = str_replace(':s', '', $format);
            if($date->format('H:i') == '00:00') {
                $format = trim(str_replace('H:i T', '', $format));
            }
        }
        return $date->format($format);
    }
}
