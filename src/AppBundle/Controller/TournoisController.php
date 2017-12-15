<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tournois;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Tournois controller.
 *
 */
class TournoisController extends Controller
{
    /**
     * Lists all tournois entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tournois = $em->getRepository('AppBundle:Tournois')->findBy([], array('dateTournois' => 'desc'));

        return $this->render('tournois/index.html.twig', array(
            'tournois' => $tournois,
        ));
    }

    /**
     * Creates a new tournois entity.
     *
     */
    public function newAction(Request $request)
    {
        $tournois = new Tournois();
        $form = $this->createForm('AppBundle\Form\TournoisType', $tournois);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournois);
            $em->flush();

            return $this->redirectToRoute('site_index');
        }

        return $this->render('tournois/new.html.twig', array(
            'tournois' => $tournois,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tournois entity.
     *
     */
    public function showAction(Tournois $tournois)
    {
        $deleteForm = $this->createDeleteForm($tournois);

        return $this->render('tournois/show.html.twig', array(
            'tournois' => $tournois,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tournois entity.
     *
     */
    public function editAction(Request $request, Tournois $tournois)
    {
        $tag = strtolower($tournois->getLineUps()->getTag());
        $username = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        if($tag != $username and false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Vous n\'avez pas la permission d\'accéder à cette page!');
        }
        $deleteForm = $this->createDeleteForm($tournois);
        $editForm = $this->createForm('AppBundle\Form\TournoisType', $tournois);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tournois_edit', array('id' => $tournois->getId()));
        }

        return $this->render('tournois/edit.html.twig', array(
            'tournois' => $tournois,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tournois entity.
     *
     */
    public function deleteAction(Request $request, Tournois $tournois)
    {
        $form = $this->createDeleteForm($tournois);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tournois);
            $em->flush();
        }

        return $this->redirectToRoute('site_index');
    }

    /**
     * Creates a form to delete a tournois entity.
     *
     * @param Tournois $tournois The tournois entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tournois $tournois)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tournois_delete', array('id' => $tournois->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
