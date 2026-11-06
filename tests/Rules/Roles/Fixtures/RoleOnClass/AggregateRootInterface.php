<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass;

#[AggregateRoot] // ERROR #[AggregateRoot] can only be on a class, DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass\AggregateRootInterface is an interface.
interface AggregateRootInterface
{
}
