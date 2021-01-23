<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Task;

class ToDoListController extends AbstractController
{
    /**
     * @Route("", name="to_do_list")
     */
    public function index()
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([],['id'=>'DESC']);
        
        return $this->render('index.html.twig',['tasks'=>$tasks]);
    }


    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(Request $request)
    {
        // exit($request->request->get('title'));
        $title = trim($request->request->get('title'));
        if(empty($title))
        return $this->redirectToRoute('to_do_list');

        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task;

        $task->setTitle($title);

        $entityManager->persist($task);

        $entityManager->flush();

        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("/switch-status{id}", name="switch_status")
     */
    public function switchStaus($id)
    {
        // exit('To Do: Switch status of the task '.$id);
       
        $entityManager = $this->getDoctrine()->getManager();
        
        $task = $entityManager->getRepository(Task::class)->find($id);
        
        $task->setStatus(!$task->getStatus());
        
        $entityManager->flush();
        
        return $this->redirectToRoute('to_do_list');
    }

     /**
     * @Route("/delete/{id}", name="delete_task")
     */
    public function delete(Task $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->remove($ids);
        
        $entityManager->flush();
        
        return $this->redirectToRoute('to_do_list');
    }
}
