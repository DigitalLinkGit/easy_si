<?php
namespace App\Design\Service;

interface DataSourceInterface
{
    public function supports(string $source): bool;

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>[]
     */
    public function handle(array $params): array;
}
