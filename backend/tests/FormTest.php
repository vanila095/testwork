<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/app/form');
		$response = $client->getResponse();
		$this->assertEquals(302, $response->getStatusCode());
    }
	
	public function testLoadinForm(): void
	{
		$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);
		
		$testUser = $userRepository->findOneByEmail('test@test');
		
		$client->loginUser($testUser);
		
		$client->request('GET', '/app/form');
		$this->assertResponseIsSuccessful();
		$this->assertSelectorTextContains('h1', 'Заказать услугу оценки');
		$this->assertSelectorTextContains('#order_service', '');
		$this->assertSelectorTextContains('#order_email', '');
		$this->assertSelectorTextContains('#order_coast', '');
		$this->assertSelectorTextContains('button', '');
	}
	
	
	public function testSummbitForm(): void
	{
		$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);
		
		$testUser = $userRepository->findOneByEmail('test@test');
		
		$client->loginUser($testUser);
		$client->request('GET', '/app/form');
		
		$client->submitForm('Сохранить', [
			'order[service]' => 2,
			'order[email]' => 'me@me.me',
			'order[coast]' => '1000',
		]);
		
		
		$this->assertResponseRedirects();
		$client->followRedirect();
		$this->assertSelectorTextContains('div', 'Добавлено');
		
	}
}
