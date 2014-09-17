<?php

namespace Encore\Giml\Reservation;

use Encore\Giml\Parser;
use Encore\Giml\ElementInterface;

interface ReservationInterface extends ElementInterface
{
    public function getElement(Parser $parser);
}