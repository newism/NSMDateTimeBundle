<?php

namespace NSM\Bundle\DateTimeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class HumanToSecondsTransformer implements DataTransformerInterface
{
    /**
     * Transforms database value (seconds) into human time
     *
     * @throws UnexpectedTypeException if the given value is not an array
     * @throws TransformationFailedException if the choices can not be retrieved
     */
    public function transform($secs)
    {
        if (null === $secs) {
            return "";
        }

        if(!$secs) return '0:00';

        $vals = array(
            'h' => floor($secs / 3600),
            'm' => sprintf("%02d", $secs / 60 % 60), 
            //'s' => sprintf("%02d", $secs % 60)
        ); 

        return join(':', $vals); 
    }

    /**
     * Transforms a human string into seconds.
     *
     * @throws UnexpectedTypeException if the given value is not an array
     */
    public function reverseTransform($value)
    {
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if(empty($value)) {
            return 0;
        }

        if (strpos($value, ":") !== FALSE)
        {
            $str_time = preg_replace("/^:([\d]{2})$/", "00:$1", $value);
            sscanf($value, "%d:%d", $hours, $minutes);
            $value = (int)$hours + $minutes / 60;
        }
        
        if(false == is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'numeric');
        }

        $value = $value * 3600;

        return $value;
    }
}
