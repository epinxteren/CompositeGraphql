<?php

namespace CompositeGraphQL\Presentation\Contract;

interface RelayConnection extends OutputObject
{
    public function getEdge(): OutputObject;

    public function getPageInfo(): OutputObject;
}
