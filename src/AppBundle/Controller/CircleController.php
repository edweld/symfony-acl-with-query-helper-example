<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Circle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Finder\Exception\AccessDeniedException;

/**
 * Circle controller.
 *
 * @Route("circle")
 */
class CircleController extends Controller
{
    /**
     * Lists all circle entities.
     *
     * @Route("/", name="circle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $circles = $em->getRepository('AppBundle:Circle')->findAllWithAcl($this->getUser());

        return $this->render('circle/index.html.twig', array(
            'circles' => $circles,
        ));
    }

    /**
     * Creates a new circle entity.
     *
     * @Route("/new", name="circle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $circle = new Circle();
        $form = $this->createForm('AppBundle\Form\CircleType', $circle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($circle);
            $em->flush();

            return $this->redirectToRoute('circle_show', array('id' => $circle->getId()));
        }

        return $this->render('circle/new.html.twig', array(
            'circle' => $circle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a circle entity.
     *
     * @Route("/{id}", name="circle_show")
     * @Method("GET")
     */
    public function showAction(Circle $circle)
    {
        if(false === $this->get('app.acl')->isAllowed('view', $circle))
        {
            throw new AccessDeniedException();
        }  
        $deleteForm = $this->createDeleteForm($circle);

        return $this->render('circle/show.html.twig', array(
            'circle' => $circle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing circle entity.
     *
     * @Route("/{id}/edit", name="circle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Circle $circle)
    {
        if(false === $this->get('app.acl')->isAllowed('edit', $circle))
        {
            throw new AccessDeniedException();
        }  
        $deleteForm = $this->createDeleteForm($circle);
        $editForm = $this->createForm('AppBundle\Form\CircleType', $circle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('circle_edit', array('id' => $circle->getId()));
        }

        return $this->render('circle/edit.html.twig', array(
            'circle' => $circle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a circle entity.
     *
     * @Route("/{id}", name="circle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Circle $circle)
    {
        if(false === $this->get('app.acl')->isAllowed('delete', $circle))
        {
            throw new AccessDeniedException();
        }  
        $form = $this->createDeleteForm($circle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($circle);
            $em->flush();
        }

        return $this->redirectToRoute('circle_index');
    }

    /**
     * Creates a form to delete a circle entity.
     *
     * @param Circle $circle The circle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Circle $circle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('circle_delete', array('id' => $circle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
     /**
     *
     * @Route("/{id}/adduser/{userId}", name="circle_add_user")
     * @Method("GET")
     */
    public function addUser(Circle $circle, $userId )
    {
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->findOneById($userId);
        $circle->addUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($circle);
        $em->flush();
        $this->get('app.acl')->addAclUserToCircle($user, $circle);  
        return new JsonResponse('ok');
    }
}
