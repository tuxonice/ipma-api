<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Exception;

/**
 * Thrown when the IPMA API returns an unexpected HTTP status (3xx, 4xx or 5xx).
 */
class IpmaResponseException extends IpmaApiException
{
}
