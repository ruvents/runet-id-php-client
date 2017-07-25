<?php

namespace RunetId\ApiClient\Iterator;

interface IteratorInterface extends \Iterator
{
    public function setContext(array $context);
}
