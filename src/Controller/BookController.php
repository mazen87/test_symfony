<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $bookFormAdd = $this->createForm(BookType::class, $book);
        $bookFormAdd->handleRequest($request);
        if ($bookFormAdd->isSubmitted() && $bookFormAdd->isValid()) {
            try {
                $em->persist($book);
                $em->flush();
                $this->addFlash('success', 'book has added successfully!');
                return $this->redirectToRoute('home');
            } catch (Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('book/add.html.twig', [
            'add_book_form' => $bookFormAdd->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="book_edit" ) 
     */
    public function editBook(Book $book, Request $request, EntityManagerInterface $em): Response
    {

        $bookEditForm = $this->createForm(BookType::class, $book);
        $bookEditForm->handleRequest($request);
        if ($bookEditForm->isSubmitted() && $bookEditForm->isValid()) {
            try {
                $em->persist($book);
                $em->flush();
                $this->addFlash('success', 'Book has edited successfully..');
                return $this->redirectToRoute('book_edit', ['id' => $book->getId()]);
            } catch (Exception $e) {
                $this->addFlash('danger', 'Error, editing book not accomplished !');
                return $this->redirectToRoute('book_edit', ['id' => $book->getId()]);
            }
        }
        return $this->render('book/edit.html.twig', [
            'edit_book_form' => $bookEditForm->createView(),
            'book' => $book
        ]);
    }

    /**
     * @Route("/all", name="book_all" ) 
     */
    public function allBook(Request $request, BookRepository $bookRepo, PaginatorInterface $paginator): Response
    {
        try {
            $donnees = $bookRepo->findAll();
            $books = $paginator->paginate($donnees, $request->query->getInt('page', 1), 4);
        } catch (Exception $e) {
            $this->addFlash('danger', 'Error when gettings all books !');
            return $this->redirectToRoute('home');
        }
        return $this->render('book/all.html.twig', [
            'books' => $books
        ]);
    }
    /**
     * @Route("/delete/{id}", name="book_delete" ) 
     */
    public function deleteBook(Book $book, EntityManagerInterface $em)
    {
        try {
            $em->remove($book);
            $em->flush();
            $this->addFlash('success', 'Book has deleted successfully !');
            return $this->redirectToRoute('book_all');
        } catch (Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('book_all');
        }
    }
}
