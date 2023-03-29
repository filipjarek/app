<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\TeacherTask;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TeacherTaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SubjectTest extends WebTestCase
{
    public function testIfSubjectsPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('show_subjects'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfClassroomPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var TeacherTaskRepository */
        $teachertaskRepository = $em->getRepository(TeacherTask::class);

        /** @var TeacherTask */
        $teachertask = $teachertaskRepository->findOneBy([]);

        $user = $em->find(User::class, 1);

        $client->loginUser($user);

        $client->request(
            Request::METHOD_GET, 
            $urlGeneratorInterface->generate('show_class', [
                'id'=>$teachertask->getClassroom()->getId(),
                'subject_id'=>$teachertask->getSubject()->getId()
            ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
