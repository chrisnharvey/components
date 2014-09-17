<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;

trait ReservationTrait
{
    public function getElement(Parser $parser)
    {
        return $this;
    }
}