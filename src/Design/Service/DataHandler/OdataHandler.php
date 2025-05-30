<?php
namespace App\Design\Service\DataHandler;

use App\Design\Service\RequestService;
use App\Design\Service\DataSourceInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('app.data_source')]
class OdataHandler implements DataSourceInterface
{
    public function __construct(private readonly RequestService $requestService) {}

    public function supports(string $source): bool
    {
        return $source === 'odata';
    }

    /**
     * @param array $params ['url' => ..., 'username' => ..., 'password' => ...]
     * @return array<string, mixed>[]
     */
    public function handle(array $params): array
    {
        $url = $params['url'] ?? '';
        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';

        $data = $this->requestService->fetch($url, [
            'auth_basic' => [$username, $password],
            'headers' => [
                'Accept' => 'application/json, application/xml;q=0.9, */*;q=0.8',
            ],
        ]);

        // JSON : cas métier
        if (is_array($data) && isset($data['d']['results'])) {
            return $data['d']['results'];
        }

        // XML : cas metadata
        if ($data instanceof \SimpleXMLElement) {
            return $this->extractMetadataEntitiesFromAnyNamespace($data);
        }

        // fallback brut
        return [['RawResponse' => is_scalar($data) ? $data : json_encode($data)]];
    }

    private function extractMetadataEntitiesFromAnyNamespace(\SimpleXMLElement $xml): array
    {
        $entities = [];

        $schemas = $xml->xpath("//*[local-name()='Schema']");
        if (!$schemas) {
            return [['Error' => 'Aucun noeud Schema trouvé']];
        }

        foreach ($schemas as $schema) {
            $entityTypes = $schema->xpath("*[local-name()='EntityType']");
            foreach ($entityTypes as $entity) {
                $entityName = (string) ($entity['Name'] ?? 'UnknownEntity');
                $props = $entity->xpath("*[local-name()='Property']");
                foreach ($props as $property) {
                    $propData = ['Entity' => $entityName];
                    foreach ($property->attributes() as $k => $v) {
                        $propData[$k] = (string) $v;
                    }
                    foreach ($property->attributes('sap', true) as $k => $v) {
                        $propData["sap:$k"] = (string) $v;
                    }
                    foreach ($property->attributes('c4c', true) as $k => $v) {
                        $propData["c4c:$k"] = (string) $v;
                    }
                    $entities[] = $propData;
                }
            }
        }

        return $entities;
    }
}
