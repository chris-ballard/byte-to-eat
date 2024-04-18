<?php

declare(strict_types=1);

namespace App\DTO;

class OrderResponse
{
    public function __construct(
        public readonly ?int $starter = null,
        public readonly ?int $mainCourse = null,
        public readonly ?int $dessert = null,
        public readonly ?string $message = null,
    ) {}

    public function isEmpty(): bool
    {
        return $this->starter === null &&
            $this->mainCourse === null &&
            $this->dessert === null &&
            $this->message === null;
    }

    public function toJson(): string
    {
        $orderResponse = [];

        if ($this->starter !== null) {
            $orderResponse['starter'] = $this->starter;
        }

        if ($this->mainCourse !== null) {
            $orderResponse['mainCourse'] = $this->mainCourse;
        }

        if ($this->dessert !== null) {
            $orderResponse['dessert'] = $this->dessert;
        }

        if ($this->message !== null) {
            $orderResponse['message'] = $this->message;
        }

        return \json_encode($orderResponse);
    }
}
