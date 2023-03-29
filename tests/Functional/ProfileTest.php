<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProfileTest extends WebTestCase
{   
    public function testIfProfilePageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_profile'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfChangePasswordWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_profile'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=profile_edit_form]')->form([
            'profile_edit_form[plainPassword][first]' => "password",
            'profile_edit_form[plainPassword][second]' => "password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        
        $this->assertRouteSame('app_profile');
        $this->assertSelectorTextContains('div.alert', 'Password updated successfully !');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }
}
