<?php
namespace App\Design\Service;

use App\Design\Service\DataSourceInterface;

class DataSourceRegistry
{
    /**
     * @param iterable<DataSourceInterface> $handlers
     */
    public function __construct(private iterable $handlers) {}

    public function get(string $source): DataSourceInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($source)) {
                return $handler;
            }
        }

        throw new \InvalidArgumentException("Aucun gestionnaire trouvé pour la source '$source'");
    }
}
