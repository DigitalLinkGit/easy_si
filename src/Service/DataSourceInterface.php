<?php
namespace App\Service;

interface DataSourceInterface
{
    public function supports(string $source): bool;

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>[]
     */
    public function handle(array $params): array;
}
