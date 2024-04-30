<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OrderAssistant;
use App\Service\OrderFormBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    public function __construct(
       readonly private OrderFormBuilder $orderFormBuilder,
       readonly private OrderAssistant $orderAssistant,
    ) {}

    #[Route('/', name: 'app_menu')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->orderFormBuilder->createOrderForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('ask_order_assistant')->isClicked()) {
                try {
                    $form = $this->handleCreateOrder($form, $session);
                } catch (\Throwable) {
                    $this->addFlash('danger', 'Error processing order');
                }
            }

            if ($form->get('place_order')->isClicked()) {
                $form = $this->handlePlaceOrder($form, $session);
            }
        }

        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function handleCreateOrder(FormInterface $form, SessionInterface $session): FormInterface
    {
        $messages = $session->get('messages', []);
        $messages[] = ['role' => 'user', 'content' => $form->get('order')->getData()];

        $orderResponse = $this->orderAssistant->handleOrder($messages);
        if ($orderResponse->isEmpty()) {
            $this->addFlash('danger', 'Error processing order: invalid order response');
            return $form;
        }

        $updatedForm = $this->orderFormBuilder->createOrderForm();

        if ($orderResponse->starter !== null) {
            $updatedForm->get('starter')->setData($orderResponse->starter);
        }

        if ($orderResponse->mainCourse !== null) {
            $updatedForm->get('main_course')->setData($orderResponse->mainCourse);
        }

        if ($orderResponse->dessert !== null) {
            $updatedForm->get('dessert')->setData($orderResponse->dessert);
        }

        if ($orderResponse->message !== null) {
            $this->addFlash('info', $orderResponse->message);
        }

        $messages[] = ['role' => 'assistant', 'content' => $orderResponse->toJson()];
        $session->set('messages', $messages);

        return $updatedForm;
    }

    private function handlePlaceOrder(FormInterface $form, SessionInterface $session): FormInterface
    {
        $this->addFlash('success', 'Thank you for your order - enjoy your meal!');
        $session->set('messages', []);

        return $this->orderFormBuilder->createOrderForm();
    }
}
