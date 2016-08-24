<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MainSlider;
use AppBundle\Repository\MainSliderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
        ]);
    }

    /**
     * @Route("/catalog", name="catalog")
     */
    public function catalogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:catalog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
        ]);
    }

    /**
     * @Route("/encyclopedia", name="encyclopedia")
     */
    public function encyclopediaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:encyclopedia.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
        ]);
    }

    /**
     * @Route("/encyclopedia/item/{id}", name="encyclopedia_item")
     */
    public function encyclopediaItemAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:encyclopedia.item.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
        ]);
    }

    /**
     * @Route("/catalog/item/{id}", name="catalog_item")
     */
    public function catalogItemAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:catalog.item.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
        ]);
    }
}
