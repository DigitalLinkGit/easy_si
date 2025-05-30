<?php

namespace App\Design\DataFixtures;

use App\Design\Entity\DataTable;
use App\Design\Entity\Element;
use App\Design\Entity\Flow;
use App\Design\Entity\Interaction;
use App\Design\Entity\Service;
use App\Design\Entity\Transition;
use App\Design\Entity\TransitionChoice;
use App\Design\Entity\Transformation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DesignFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. Éléments
        $elements = [];
        foreach ([
            'ETL', 'CRM', 'Communication', 'ERP', 'E-commerce',
            'Paiement', 'BI', 'DWH', 'Gestion projet', 'Notes de frais', 'Support'
        ] as $name) {
            $element = new Element();
            $element->setName($name);
            $manager->persist($element);
            $elements[$name] = $element;
        }

        // 2. Services (exemple pour ERP)
        $erpOdata = new Service();
        $erpOdata->setType('odata')
            ->setName('ERP OData')
            ->setEndpoint('https://erp.local/odata')
            ->setMethod('GET')
            ->setFormat('json')
            ->setDirection('in')
            ->setElement($elements['ERP']);
        $manager->persist($erpOdata);

        $etlRest = new Service();
        $etlRest->setType('rest')
            ->setName('ETL REST')
            ->setEndpoint('https://etl.local/api/import')
            ->setMethod('POST')
            ->setFormat('json')
            ->setDirection('out')
            ->setElement($elements['ETL']);
        $manager->persist($etlRest);

        // ... ajouter d'autres services pour chaque Element si besoin

        // 3. Flows
        $flows = [
            'commandes' => new Flow(),
            'consolidation' => new Flow(),
            'projets' => new Flow(),
            'bi' => new Flow(),
            'clients' => new Flow(),
            'releves' => new Flow(),
            'paiements' => new Flow(),
            'support' => new Flow(),
        ];
        $flows['commandes']->setName('Intégration des commandes')->setStarter('triggered');
        $flows['consolidation']->setName('Consolidation analytique')->setStarter('frequent');
        $flows['projets']->setName('Notification de création de projet')->setStarter('triggered');
        $flows['bi']->setName('Mise à jour BI')->setStarter('frequent');
        $flows['clients']->setName('Création client ERP')->setStarter('triggered');
        $flows['releves']->setName('Import relevés bancaires')->setStarter('frequent');
        $flows['paiements']->setName('Intégration des paiements')->setStarter('frequent');
        $flows['support']->setName('Monitoring des tickets')->setStarter('frequent');

        foreach ($flows as $flow) {
            $manager->persist($flow);
        }

        // 4. Interactions et DataTables
        $i1 = new Interaction();
        $i1->setLabel('Envoi commandes E-com')
            ->setDataName('commande')
            ->setElementIn($elements['E-commerce'])
            ->setElementOut($elements['ETL'])
            ->setFlow($flows['commandes'])
            ->setServiceIn(null)
            ->setServiceOut($etlRest)
            ->setDescription('Transmission des commandes en temps réel');

        $tableCmd = new DataTable();
        $tableCmd->setName('Commandes');


        $manager->persist($i1);
        $manager->persist($tableCmd);

        $i2 = new Interaction();
        $i2->setLabel('Import ERP')
            ->setDataName('commande')
            ->setElementIn($elements['ETL'])
            ->setElementOut($elements['ERP'])
            ->setFlow($flows['commandes'])
            ->setServiceIn($etlRest)
            ->setServiceOut($erpOdata)
            ->setDescription('Injection dans module commandes ERP');

        $tableErp = new DataTable();
        $tableErp->setName('Commandes ERP');

        $manager->persist($i2);
        $manager->persist($tableErp);

        // 5. Transition (de i1 vers i2)
        $transition1 = new Transition();
        $transition1->setType('direct')
            ->setFrom($i1)
            ->setLabel('Vers ERP');

        $choice = new TransitionChoice();
        $choice->setLabel('Par défaut')
            ->setTarget($i2);
        $transition1->addChoice($choice);
        $manager->persist($transition1);
        $manager->persist($choice);

        // 6. Transformation
        $transformation = new Transformation();
        $transformation->setSourceTable($tableCmd)
            ->setTargetTable($tableErp)
            ->setSourceKeyColumn('cmd_id')
            ->setTargetKeyColumn('order_id')
            ->setTransformationRules(json_encode([
                'cmd_id' => 'order_id',
                'montant_total' => 'total_ht',
                'date_commande' => 'order_date'
            ]));
        $transition1->setTransformation($transformation);
        $manager->persist($transformation);

        // ... Répéter pour tous les flows comme dans le scénario
        // Pour chaque flow : créer interactions, datatables, services, transitions

        $manager->flush();
    }
}
