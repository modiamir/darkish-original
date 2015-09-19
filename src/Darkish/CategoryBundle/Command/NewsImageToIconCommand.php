<?php
namespace Darkish\CategoryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NewsImageToIconCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('darkish:news:imegetoicon')
            ->setDescription('Convert news first image to icon');

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        $newsRepo = $doctrine->getRepository('DarkishCategoryBundle:News');
        $newsQb = $newsRepo->createQueryBuilder('n');
//        $newsQb->select('n.id');
        $newsQb->join('n.images', 'images','WITH');

        $res = $newsQb->getQuery()->getResult();
        foreach($res as $news)
        {
            if($news->getId())
            {
                /* @var $news \Darkish\CategoryBundle\Entity\News */
                $firstImage = $news->getImages()->first();
                $news->getImages()->removeElement($firstImage);

                $news->setIcon($firstImage);
                $em->persist($news);
            }


        }

        $em->flush();

        $output->writeln(count($res));
    }
}
