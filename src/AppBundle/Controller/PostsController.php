<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\PostService;

class PostsController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new PostService();
    }
    /**
     * @Route("/posts/")
     * @Method ("GET")
     *
     * @return JsonResponse;
     */
    public function allAction()
    {
        $posts = $this->service->getPosts();

        return new JsonResponse(array('posts' => $posts));
    }

    /**
     * @Route("/posts/{id}", name="post_detail", requirements={"id": "\d+"})
     * @Method ("POST")
     *
     * @param int $id;
     *
     * @return JsonResponse;
     */
    public function detailsAction($id)
    {
        $posts = $this->service->getPosts();
        foreach ($posts as $post) {
            if ($post['id'] == $id) {
                return new JsonResponse($post);
            }
        }
        throw $this->createNotFoundException('Post not found!');
    }
    /**
     * @Route("/posts/{id}", name="post_delete", requirements={"id": "\d+"})
     * @Method ("DELETE")
     *
     * @param int $id;
     *
     * @return void;
     */
    public function deleteAction($id)
    {
        $this->service->deletePost($id);
        $this->forward('AppBundle:Posts:all');
    }

    /**
     * @Route("/posts/{id}", name="post_edit", requirements={"id": "\d+"})
     * @Method ("PATCH")
     *
     * @param int $id;
     *
     * @return JsonResponse;
     */
    public function editAction($id)
    {
        $post = $this->service->editPost($id);

        return new JsonResponse($post);
    }

    /**
     * @Route("/posts/{id}", name="post_change", requirements={"id": "\d+"})
     * @Method ("PUT")
     *
     * @param int $id;
     *
     * @return JsonResponse $post;
     */
    public function changeAction($id)
    {
        $post = $this->service->changePost($id);

        return new JsonResponse($post);
    }
}
