<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;
use Encore\Giml\ElementInterface;

interface ReservationInterface extends ElementInterface
{
    /**
     * Get an instance of ElementInterface for this reservation
     * 
     * @param  Parser $parser
     * @param  ElementInterface $parent
     * @return array
     */
    public function getElement(Parser $parser, ElementInterface $parent = null);
}