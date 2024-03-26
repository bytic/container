<?php
declare(strict_types=1);

namespace Nip\Container\Traits;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 *
 */
trait BaseMethodsTrait
{

    public function get(string $id, int $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE): ?object
    {
        try {
            $return = parent::get($id, $invalidBehavior);
            return $return;
        } catch (ServiceNotFoundException $e) {
            foreach ($this->delegates as $delegate) {
                if ($delegate->has($id)) {
                    return $delegate->get($id);
                }
            }

            if (ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE < $invalidBehavior) {
                return null;
            }

            throw $e;
        }
    }

    public function has($id): bool
    {
        $return = parent::has($id);
        if ($return) {
            return $return;
        }

        foreach ($this->delegates as $delegate) {
            if ($delegate->has($id)) {
                return true;
            }
        }

        return false;
    }

    public function remove($alias)
    {
        $this->symfonyContainer->removeAlias($alias);
    }
}