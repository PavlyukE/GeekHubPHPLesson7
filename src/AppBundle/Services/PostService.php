<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class PostService
{
    /**
     * @return array[] of posts;
     */
    public function getPosts()
    {
        $data = file_get_contents(__DIR__.'/../Resources/posts.json');
        $posts = json_decode($data, true);

        return $posts;
    }
    /**
     * @param int $id;
     *
     * @return object post;
     */
    public function getPostById($id)
    {
        $posts = $this->getPosts();
        foreach ($posts as $post) {
            if ($post['id'] == $id) {
                return $post;
            }
        }
    }
    /**
     * @param int $id;
     */
    public function deletePost($id)
    {
        $posts = $this->getPosts();
        foreach ($posts as $key => $value) {
            if (in_array($id, $value)) {
                unset($posts[$key]);
            }
        }
        file_put_contents(__DIR__.'/../Resources/posts.json', json_encode($posts));
    }
    /**
     * @param int $id;
     *
     * @return JsonResponse;
     */
    public function editPost($id)
    {
        $post = $this->getPostById($id);
        $post['title'] = 'Edited title';

        return $post;
    }

    /**
     * @param int $id;
     *
     * @return JsonResponse;
     */
    public function changePost($id)
    {
        $post['id'] = $id;
        $post['title'] = 'New title';

        return $post;
    }
}
