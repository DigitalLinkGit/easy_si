<?php

namespace App\Capture\Service;

use App\Capture\Repository\QuestionInstanceRepository;
use App\Capture\Entity\QuizCapture;
use App\Capture\Enum\AnswerType;
use App\Capture\Entity\QuestionInstance;
use App\Capture\Entity\Proposal;

class GraphBuilder
{

    public function buildForSection(QuizCapture $quiz, QuestionInstanceRepository $qiRepo): array
    {
        $nodes = [];
        $links = [];
        $questionsByLevel = [];
        $conditionablesByLevel = [];


        foreach ($quiz->getQuestionsInstances() as $qi) {

            $level = $qi->getLevel();
            $questionsByLevel[$level] = ($questionsByLevel[$level] ?? 0) + 1;

            //créer tous les block question
            $nodes[] = [
                'id' => 'QI' . $qi->getId(),
                'label' => $qi->getId() . " - " . $qi->getQuestion()->getName(),
                'type' => 'question',
                'level' => $qi->getLevel(),
                'questionInstanceId' => $qi->getId(),
            ];
            //créer les liens entre questions (suite par défaut)
            if ($qi->getNextQuestionInstance()) {
                $links[] = [
                    'source' => 'QI' . $qi->getId(),
                    'target' => 'QI' . $qi->getNextQuestionInstance()->getId(),
                    'label' => '',
                ];
            }

            foreach ($qi->getQuestion()->getProposals() as $proposal) {

                if($qi->getQuestion()->getType() === AnswerType::SINGLE_CHOICE && !$qi->getNextQuestionInstance()) {

                    $conditionablesByLevel[$level] = ($conditionablesByLevel[$level] ?? 0) + 1;
                    //Créer les propositions
                    $pid = 'P' . $proposal->getId();
                    $nodes[] = [
                        'id' => $pid,
                        'label' => $proposal->getContent(),
                        'type' => 'proposal',
                        'level' => $qi->getLevel(),
                        'questionInstanceId' => $qi->getId(),
                    ];

                    $links[] = [
                        'source' => 'QI' . $qi->getId(),
                        'target' => $pid,
                        'label' => '',
                    ];

                    $condition = $qi->getConditionByProposalId($proposal->getId());
                    if ($condition && $condition->getNextQuestionInstance()) {
                        $target = $condition->getNextQuestionInstance();
                        $links[] = [
                            'source' => $pid,
                            'target' => 'QI' . $target->getId(),
                            'label' => 'condition',
                        ];
                    }
                }
            }
        }

        return [
            'nodes' => $nodes,
            'links' => $links,
            'questionsByLevel' => $questionsByLevel,
            'conditionablesByLevel' => $conditionablesByLevel,
            'height' => 2000,
        ];
    }
}
