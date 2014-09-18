<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;
use Encore\Giml\ElementInterface;

class RequireReservation implements ReservationInterface
{
    use ReservationTrait;

    public function getElement(Parser $parser, ElementInterface $parent = null)
    {
        $parser->getReader()->open($this->src);
        $parsed = $parser->getReader()->parse();

        return $parser->parseElements($parsed['value'], $parent);
    }
}