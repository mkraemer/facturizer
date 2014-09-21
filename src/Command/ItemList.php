<?php

namespace Facturizer\Command;

/**
 * Command\ItemList
 */
class ItemList
{
    public function __invoke()
    {
        echo 'Test';
    }

    public function getKey()
    {
        return 'item-list';
    }
}
