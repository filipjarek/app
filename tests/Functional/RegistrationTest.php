<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationTest extends WebTestCase
{   
    public function testIfRegistrationPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_register'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfRegistrationWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_register'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=registration_form]')->form([
            'registration_form[firstname]' => "Rick",
            'registration_form[lastname]' => "Jones",
            'registration_form[username]' => "rjones",
            'registration_form[plainPassword][first]' => "password",
            'registration_form[plainPassword][second]' => "password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        
        $this->assertRouteSame('app_login');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testIfReturnToLoginPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_register'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $link = $crawler->selectLink('Already registered?')->link()->getUri();
        $crawler = $client->request(Request::METHOD_GET, $link);
       
        $this->assertRouteSame('app_login');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
