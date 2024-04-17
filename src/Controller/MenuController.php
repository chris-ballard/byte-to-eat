<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\OrderType;
use App\Service\OrderFormBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu')]
    public function index(OrderFormBuilder $orderFormBuilder, Request $request): Response
    {
        $form = $orderFormBuilder->createOrderForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('create_order')->isClicked()) {
                $this->addFlash('success', 'Create Order button was pressed.');
            } elseif ($form->get('place_order')->isClicked()) {
                $this->addFlash('success', 'Place Order button was pressed.');
            }
            return $this->redirectToRoute('app_menu');
        }

        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
