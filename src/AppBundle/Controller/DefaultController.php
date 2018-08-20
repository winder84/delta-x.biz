<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MainSlider;
use AppBundle\Entity\Product;
use AppBundle\Repository\MainSliderRepository;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    private $productLinks = array();

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
        $lastNews = $em
            ->getRepository('AppBundle:Article')
            ->findOneBy(
                array('type' => 1),
                array('id' => 'DESC')
            );
        $lastArticles = $em
            ->getRepository('AppBundle:Article')
            ->findBy(
                array('type' => 0),
                array('id' => 'DESC')
            );
        return $this->render('AppBundle:default:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'productLinks' => $this->productLinks,
            'lastNews' => $lastNews,
            'lastArticles' => $lastArticles,
        ]);
    }

    /**
     * @Route("/catalog", name="catalog")
     */
    public function catalogAction(Request $request)
    {
        $this->getMenuItems();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $slides = $em
            ->getRepository('AppBundle:MainSlider')
            ->findAll();
        $categoryFilter = $request->get('categoryFilter');
        $productLinkFilter = $request->get('productLinkFilter');
        if ($productLinkFilter) {
            $actualProductLink = $em
                ->getRepository('AppBundle:ProductLink')
                ->findOneBy(array(
                    'id' => $productLinkFilter
                ));
        } else {
            $actualProductLink = $em
                ->getRepository('AppBundle:ProductLink')
                ->findOneBy(array('id' => 2));
        }
        $products = $em
            ->getRepository('AppBundle:Product')
            ->findBy(array('productLink' => $actualProductLink->getId()), array('title' => 'ASC'));
        $productCategories = $this->getProductCategories($products);
        return $this->render('AppBundle:default:catalog.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'slides' => $slides,
            'products' => $products,
            'productCategories' => $productCategories,
            'productLinks' => $this->productLinks,
            'actualProductLink' => $actualProductLink,
            'actualCategoryId' => $categoryFilter,
            'pageTitle' => 'Каталог - ' . $actualProductLink->getTitle(),
        ]);
    }

    /**
     * @Route("/encyclopedia", name="encyclopedia")
     */
    public function encyclopediaAction(Request $request)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $articles = $em
            ->getRepository('AppBundle:Article')
            ->findBy(array(), array('id' => 'DESC'));
        return $this->render('AppBundle:default:encyclopedia.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'productLinks' => $this->productLinks,
            'articles' => $articles,
            'pageTitle' => 'Энциклопедия',
        ]);
    }

    /**
     * @Route("/encyclopedia/item/{alias}", name="encyclopedia_item")
     */
    public function encyclopediaItemAction(Request $request, $alias)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $article = $em
            ->getRepository('AppBundle:Article')
            ->findOneBy(array(
                'alias' => $alias
            ));
        return $this->render('AppBundle:default:encyclopedia.item.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'productLinks' => $this->productLinks,
            'article' => $article,
            'pageTitle' => $article->getTitle(),
        ]);
    }

    /**
     * @Route("/catalog/item/{alias}", name="catalog_item")
     */
    public function catalogItemAction(Request $request, $alias)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        /** @var Product $productItem */
        $productItem = $em
            ->getRepository('AppBundle:Product')
            ->findOneBy(array('alias' => $alias));
        $actualProductLink = $productItem->getProductLink();
        $allLinkProducts = $em
            ->getRepository('AppBundle:Product')
            ->findBy(array('productLink' => $actualProductLink));
        $productCategories = $this->getProductCategories($allLinkProducts);
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
            'productItem' => $productItem,
            'productCategories' => $productCategories,
            'likeProducts' => $likeProducts,
            'productCategory' => $productCategory,
            'productLinks' => $this->productLinks,
            'actualProductLink' => $actualProductLink,
            'pageTitle' => $productItem->getTitle(),
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        $this->getMenuItems();
        $em = $this->getDoctrine()->getManager();
        $rewards = $em
            ->getRepository('AppBundle:Rewards')
            ->findBy(array(), array('id' => 'DESC'));
        return $this->render('AppBundle:default:about.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'productLinks' => $this->productLinks,
            'rewards' => $rewards,
            'pageTitle' => 'О нас',
        ]);
    }

    /**
     * @Route("/contacts", name="contacts")
     */
    public function contactsAction(Request $request)
    {
        $this->getMenuItems();
        return $this->render('AppBundle:default:contacts.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'productLinks' => $this->productLinks,
            'pageTitle' => 'Контакты',
        ]);
    }

    /**
     * @Route("/sendMail", name="send_mail")
     */
    public function sendMailAction(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $theme = $request->get('theme');
        $message = $request->get('message');
        if ($name && $email) {
            $to      = 'admin@delta-x.ru';
//            $to      = 'winder84@mail.ru';
            $subject = 'Письмо с сайта delta-x.biz';
            $message = $name . "\r\n" . $email . "\r\n\r\n" . $theme . "\r\n\r\n" . $message;
            $headers = 'From: webmaster@delta-x.biz' . "\r\n" .
                'Reply-To: webmaster@delta-x.biz' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            $this->addFlash('notice', 'Ваше письмо отправлено. Спасибо за обращение!');
        }

        return $this->redirect('/contacts');
    }

    private function getProductCategories($products)
    {
        $productCategories = array();
        foreach ($products as $product) {
            if (!in_array($product->getCategory(), $productCategories)) {
                $productCategories[] = $product->getCategory();
            }
        }
        return $productCategories;
    }

    private function getMenuItems()
    {
        $em = $this->getDoctrine()->getManager();
        $allProducts = $em
            ->getRepository('AppBundle:Product')
            ->findAll();
        $this->productLinks = array();
        /** @var Product $product */
        foreach ($allProducts as $product) {
            if (!in_array($product->getProductLink(), $this->productLinks)) {
                $this->productLinks[] = $product->getProductLink();
            }
        }
    }
}
