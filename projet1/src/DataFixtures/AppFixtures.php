<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Create admin user
        $admin = new User();
        $admin->setEmail('admin@blog.com')
            ->setFirstName('Admin')
            ->setLastName('User')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'))
            ->setIsActive(true);
        $manager->persist($admin);

        // Create regular users
        $user1 = new User();
        $user1->setEmail('user1@blog.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($user1, 'user123'))
            ->setIsActive(true);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@blog.com')
            ->setFirstName('Jane')
            ->setLastName('Smith')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($user2, 'user123'))
            ->setIsActive(true);
        $manager->persist($user2);

        // Create categories
        $categories = [];
        $categoryNames = ['Technology', 'Design', 'Business', 'Lifestyle', 'Tutorial'];
        
        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name)
                ->setDescription('Posts related to ' . $name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Symfony',
                'content' => 'Symfony is a powerful PHP framework for building web applications. In this article, we\'ll explore the basics of Symfony and how to set up your first project. Learn about routing, controllers, templates, and more!',
                'category' => $categories[0],
                'author' => $admin,
            ],
            [
                'title' => 'Web Design Best Practices',
                'content' => 'Good web design is crucial for user experience. In this comprehensive guide, we\'ll discuss responsive design, color theory, typography, and user interface principles that create engaging web experiences.',
                'category' => $categories[1],
                'author' => $user1,
            ],
            [
                'title' => 'Building a Successful Startup',
                'content' => 'Starting a business is exciting but challenging. We\'ll walk through the essential steps of launching a startup, from idea validation and business planning to fundraising and team building.',
                'category' => $categories[2],
                'author' => $user2,
            ],
            [
                'title' => 'Healthy Living Tips',
                'content' => 'Maintaining a healthy lifestyle doesn\'t have to be complicated. In this article, we share simple yet effective tips for nutrition, exercise, sleep, and mental health that will transform your daily routine.',
                'category' => $categories[4],
                'author' => $admin,
            ],
            [
                'title' => 'PHP Security Best Practices',
                'content' => 'Security is paramount in web development. Learn about common vulnerabilities like SQL injection, XSS, CSRF, and how to protect your PHP applications. We\'ll cover secure coding practices and industry standards.',
                'category' => $categories[0],
                'author' => $user1,
            ],
        ];

        foreach ($posts as $postData) {
            $post = new Post();
            $post->setTitle($postData['title'])
                ->setContent($postData['content'])
                ->setCategory($postData['category'])
                ->setAuthor($postData['author'])
                ->setPublishedAt(new \DateTimeImmutable())
                ->setPicture('https://via.placeholder.com/600x400?text=' . urlencode($postData['title']));
            $manager->persist($post);

            // Add comments to posts
            for ($i = 0; $i < rand(2, 5); $i++) {
                $comment = new Comment();
                $comment->setContent('Great article! Really helpful and informative. Thanks for sharing.')
                    ->setAuthor($user1->getId() === ($i % 2) ? $user2 : $user1)
                    ->setPost($post)
                    ->setStatus(Comment::STATUS_APPROVED)
                    ->setCreatedAt(new \DateTimeImmutable('- ' . $i . ' day'));
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
