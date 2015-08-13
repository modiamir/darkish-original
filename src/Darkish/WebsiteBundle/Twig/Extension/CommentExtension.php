<?php

namespace Darkish\WebsiteBundle\Twig\Extension;

use Darkish\CommentBundle\Entity\Comment;
use Symfony\Component\DependencyInjection\Container;

class CommentExtension extends \Twig_Extension
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'comment_extension';
    }

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('comment_children', array($this, 'commentChildren')),
        );
    }

    public function commentChildren(Comment $comment) {
        $repo = $this->container->get('doctrine')->getRepository('DarkishCommentBundle:Comment');
        return $repo->getChildren($comment);
    }
}
