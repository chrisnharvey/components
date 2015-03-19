<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;
use Encore\Giml\ElementInterface;
use Encore\Giml\ElementTrait;

trait ReservationTrait
{
    use ElementTrait;

    /**
     * Get an instance of ElementInterface for this reservation
     * 
     * @param  Parser $parser
     * @param  ElementInterface $parent
     * @return array
     */
    public function getElement(Parser $parser, ElementInterface $parent)
    {
        return $this;
    }

    /**
     * Get the raw element object
     * 
     * @return mixed
     */
    public function getRaw()
    {
        return $this;
    }

    /**
     * Destroy the element
     * 
     * @return void
     */
    public function destroy()
    {
        
    }
}