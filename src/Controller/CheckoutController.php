<?php

namespace App\Controller;

use App\Form\CardType;
use App\Model\Card;
use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * @Route("/checkout")
 */
class CheckoutController extends AbstractController
{
    /**
     * @Route("/payment", name="checkout_payment", methods={"GET","POST"})
     */
    public function payment(Request $request, SessionInterface $session)
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @todo process payment
            $objectManager = $this->getDoctrine()->getManager();
            $cart = new Cart();
            $objectManager->persist($cart);
            $objectManager->flush();
            $session->set('cart', $cartId = $cart->getId());
        }

        return $this->render('checkout/payment.html.twig', [
            'card' => $card,
            'form' => $form->createView(),
        ]);
    }
}
