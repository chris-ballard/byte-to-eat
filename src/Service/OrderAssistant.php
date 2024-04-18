<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\OrderResponse;
use OpenAI\Client;
use OpenAI\Responses\Chat\CreateResponse;

readonly class OrderAssistant
{
    public function __construct(
        private Client $openAI,
        private string $dataDirectory,
    ) {}

    public function handleOrder(array $messages): OrderResponse
    {
        $response = $this->openAI->chat()->create([
            'model' => 'gpt-4-turbo',
            'messages' => $this->addSystemMessage($messages),
        ]);

        return $this->hydrateOrderResponse($response);
    }

    private function addSystemMessage(array $messages): array
    {
        $systemPrompt = sprintf(
            file_get_contents($this->dataDirectory . '/ai/system-prompt.txt'),
            file_get_contents($this->dataDirectory . '/menu/starter.csv'),
            file_get_contents($this->dataDirectory . '/menu/main-course.csv'),
            file_get_contents($this->dataDirectory . '/menu/dessert.csv'),
        );

        \array_unshift(
            $messages,
            ['role' => 'system', 'content' => $systemPrompt],
        );

        return $messages;
    }

    private function hydrateOrderResponse(CreateResponse $response): OrderResponse
    {
        $choices = $response->choices;
        $lastChoice = \end($choices);
        $assistantMessage = \json_decode($lastChoice->message->content);

        return new OrderResponse(
            $assistantMessage->starter ?? null,
            $assistantMessage->mainCourse ?? null,
            $assistantMessage->dessert ?? null,
            $assistantMessage->message ?? null,
        );
    }
}
