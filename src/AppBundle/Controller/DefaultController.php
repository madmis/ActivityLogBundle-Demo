<?php

namespace AppBundle\Controller;

use ActivityLogBundle\Repository\LogEntryRepository;
use AppBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $ent = $em->getRepository('AppBundle:Project')
            ->find(1);
//        $ent = new Project();
//        $ent->setName('name 1');
//        $ent->setJiraKey('nm_1');
//
//        $em->persist($ent);
//        $em->flush();

        /** @var LogEntryRepository $repo */
        $repo = $em->getRepository('ActivityLogBundle:LogEntry');
        $logs = $repo->getLogEntriesQuery($ent)->getResult();

        $res = $this->get('activity_log.formatter')
            ->format($logs);


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
