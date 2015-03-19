<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;
use Encore\Giml\ElementInterface;

class RequireReservation implements ReservationInterface
{
    use ReservationTrait;

    /**
     * Get an instance of ElementInterface for this reservation
     * 
     * @param  Parser $parser
     * @param  ElementInterface $parent
     * @return array
     */
    public function getElement(Parser $parser, ElementInterface $parent = null)
    {
        $parser->getReader()->open($this->src);
        $parsed = $parser->getReader()->parse();

        return $parser->parseElements($parsed['value'], $parent);
    }
}