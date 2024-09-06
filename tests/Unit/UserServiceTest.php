<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Mockery;

class UserServiceTest extends TestCase
{
    public function testCreateUser()
    {
        // Cria o mock do repositório
        $userRepository = Mockery::mock(UserRepository::class);
        
        // Define o comportamento esperado
        $userRepository->shouldReceive('makeUser')
                       ->once()
                       ->andReturn(['id' => 1, 'name' => 'Test User']);
        
        // Instancia o serviço com o mock
        $userService = new UserService($userRepository);
        
        // Chama o método do serviço e verifica o resultado
        $result = $userService->makeUser(['name' => 'Test User']);
        
        $this->assertEquals(1, $result['id']);
        $this->assertEquals('Test User', $result['name']);
    }
    
    protected function tearDown(): void
    {
        Mockery::close();
    }
}
