<?php

// src/OC/CoreBundle/Controller/PageController.php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OC\CoreBundle\Entity\Page;
use OC\CoreBundle\Entity\Version;
use OC\CoreBundle\Form\PageType;
use OC\CoreBundle\Form\PageNewCategoryType;
use OC\CoreBundle\Form\PageEditType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PageController extends Controller
{

  public function homeAction() {
    return $this->render('OCCoreBundle::home.html.twig');
  }
  
  public function indexAction()
  {


    $em = $this->getDoctrine()->getManager();

    $listCats = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCCoreBundle:Category')
      ->getCats();

    $listPages = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCCoreBundle:Page')
      ->getPages();



    return $this->render('OCCoreBundle:Admin:index.html.twig', array(
    'listPages' => $listPages,
    'listCats' => $listCats,
    )); 
  }


  public function viewAction($slug)
  {

    $em = $this->getDoctrine()->getManager()->getRepository('OCCoreBundle:Page');
        
    $page = $em->findOneBySlug($slug);
        if(is_null($page))
            throw new NotFoundHttpException('This page doesn\'t exist');
    

    switch($page->getRoleaccess()) {
      case 'Anonymous':
        return $this->render('OCCoreBundle::page.html.twig', array(
        'page'           => $page,
        ));
      break;

      case 'ROLE_ADMIN':
        if ($this->getUser() !== null) {
          if (in_array('ROLE_ADMIN', $role=$this->getUser()->getRoles())) {
            return $this->render('OCCoreBundle::page.html.twig', array(
            'page'           => $page,
            ));
          }
        }
        else {
          throw new AccessDeniedException('It looks like you can\t acces this page... ');
          return $this->redirectToRoute('fos_user_security_login');
        }
      case 'ROLE_USER':
        if ($this->getUser() !== null) {
          if (in_array('ROLE_USER', $role=$this->getUser()->getRoles()) || in_array('ROLE_ADMIN', $role=$this->getUser()->getRoles())) {
            return $this->render('OCCoreBundle::page.html.twig', array(
            'page'           => $page,
            ));
          }
        }
        else {
          throw new AccessDeniedException('It looks like you can\t acces this page... ');

          return $this->redirectToRoute('fos_user_security_login');
        }

    }

    /*if ($page->getRoleaccess() == 'anonymous' or in_array($page->getRoleaccess(), $roles)) */

    return $this->render('OCCoreBundle::page.html.twig', array(
      'page'           => $page,
    ));

  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   *
   */
  public function addAction(Request $request)
  {
    $page = new Page();
    $form   = $this->get('form.factory')->create(PageType::class, $page);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      if ($page->getRoleaccess() == '' && $this->container->getParameter('default_access') == true) {
        $page->setRoleaccess($this->container->getParameter('default_access_value'));
      }
      $em = $this->getDoctrine()->getManager();
      $em->persist($page);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirectToRoute('oc_core_view', array('slug' => $page->getSlug(), 'category' =>$page->getCategory()));
    }


    return $this->render('OCCoreBundle:Admin:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     *
     */
    public function addNewCatAction(Request $request)
  {
    $page = new Page();
    $form   = $this->get('form.factory')->create(PageNewCategoryType::class, $page);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

      if ($page->getRoleaccess() == '' && $this->container->getParameter('default_access') == true) {
        $page->setRoleaccess($this->container->getParameter('default_access_value'));
      }

      $em = $this->getDoctrine()->getManager();
      $em->persist($page);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirectToRoute('oc_core_view', array('slug' => $page->getSlug(), 'category' =>$page->getCategory()));
    }


    return $this->render('OCCoreBundle:Admin:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   *
   */
  public function editAction(Page $page, Request $request)
  {

    if (null === $page) {
      throw new NotFoundHttpException("La page  ".$page.title ." n'existe pas.");
    }

    $em = $this->getDoctrine()->getManager(); 


    if($this->container->getParameter('versionning')) {
         
      $version = new Version();
      $version->setTitle($page->getTitle());
      $version->setContent($page->getContent());
      $version->setCategory($page->getCategory());
      $version->setPage($page); 
    }



    $form = $this->get('form.factory')->create(PageEditType::class, $page);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      if (isset($version)) {
        $em->persist($version); 
      }

      if ($page->getRoleaccess() == '' && $this->container->getParameter('default_access') == true) {
        $page->setRoleaccess($this->container->getParameter('default_access_value'));
      }
      
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('oc_core_homepage', array('slug' => $page->getSlug()));
    }

    return $this->render('OCCoreBundle:Admin:add.html.twig', array(
      'page' => $page,
      'form'   => $form->createView(), 
    )); 
  }


  /**
   * @Security("has_role('ROLE_ADMIN')")
   *
   */
  public function deleteAction(Request $request, Page $page)
  {
    $em = $this->getDoctrine()->getManager();

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      
      $versions = $em->getRepository('OCCoreBundle:Version')->findBy(array('page' => $page->getId()));
      foreach ($versions as $version) {
            $em->remove($version);
        }
      $em->remove($page);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "La page a bien été supprimée.");

      return $this->redirectToRoute('oc_core_homepage');
    }
    
    return $this->render('OCCoreBundle:Admin:delete.html.twig', array(
      'page' => $page,
      'form' => $form->createView(),
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   *
   */
  public function versionsAction(Page $page)
  {
    $em = $this->getDoctrine()->getManager();
    $versions = $em->getRepository('OCCoreBundle:Version')->findBy(array('page' => $page->getId()));

    return $this->render('OCCoreBundle:Admin:versions.html.twig', array(
      'page' => $page,
      'versions' => $versions,
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   *
   */
  public function versionAction($id)
  {
    $em = $this ->getDoctrine()
    ->getManager();

    $version = $em->getRepository('OCCoreBundle:Version')->find($id);

    return $this->render('OCCoreBundle::page.html.twig', array(
      'page'           => $version,
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   *
   */
  public function replaceAction(Version $version)
  {
    $em = $this ->getDoctrine()
    ->getManager();

    $page = $em->getRepository('OCCoreBundle:Page')->find($version->getPage());


    $page->setTitle($version->getTitle());
    $page->setContent($version->getContent());

    $newVersions = $em->getRepository('OCCoreBundle:Version')->getNewVersions($version->getDate());
    foreach ($newVersions as $newVersion) {
      $em->remove($newVersion);
    }

    $em->remove($version);
    $em->flush(); 

    return $this->render('OCCoreBundle::page.html.twig', array(
      'page'           => $version,
    ));
  }

}