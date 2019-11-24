<?php

namespace Nip\Container\Exception;

use Psr\Container\NotFoundExceptionInterface as NotFoundExceptionInterface;
use InvalidArgumentException;

/**
 * Class NotFoundException
 * @package Nip\Container\Exception
 */
class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
