<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles;

use DaveLiddament\PhpstanArchitectureRules\Roles\RoleResolver;
use DaveLiddament\PhpstanArchitectureRules\Rules\Roles\RoleOnClassRule;
use DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass\AggregateRoot;
use DaveLiddament\PhpstanRuleTestHelper\AbstractRuleTestCase;
use PHPStan\Rules\Rule;
use PHPUnit\Framework\Attributes\Test;

/**
 * @extends AbstractRuleTestCase<RoleOnClassRule>
 */
final class RoleOnClassRuleTest extends AbstractRuleTestCase
{
    /** @var array<string, bool> */
    private array $roles = [];

    #[\Override]
    protected function getRule(): Rule
    {
        return new RoleOnClassRule(
            $this->createReflectionProvider(),
            new RoleResolver(['entity' => ['attributes' => [AggregateRoot::class]]]),
            $this->roles,
        );
    }

    #[Test]
    public function rolesOnClassesAndRolelessInterfacesTraitsAndEnumsAreAccepted(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/RoleOnClass/ViewModelClass.php',
            __DIR__.'/Fixtures/RoleOnClass/AggregateRootClass.php',
            __DIR__.'/Fixtures/RoleOnClass/ExportedInterface.php',
            __DIR__.'/Fixtures/RoleOnClass/PlainTrait.php',
            __DIR__.'/Fixtures/RoleOnClass/PlainEnum.php',
        );
    }

    #[Test]
    public function rolesOnInterfacesTraitsAndEnumsAreReported(): void
    {
        $this->assertIssuesReported(
            __DIR__.'/Fixtures/RoleOnClass/ViewModelInterface.php',
            __DIR__.'/Fixtures/RoleOnClass/ExportedDtoInterface.php',
            __DIR__.'/Fixtures/RoleOnClass/ViewModelTrait.php',
            __DIR__.'/Fixtures/RoleOnClass/ValueObjectEnum.php',
        );
    }

    #[Test]
    public function aliasAttributesOnInterfacesAreReported(): void
    {
        $this->assertIssuesReported(__DIR__.'/Fixtures/RoleOnClass/AggregateRootInterface.php');
    }

    #[Test]
    public function rolesThatAreTurnedOffAreIgnored(): void
    {
        $this->roles = ['viewModel' => false, 'dto' => false];

        $this->analyse([
            __DIR__.'/Fixtures/RoleOnClass/ViewModelInterface.php',
            __DIR__.'/Fixtures/RoleOnClass/ExportedDtoInterface.php',
        ], []);
    }
}
