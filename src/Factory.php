<?php declare(strict_types=1);

namespace Jorpo\Environment;

interface Factory
{
    public function make(): Environment;
}
