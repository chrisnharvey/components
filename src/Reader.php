<?php

namespace Encore\GIML;

class Reader extends \Sabre\XML\Reader implements ReaderInterface
{
    /**
     * Returns the current nodename in clark-notation.
     *
     * For example: "{http://www.w3.org/2005/Atom}feed".
     * This method returns null if we're not currently on an element.
     *
     * @return string
     */
    public function getClark()
    {
        if ( ! $this->namespaceURI) return $this->localName;

        return '{' . $this->namespaceURI . '}' . $this->localName;
    }
}