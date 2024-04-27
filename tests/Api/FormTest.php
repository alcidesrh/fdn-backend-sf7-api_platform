<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Browser\Test\HasBrowser;
use Symfony\Component\Panther\PantherTestCaseTrait;

class FormTest extends ApiTestCase {
    use Factories;
    use ResetDatabase;
    use HasBrowser;
    use PantherTestCaseTrait;

    public function testSomething(): void {
        $this->pantherBrowser()->visit('/api/create_forms/permiso')
            ->dump();
    }
}
