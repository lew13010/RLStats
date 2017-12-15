<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fonction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fonction controller.
 *
 */
class FonctionController extends Controller
{
    /**
     * Lists all fonction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fonctions = $em->getRepository('AppBundle:Fonction')->findBy([], array('name' => 'ASC'));

        return $this->render('fonction/index.html.twig', array(
            'fonctions' => $fonctions,
        ));
    }

    /**
     * Creates a new fonction entity.
     *
     */
    public function newAction(Request $request)
    {
        $fonction = new Fonction();
        $form = $this->createForm('AppBundle\Form\FonctionType', $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fonction);
            $em->flush();

            return $this->redirectToRoute('fonction_show', array('id' => $fonction->getId()));
        }

        return $this->render('fonction/new.html.twig', array(
            'fonction' => $fonction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fonction entity.
     *
     */
    public function editAction(Request $request, Fonction $fonction)
    {
        $deleteForm = $this->createDeleteForm($fonction);
        $editForm = $this->createForm('AppBundle\Form\FonctionType', $fonction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fonction_edit', array('id' => $fonction->getId()));
        }

        return $this->render('fonction/edit.html.twig', array(
            'fonction' => $fonction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fonction entity.
     *
     */
    public function deleteAction(Request $request, Fonction $fonction)
    {
        $form = $this->createDeleteForm($fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fonction);
            $em->flush();
        }

        return $this->redirectToRoute('fonction_index');
    }

    /**
     * Creates a form to delete a fonction entity.
     *
     * @param Fonction $fonction The fonction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fonction $fonction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fonction_delete', array('id' => $fonction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
