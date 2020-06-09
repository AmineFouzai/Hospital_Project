<?php

namespace CalendrierMedecinsBundle\Controller;

use CalendrierMedecinsBundle\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Patient controller.
 *
 * @Route("patient")
 */
class PatientController extends Controller
{



   



    /**
     * Recherche all patient entities.
     *
     * @Route("/", name="patient_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $patient=new Patient();
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('CalendrierMedecinsBundle:Patient')->findAll();
        $form=$this->createForm('CalendrierMedecinsBundle\Form\RecherchePatientForm',$patient);
        $request=$this->get('request_stack')->getCurrentRequest();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $patients=$em->getRepository("CalendrierMedecinsBundle:Patient")->findBy(array('nom'=>$form->get('nom')->getData(),'prenom'=>$form->get('prenom')->getData()));
            

        }

        return $this->render('patient/patients.html.twig', array('form'=>$form->createView(),
            'patients' => $patients,
            'menu'=> 'patient',
        ));
    }


     /**
     * Lists all patient entities.
     *
     * @Route("/admin", name="patient_cons")
     * @Method("GET")
     */
    public function consulterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('CalendrierMedecinsBundle:Patient')->findAll();

        return $this->render('patient/crud.html.twig', array(
            'patients' => $patients,
             'menu'=> 'consulterpatient',
        ));
    }





    /**
     * Creates a new patient entity.
     *
     * @Route("/new", name="patient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm('CalendrierMedecinsBundle\Form\PatientType', $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('patient_show', array('id' => $patient->getId()));
        }

        return $this->render('patient/create.html.twig', array(
            'patient' => $patient,
            'form' => $form->createView(),
            'menu'=> 'addpatient',
        ));
    }

    /**
     * Finds and displays a patient entity.
     *
     * @Route("/{id}", name="patient_show")
     * @Method("GET")
     */
    public function showAction(Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);

        return $this->render('patient/read.html.twig', array(
            'patient' => $patient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing patient entity.
     *
     * @Route("/{id}/edit", name="patient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);
        $editForm = $this->createForm('CalendrierMedecinsBundle\Form\PatientType', $patient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_edit', array('id' => $patient->getId()));
        }

        return $this->render('patient/update.html.twig', array(
            'patient' => $patient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        
    }

    /**
     * Deletes a patient entity.
     *
     * @Route("/{id}", name="patient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Patient $patient)
    {
        $form = $this->createDeleteForm($patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute('patient_index');
    }








    /**
     * Creates a form to delete a patient entity.
     *
     * @param Patient $patient The patient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Patient $patient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patient_delete', array('id' => $patient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
