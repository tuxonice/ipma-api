<?php

declare(strict_types=1);

namespace Tlab\IpmaApi\Exception;

/**
 * Thrown when a network/transport-level error occurs while talking to the IPMA API
 * (DNS failure, connection timeout, TLS error, etc.).
 */
class IpmaTransportException extends IpmaApiException
{
}
