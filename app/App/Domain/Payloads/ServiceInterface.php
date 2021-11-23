<?php

namespace App\App\Domain\Payloads;

interface ServiceInterface
{
    public function handle($data = []);
}
