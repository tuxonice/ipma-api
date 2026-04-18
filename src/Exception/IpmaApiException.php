<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Exception;

use RuntimeException;

/**
 * Base exception for all errors raised by the IPMA API client.
 * Consumers can catch this single type to handle any library-level failure.
 */
class IpmaApiException extends RuntimeException
{
}
