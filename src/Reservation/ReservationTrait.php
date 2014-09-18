<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;
use Encore\Giml\ElementInterface;
use Encore\Giml\ElementTrait;

trait ReservationTrait
{
    use ElementTrait;

    public function getElement(Parser $parser, ElementInterface $parent)
    {
        return $this;
    }

    public function getRaw()
    {
        return $this;
    }

    public function destroy()
    {
        
    }
}