<?php

declare(strict_types=1);

namespace App\Service;

use App\Form\OrderType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class OrderFormBuilder
{
    private string $dataDirectory;

    public function __construct(
        private FormFactoryInterface $formFactory,
        private SerializerInterface  $serializer,
        private string $projectDir,
    ) {
        $this->dataDirectory = $projectDir . '/data/menu';
    }

    public function createOrderForm(): FormInterface
    {
        $starterChoices = $this->getCsvChoices('starter.csv');
        $mainCourseChoices = $this->getCsvChoices('main_course.csv');
        $dessertChoices = $this->getCsvChoices('dessert.csv');

        $options = [];
        $options['starter_choices'] = array_column($starterChoices, 'id', 'name');
        $options['main_course_choices'] = array_column($mainCourseChoices, 'id', 'name');
        $options['dessert_choices'] = array_column($dessertChoices, 'id', 'name');

        return $this->formFactory->create(OrderType::class, null, $options);
    }

    private function getCsvChoices(string $filename): array
    {
        $csvData = file_get_contents($this->dataDirectory . '/' . $filename);
        return $this->serializer->decode($csvData, 'csv');
    }
}
