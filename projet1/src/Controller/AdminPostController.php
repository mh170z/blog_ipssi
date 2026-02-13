<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/post')]
#[IsGranted('ROLE_ADMIN')]
class AdminPostController extends AbstractController
{
    #[Route('', name: 'app_admin_post_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $posts = $em->getRepository(Post::class)->findBy([], ['publishedAt' => 'DESC']);
        
        return $this->render('admin/post/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/new', name: 'app_admin_post_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($this->getUser());
            $post->setPublishedAt(new \DateTimeImmutable());
            
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post created successfully!');
            return $this->redirectToRoute('app_admin_post_list');
        }

        return $this->render('admin/post/form.html.twig', [
            'form' => $form,
            'title' => 'Create Post',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_post_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Post updated successfully!');
            return $this->redirectToRoute('app_admin_post_list');
        }

        return $this->render('admin/post/form.html.twig', [
            'form' => $form,
            'post' => $post,
            'title' => 'Edit Post',
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_post_delete', methods: ['POST'])]
    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post deleted!');
        return $this->redirectToRoute('app_admin_post_list');
    }

    #[Route('/category', name: 'app_admin_category_list')]
    public function categoryList(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        
        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
}
