<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MainSlider;
use AppBundle\Entity\Product;
use AppBundle\Repository\MainSliderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    private $productCategories = array();

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'productCategories' => $this->productCategories['productCategories'],
            'productLinks' => $this->productCategories['productLinks'],
        ]);
    }

    /**
     * @Route("/catalog", name="catalog")
     */
    public function catalogAction(Request $request)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        $allProducts = $em
            ->getRepository('AppBundle:Product')
            ->findAll();
        $filterArray = array();
        $categoryFilter = $request->get('categoryFilter');
        $productLinkFilter = $request->get('productLinkFilter');
        if ($categoryFilter) {
            $filterArray['category'] = $categoryFilter;
        }
        if ($productLinkFilter) {
            $filterArray['productLink'] = $productLinkFilter;
        }
        if ($filterArray) {
            $products = $em
                ->getRepository('AppBundle:Product')
                ->findBy($filterArray);
        } else {
            $products = $allProducts;
        }
        return $this->render('AppBundle:default:catalog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'products' => $products,
            'productCategories' => $this->productCategories['productCategories'],
            'productLinks' => $this->productCategories['productLinks'],
        ]);
    }

    /**
     * @Route("/encyclopedia", name="encyclopedia")
     */
    public function encyclopediaAction(Request $request)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:encyclopedia.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'productCategories' => $this->productCategories['productCategories'],
            'productLinks' => $this->productCategories['productLinks'],
        ]);
    }

    /**
     * @Route("/encyclopedia/item/{id}", name="encyclopedia_item")
     */
    public function encyclopediaItemAction(Request $request, $id)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        return $this->render('AppBundle:default:encyclopedia.item.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'productCategories' => $this->productCategories['productCategories'],
            'productLinks' => $this->productCategories['productLinks'],
        ]);
    }

    /**
     * @Route("/catalog/item/{alias}", name="catalog_item")
     */
    public function catalogItemAction(Request $request, $alias)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        $allProducts = $em
            ->getRepository('AppBundle:Product')
            ->findAll();
        /** @var Product $productItem */
        $productItem = $em
            ->getRepository('AppBundle:Product')
            ->findOneBy(array('alias' => $alias));
        $productCategories = $this->getProductCategories($allProducts);
        $productCategory = $productItem->getCategory();
        $likeProducts = $productCategory->getProducts()->toArray();
        foreach ($likeProducts as $key => $likeProduct) {
            if ($likeProduct->getId() == $productItem->getId()) {
                unset($likeProducts[$key]);
            }
        }
        shuffle($likeProducts);
        return $this->render('AppBundle:default:catalog.item.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'productItem' => $productItem,
            'productCategories' => $productCategories['productCategories'],
            'productLinks' => $productCategories['productLinks'],
            'likeProducts' => $likeProducts,
            'productCategory' => $productCategory,
            'productCategories' => $this->productCategories['productCategories'],
            'productLinks' => $this->productCategories['productLinks'],
        ]);
    }

    private function getProductCategories($products)
    {
        $productCategories = array();
        $productLinks = array();
        foreach ($products as $product) {
            if (!in_array($product->getCategory(), $productCategories)) {
                $productCategories[] = $product->getCategory();
            }
            if (!in_array($product->getProductLink(), $productLinks)) {
                $productLinks[] = $product->getProductLink();
            }
        }
        return array(
            'productCategories' => $productCategories,
            'productLinks' => $productLinks,
        );
    }

    private function getMenuItems()
    {
        $em = $this->getDoctrine()->getManager();
        $allProducts = $em
            ->getRepository('AppBundle:Product')
            ->findAll();
        $this->productCategories = $this->getProductCategories($allProducts);
    }
}
