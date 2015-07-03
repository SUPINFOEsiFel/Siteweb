<?php

namespace FEL\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FEL\AdminBundle\Entity\OpeContact;
use FEL\AdminBundle\Form\OpeContactType;

/**
 * OpeContact controller.
 *
 * @Route("/opecontact")
 */
class OpeContactController extends Controller
{

    /**
     * Lists all OpeContact entities.
     *
     * @Route("/", name="opecontact")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FELAdminBundle:OpeContact')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new OpeContact entity.
     *
     * @Route("/", name="opecontact_create")
     * @Method("POST")
     * @Template("FELAdminBundle:OpeContact:new.html.twig")
     * @Security("is_granted('ROLE_FULL_OPC_ACCESS')")
     */
    public function createAction(Request $request)
    {
        $entity = new OpeContact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('opecontact_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a OpeContact entity.
     *
     * @param OpeContact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OpeContact $entity)
    {
        $form = $this->createForm(new OpeContactType(), $entity, array(
            'action' => $this->generateUrl('opecontact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new OpeContact entity.
     *
     * @Route("/new", name="opecontact_new")
     * @Method("GET")
     * @Template()
     * @Security("is_granted('ROLE_FULL_OPC_ACCESS')")
     */
    public function newAction()
    {
        $entity = new OpeContact();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a OpeContact entity.
     *
     * @Route("/{id}", name="opecontact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FELAdminBundle:OpeContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpeContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OpeContact entity.
     *
     * @Route("/{id}/edit", name="opecontact_edit")
     * @Method("GET")
     * @Template()
     * @Security("is_granted('ROLE_FULL_OPC_ACCESS')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FELAdminBundle:OpeContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpeContact entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a OpeContact entity.
    *
    * @param OpeContact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OpeContact $entity)
    {
        $form = $this->createForm(new OpeContactType(), $entity, array(
            'action' => $this->generateUrl('opecontact_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing OpeContact entity.
     *
     * @Route("/{id}", name="opecontact_update")
     * @Method("PUT")
     * @Template("FELAdminBundle:OpeContact:edit.html.twig")
     * @Security("is_granted('ROLE_FULL_OPC_ACCESS')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FELAdminBundle:OpeContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpeContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('opecontact_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a OpeContact entity.
     *
     * @Route("/{id}", name="opecontact_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_FULL_OPC_ACCESS')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FELAdminBundle:OpeContact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OpeContact entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('opecontact'));
    }

    /**
     * Creates a form to delete a OpeContact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('opecontact_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
