<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Joueur;
use AppBundle\Entity\Ranks;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Joueur controller.
 *
 */
class JoueurController extends Controller
{
    /**
     * Lists all joueur entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $joueurs = $em->getRepository('AppBundle:Joueur')->getAllWithRank();
        $update = $em->getRepository('AppBundle:Date')->findOneBy(array('id' => 1));

        $form = $this->createForm('AppBundle\Form\SearchJoueurType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rankMin = $form->getData()['rankMin'];
            $rankMax = $form->getData()['rankMax'];
            $categorie = $form->getData()['categorie'];
            $joueurs = $em->getRepository('AppBundle:Joueur')->getSearchWithRank($rankMin->getTierId(), $rankMax->getTierId(), $categorie->getId());
        }

        $count = count($joueurs);

        return $this->render('joueur/index.html.twig', array(
            'joueurs' => $joueurs,
            'form' => $form->createView(),
            'count' => $count,
            'update' => $update,
        ));
    }

    /**
     * Creates a new joueur entity.
     *
     */
    public function newAction(Request $request)
    {
        $joueur = new Joueur();
        $form = $this->createForm('AppBundle\Form\JoueurType', $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $api = $this->get('app.service.api')->getRanking($joueur->getUrl());
            if ($api) {
                $ranks = $api['json']['rankedSeasons'][7];
                $joueur->setSteamId($api['steamId']);

                $em->persist($joueur);

                for ($i = 10; $i <= 13; $i++) {
                    $typeId = ($i - 9);
                    $type = $em->getRepository('AppBundle:Type')->find($typeId);
                    $r = new Ranks();
                    $r->setJoueurs($joueur);
                    $r->setTypes($type);
                    if (isset($ranks[$i])) {
                        $tier = $em->getRepository('AppBundle:Tier')->find($ranks[$i]['tier'] + 1);
                        if ($ranks[$i]['tier'] > 0) {
                            $division = $em->getRepository('AppBundle:Division')->find($ranks[$i]['division'] + 2);
                        } else {
                            $division = $em->getRepository('AppBundle:Division')->find(1);
                        }
                        $rankPoints = $ranks[$i]['rankPoints'];
                        $rankPlayed = $ranks[$i]['matchesPlayed'];
                    } else {
                        $rankPoints = 100;
                        $rankPlayed = 0;
                        $tier = $em->getRepository('AppBundle:Tier')->find(1);
                        $division = $em->getRepository('AppBundle:Division')->find(1);
                    }
                    $r->setPoints($rankPoints);
                    $r->setNbMatch($rankPlayed);
                    $r->setTiers($tier);
                    $r->setDivisions($division);
                    $em->persist($r);
                    $em->flush();
                }

                $em->flush();

                return $this->redirectToRoute('joueur_index');
            } else {
                $this->addFlash('danger', 'Erreur sur l\'url du joueur');
            }
        }

        return $this->render('joueur/new.html.twig', array(
            'joueur' => $joueur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a joueur entity.
     *
     */
    public function showAction(Joueur $joueur)
    {
        $deleteForm = $this->createDeleteForm($joueur);

        return $this->render('joueur/show.html.twig', array(
            'joueur' => $joueur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing joueur entity.
     *
     */
    public function editAction(Request $request, Joueur $joueur)
    {
        $deleteForm = $this->createDeleteForm($joueur);
        $editForm = $this->createForm('AppBundle\Form\JoueurType', $joueur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $api = $this->get('app.service.api')->getRanking($joueur->getUrl());
            if ($api) {
                $ranks = $api['json']['rankedSeasons'][7];
                $joueur->setSteamId($api['steamId']);

                $em->persist($joueur);

                for ($i = 10; $i <= 13; $i++) {
                    $typeId = ($i - 9);
                    $type = $em->getRepository('AppBundle:Type')->find($typeId);
                    $r = $em->getRepository('AppBundle:Ranks')->findOneBy(array('joueurs' => $joueur, 'types' => $type));
                    if (isset($ranks[$i])) {
                        $tier = $em->getRepository('AppBundle:Tier')->find($ranks[$i]['tier'] + 1);
                        if ($ranks[$i]['tier'] > 0) {
                            $division = $em->getRepository('AppBundle:Division')->find($ranks[$i]['division'] + 2);
                        } else {
                            $division = $em->getRepository('AppBundle:Division')->find(1);
                        }
                        $rankPoints = $ranks[$i]['rankPoints'];
                        $rankPlayed = $ranks[$i]['matchesPlayed'];
                    } else {
                        $rankPoints = 100;
                        $rankPlayed = 0;
                        $tier = $em->getRepository('AppBundle:Tier')->find(1);
                        $division = $em->getRepository('AppBundle:Division')->find(1);
                    }
                    $r->setPoints($rankPoints);
                    $r->setNbMatch($rankPlayed);
                    $r->setTiers($tier);
                    $r->setDivisions($division);
                    $em->persist($r);
                    $em->flush();
                }
            } else {
                $this->addFlash('danger', 'Erreur sur l\'url du joueur');
            }


            $em->flush();

            return $this->redirectToRoute('joueur_index');
        }

        return $this->render('joueur/edit.html.twig', array(
            'joueur' => $joueur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a joueur entity.
     *
     */
    public
    function deleteAction(Request $request, Joueur $joueur)
    {
        $form = $this->createDeleteForm($joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($joueur);
            $em->flush();
        }

        return $this->redirectToRoute('joueur_index');
    }

    /**
     * Creates a form to delete a joueur entity.
     *
     * @param Joueur $joueur The joueur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createDeleteForm(Joueur $joueur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('joueur_delete', array('id' => $joueur->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
