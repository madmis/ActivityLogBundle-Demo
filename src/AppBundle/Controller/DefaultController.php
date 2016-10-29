<?php

namespace AppBundle\Controller;

use ActivityLogBundle\Repository\LogEntryRepository;
use AppBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();

        /** @var LogEntryRepository $repo */
        $repo = $em->getRepository('ActivityLogBundle:LogEntry');
        $logs = $repo->findAll();
        $res = $this->get('activity_log.formatter')
            ->format($logs);

        $projects = $em->getRepository('AppBundle:Project')
            ->findAll();

        $project = null;
        if ($projects) {
            $project = array_shift($projects);
        }

        return $this->render('default/index.html.twig', [
            'logs' => $logs,
            'res' => $res,
            'project' => $project,
        ]);
    }

    /**
     * @Route("/project/create/{projectName}", name="create_project")
     * @param string $projectName
     * @return Response
     */
    public function createAction($projectName)
    {
        if (!$projectName) {
            $projectName = bin2hex(random_bytes(5));
        }

        $project = new Project();
        $project->setName($projectName);
        $project->setJiraKey($projectName);

        $em = $this->get('doctrine')->getManager();
        $em->persist($project);
        $em->flush();

        return $this->render('::create.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/project/update/{id}", name="update_project")
     * @param Project $project
     * @return Response
     */
    public function updateAction(Project $project)
    {
        $oldName = $project->getName();
        $project->setName($oldName . random_int(1, 999));

        $em = $this->get('doctrine')->getManager();
        $em->persist($project);
        $em->flush();

        return $this->render('::update.html.twig', [
            'oldName' => $oldName,
            'project' => $project,
        ]);
    }

    /**
     * @Route("/project/delete/{id}", name="delete_project")
     * @param Project $project
     * @return Response
     */
    public function deleteAction(Project $project)
    {
        $id = $project->getId();
        $name = $project->getName();

        $em = $this->get('doctrine')->getManager();
        $em->remove($project);
        $em->flush();

        return $this->render('::remove.html.twig', [
            'id' => $id,
            'name' => $name,
        ]);
    }
}
