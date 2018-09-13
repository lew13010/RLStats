<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Joueur;
use AppBundle\Entity\Ranks;
use DiDom\Document;
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
            if ($categorie == null) {
                $joueurs = $em->getRepository('AppBundle:Joueur')->getSearchWithRankWithoutCat($rankMin->getTierId(), $rankMax->getTierId());
            } else {
                $joueurs = $em->getRepository('AppBundle:Joueur')->getSearchWithRank($rankMin->getTierId(), $rankMax->getTierId(), $categorie->getId());
            }
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
            $id = $this->get('app.service.api')->getSteam($joueur->getUrl());
            if ($id) {
                $joueur->setSteamId($id);
                for ($i = 10; $i <= 13; $i++) {
                    $typeId = ($i - 9);
                    $type = $em->getRepository('AppBundle:Type')->find($typeId);
                    $tier = $em->getRepository('AppBundle:Tier')->findOneBy(array('id' => 1));
                    $div = $em->getRepository('AppBundle:Division')->findOneBy(array('id' => 1));

                    $r = new Ranks();
                    $r->setJoueurs($joueur);
                    $r->setTypes($type);
                    $r->setTiers($tier);
                    $r->setDivisions($div);
                    $r->setPoints(0);
                    $r->setNbMatch(0);

                    $em->persist($r);
                }
                $em->flush();
                try{
                    $this->get('app.service.api')->autoUpdate($joueur);
                }catch (\Exception $exception){
                    $this->addFlash('danger', 'Erreur sur l\'url du joueur');
                    return $this->redirectToRoute('joueur_edit', array('id' => $joueur->getId()));
                }
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
    public
    function showAction(Joueur $joueur)
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
    public
    function editAction(Request $request, Joueur $joueur)
    {
        $deleteForm = $this->createDeleteForm($joueur);
        $editForm = $this->createForm('AppBundle\Form\JoueurType', $joueur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $id = $this->get('app.service.api')->getSteam($joueur->getUrl());
            if ($id) {
                $joueur->setSteamId($id);
                $em->flush();

                try{
                    $this->get('app.service.api')->autoUpdate($joueur);
                }catch (\Exception $exception){
                    $this->addFlash('danger', 'Erreur sur l\'url du joueur');
                    return $this->redirectToRoute('joueur_edit', array('id' => $joueur->getId()));
                }

                return $this->redirectToRoute('joueur_index');

            } else {
                $this->addFlash('danger', 'Erreur sur l\'url du joueur');
            }
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
