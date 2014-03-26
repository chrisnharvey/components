<?php

namespace Encore\GIML;

interface IdentifierInterface
{
    public function generate();

    public function reserve($id);
}