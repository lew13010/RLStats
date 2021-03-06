<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LineUp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Lineup controller.
 *
 */
class LineUpController extends Controller
{
    /**
     * Lists all lineUp entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lineUps = $em->getRepository('AppBundle:LineUp')->getAllWithPlayers();

        $count = count($lineUps);
        return $this->render('lineup/index.html.twig', array(
            'lineUps' => $lineUps,
            'count' => $count
        ));
    }

    /**
     * Creates a new lineUp entity.
     *
     */
    public function newAction(Request $request)
    {
        $lineUp = new Lineup();
        $form = $this->createForm('AppBundle\Form\LineUpType', $lineUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $lineUp->setUpdatedAt(new \DateTime());
            $em->persist($lineUp);
            $em->flush();

            return $this->redirectToRoute('lineup_index', array('id' => $lineUp->getId()));
        }

        return $this->render('lineup/new.html.twig', array(
            'lineUp' => $lineUp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lineUp entity.
     *
     */
    public function showAction(Request $request,LineUp $lineUp)
    {
        $deleteForm = $this->createDeleteForm($lineUp);

        $now = new \DateTime();
        $mois = $now->format('m');
        $annee = $now->format('Y');

        $tournois = $this->getDoctrine()->getRepository('AppBundle:Tournois')->getSearch($mois, $annee, $lineUp->getId(), false, false, false);

        $form = $this->createForm('AppBundle\Form\SearchTournoisType');
        $form->remove('lineUp');
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

            $tournois = $this->getDoctrine()->getRepository('AppBundle:Tournois')->getSearch($mois, $annee, $lineUp->getId(), $site, $categorie, $resultats);
        }

        return $this->render('lineup/show.html.twig', array(
            'lineUp' => $lineUp,
            'tournois' => $tournois,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lineUp entity.
     *
     */
    public function editAction(Request $request, LineUp $lineUp)
    {
        $tag = strtolower($lineUp->getTag());
        $username = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        if($tag != $username and false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Vous n\'avez pas la permission d\'accéder à cette page!');
        }
        $deleteForm = $this->createDeleteForm($lineUp);
        $editForm = $this->createForm('AppBundle\Form\LineUpType', $lineUp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $lineUp->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lineup_index', array('id' => $lineUp->getId()));
        }

        return $this->render('lineup/edit.html.twig', array(
            'lineUp' => $lineUp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lineUp entity.
     *
     */
    public function deleteAction(Request $request, LineUp $lineUp)
    {
        $form = $this->createDeleteForm($lineUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lineUp);
            $em->flush();
        }

        return $this->redirectToRoute('lineup_index');
    }

    /**
     * Creates a form to delete a lineUp entity.
     *
     * @param LineUp $lineUp The lineUp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LineUp $lineUp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lineup_delete', array('id' => $lineUp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
