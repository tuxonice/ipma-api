<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Exception;

/**
 * Thrown when the body returned by the IPMA API cannot be decoded (invalid JSON, etc.).
 */
class IpmaDecodingException extends IpmaApiException
{
}
