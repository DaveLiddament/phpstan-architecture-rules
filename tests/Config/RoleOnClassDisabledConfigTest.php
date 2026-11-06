<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Config;

use PHPStan\Testing\PHPStanTestCase;
use PHPUnit\Framework\Attributes\Test;

final class RoleOnClassDisabledConfigTest extends PHPStanTestCase
{
    #[\Override]
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__.'/../../extension.neon',
            __DIR__.'/Fixtures/role-on-class-disabled.neon',
        ];
    }

    #[Test]
    public function roleOnClassRuleDoesNotRunWhenDisabled(): void
    {
        self::assertSame([], RuleSets::enabledIn(self::getContainer(), RuleSets::ROLE_ON_CLASS));
    }

    #[Test]
    public function otherRulesAreUnaffected(): void
    {
        self::assertSame(RuleSets::roles(), RuleSets::enabledIn(self::getContainer(), RuleSets::roles()));
        self::assertSame(RuleSets::ROLE_REQUIRED, RuleSets::enabledIn(self::getContainer(), RuleSets::ROLE_REQUIRED));
    }
}
