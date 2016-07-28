<?php

// src/OC/CoreBundle/Controller/PageController.php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OC\CoreBundle\Entity\Page;
use OC\CoreBundle\Form\PageType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PageController extends Controller
{
  public function indexAction()
  {


    $listPages = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCCoreBundle:Page')
      ->getPages();

    // On donne toutes les informations nécessaires à la vue
    return $this->render('OCCoreBundle:Admin:index.html.twig', array(
      'listPages' => $listPages,
    ));
  }

  public function viewAction(Page $page)
  {
    $em = $this ->getDoctrine()
    ->getManager();

    return $this->render('OCCoreBundle::page.html.twig', array(
      'page'           => $page,
    ));

  }

  public function addAction(Request $request)
  {
    $page = new Page();
    $form   = $this->get('form.factory')->create(PageType::class, $page);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($page);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirectToRoute('oc_core_view', array('slug' => $page->getSlug()));
    }

    return $this->render('OCCoreBundle:Admin:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function editAction(Page $page, Request $request)
  {
    

    if (null === $page) {
      throw new NotFoundHttpException("La page  ".$page.title ." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(PageType::class, $page);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('oc_core_homepage', array('slug' => $page->getSlug()));
    }

    return $this->render('OCCoreBundle:Admin:add.html.twig', array(
      'page' => $page,
      'form'   => $form->createView(),
    ));
  }



  public function deleteAction(Request $request, Page $page)
  {
    $em = $this->getDoctrine()->getManager();

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($page);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "La page a bien été supprimée.");

      return $this->redirectToRoute('oc_core_homepage');
    }
    
    return $this->render('OCCoreBundle:Admin:delete.html.twig', array(
      'page' => $page,
      'form'   => $form->createView(),
    ));
  }

  public function menuAction()
  {
    
  }
}