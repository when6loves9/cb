<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;

use AppBundle\Entity\Codes;
use AppBundle\Entity\Campaign;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('AppBundle:User:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        $redeemCodeForm= $this->createRedeemCodeForm($id);

        return $this->render('AppBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'redeemCodeForm'=>$redeemCodeForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
   /* 
   *Creates a redeem code Form 
   *
   * @param Codes $id The entity id

   *@return \Symfony\Component\Form\Form The form
    */
      private function createRedeemCodeForm($id)
    {
  
          
      return $this->createFormBuilder()
           ->setAction($this->generateUrl('user_redeemCheck', array('id' => $id)))
            ->setMethod('GET')
          ->add('coode','integer')
          ->add('submit', 'submit', array('label' => 'Redeem Code'))
                ->getForm();
        $form->handleRequest($request);
          
                                         
    }
    
     public function redeemCheckAction(Request $request,$id)
     {
       
        $em = $this->getDoctrine()->getManager();
$entity = $em->getRepository('AppBundle:Codes')->findOneByCode($request->query->get('form[coode]',null,true));
       /*check if the code exists in the db*/
         if (!$entity) {
            throw $this->createNotFoundException('Unable to find Code entity.');
         
         }
         /*check if the code has already been used*/

         if($entity->getUsed()==1){
         throw $this->createNotFoundException('The  Code has already been used!!');
         }
         /*check if the code's campaign expired*/
         $campentity = $em->getRepository('AppBundle:Campaign')->findOneById( $entity->getCampaign_id());
         
         if (!$campentity) {
            throw $this->createNotFoundException('Unable to find Campaign entity.');
         
     }
/*check if the the redeem code date is valid*/
         $time =new \DateTime();
         if($campentity->getEnd_date() > $time){
             throw $this->createNotFoundException('Campaign expired.');
         }
         else{
             /*first of all update db so the code could not be used again*/
         $entity->setUsed('1');
             
         $em->flush();
    /* update private_projects_users table with the gift! 2 allowed free private projects for 1 year duration! we will use createNewPlanAction to give it to the user
    */         
            /* $privateproj= $em->getRepository('AppBundle:PrivateProjectsPlan');
            $privateproj->setNumberAllowed('2');*/
             
         }
        return $entity->getId();
     }
         
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    //private function redeemCode(
}
