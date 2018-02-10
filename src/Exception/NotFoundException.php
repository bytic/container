<?php

namespace Nip\Container\Exception;

use Interop\Container\Exception\NotFoundException as NotFoundExceptionInterface;
use InvalidArgumentException;

/**
 * Class NotFoundException
 * @package Nip\Container\Exception
 */
class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
