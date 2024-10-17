<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AddEditFormType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    private  $authors = array( 

        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100), 
        
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ), 
        
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300), 
        
        ); 
    
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/list', name: 'app_author_list')]
    public function authorsList(AuthorRepository $authorRepository){
        $authorsDB = $authorRepository->findAll();
        return $this->render('author/list.html.twig',[
            'authors' => $authorsDB
        ]);
    }

    #[Route('/author/details/{id}', name: 'app_author_details')]
    public function authorDetails($id, AuthorRepository $authorRepository){
        $author = $authorRepository->findAuthorByUsernameDQL('Victor Hugo DB');
        //$author = $authorRepository->findOneByNbBooks(100);
        //$author=$this->authors[$id - 1];
        dd($author);
        return $this->render('author/details.html.twig',[
            'author' => $author
        ]);
    }

    #[Route('/author/add', name: 'app_author_add')]
    public function addAuthor(EntityManagerInterface $em){
        $author= new Author();
        $author->setUsername('Ali');
        $author->setEmail('ali@gmail.com');
        $author->setPicture('/images/Taha_Hussein.jpg');
        $author->setNbBooks(250);
        $em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('/author/new', name: 'app_author_new')]
    public function newAuthor(Request $request,EntityManagerInterface $em){
        $author= new Author();
        $form= $this->createForm(AddEditFormType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/form.html.twig',[
            'title' => 'Add Author',
            'form' => $form
        ]);
    }

    #[Route('/author/edit/{id}', name: 'app_author_edit')]
    public function editAuthor($id, Request $request, AuthorRepository $authorRepository, EntityManagerInterface $em){
        $author= $authorRepository->find($id);
        $form= $this->createForm(AddEditFormType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/form.html.twig',[
            'title' => 'Update Author',
            'form' => $form
        ]);
    }

    #[Route('/author/delete/{id}', name: 'app_author_delete')]
    public function deleteAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $em){
        $author= $authorRepository->find($id);
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_author_list');
        //return new Response('Author deleted');

    }

    #[Route('/author/update/{id}', name: 'app_author_update')]
    public function updateAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $em){
        $author= $authorRepository->find($id);
        $author->setEmail('email updated 222');
        //$em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('/author/{name}', name: 'app_author_name')]
    public function authorName($name){
        return $this->render('author/show.html.twig',[
            'name' => $name
        ]);
    }
}
