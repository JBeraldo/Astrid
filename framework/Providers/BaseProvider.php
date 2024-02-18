<?php

namespace Astrid\Providers;

class BaseProvider
{
    public function __invoke(): void
    {
        $this->provide();
    }

    public function provide()
    {

    }
}