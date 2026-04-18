<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Dto;

trait ToArrayTrait
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
