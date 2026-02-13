<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/comment')]
#[IsGranted('ROLE_USER')]
class CommentController extends AbstractController
{
    #[Route('/add/{id}', name: 'app_comment_add', methods: ['POST'])]
    public function addComment(
        Post $post,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setPost($post);
            $comment->setStatus(Comment::STATUS_APPROVED); // Auto-approve for now

            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Comment added successfully!');
        }

        return $this->redirectToRoute('app_post_detail', ['id' => $post->getId()]);
    }

    #[Route('/delete/{id}', name: 'app_comment_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteComment(
        Comment $comment,
        EntityManagerInterface $em
    ): Response {
        $postId = $comment->getPost()->getId();
        
        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', 'Comment deleted!');
        return $this->redirectToRoute('app_post_detail', ['id' => $postId]);
    }
}
