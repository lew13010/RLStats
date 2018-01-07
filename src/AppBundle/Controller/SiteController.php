<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Site controller.
 *
 */
class SiteController extends Controller
{
    /**
     * Lists all site entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $now = new \DateTime();
        $mois = $now->format('m');
        $annee = $now->format('Y');

        $tournois = $em->getRepository('AppBundle:Tournois')->getSearch($mois, $annee, false, false, false, false);

        $form = $this->createForm('AppBundle\Form\SearchTournoisType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->getData()['mois'] != null){
                $mois = $form->getData()['mois'];
            }else{
                $mois = false;
            }
            if($form->getData()['annee'] != null){
                $annee = $form->getData()['annee'];
            }else{
                $annee = false;
            }
            if($form->getData()['lineUp'] != null){
                $lineUp = $form->getData()['lineUp']->getId();
            }else{
                $lineUp = false;
            }
            if($form->getData()['site'] != null){
                $site = $form->getData()['site']->getId();
            }else{
                $site = false;
            }
            if($form->getData()['categorie'] != null){
                $categorie = $form->getData()['categorie']->getId();
            }else{
                $categorie = false;
            }
            if($form->getData()['resultats'] != null){
                $resultats = $form->getData()['resultats']->getId();
            }else{
                $resultats = false;
            }

            $tournois = $em->getRepository('AppBundle:Tournois')->getSearch($mois, $annee, $lineUp, $site, $categorie, $resultats);
        }

        return $this->render('site/index.html.twig', array(
            'sites' => $tournois,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a site entity.
     *
     */
    public function showAction(Request $request,Site $site)
    {
        $em = $this->getDoctrine()->getManager();

        $now = new \DateTime();
        $mois = $now->format('m');
        $annee = $now->format('Y');

        $tournois = $em->getRepository('AppBundle:Tournois')->getSearch($mois, $annee, false, $site->getId(), false, false);
        $form = $this->createForm('AppBundle\Form\SearchTournoisType');
        $form->remove('site');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->getData()['mois'] != null){
                $mois = $form->getData()['mois'];
            }else{
                $mois = false;
            }
            if($form->getData()['annee'] != null){
                $annee = $form->getData()['annee'];
            }else{
                $annee = false;
            }
            if($form->getData()['lineUp'] != null){
                $lineUp = $form->getData()['lineUp']->getId();
            }else{
                $lineUp = false;
            }
            if($form->getData()['categorie'] != null){
                $categorie = $form->getData()['categorie']->getId();
            }else{
                $categorie = false;
            }
            if($form->getData()['resultats'] != null){
                $resultats = $form->getData()['resultats']->getId();
            }else{
                $resultats = false;
            }

            $tournois = $em->getRepository('AppBundle:Tournois')->getSearch($mois, $annee, $lineUp, $site->getId(), $categorie, $resultats);
        }

        return $this->render('site/show.html.twig', array(
            'site' => $site,
            'form' => $form->createView(),
            'tournoiss' => $tournois,
        ));
    }
}
