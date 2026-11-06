<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass;

use DaveLiddament\Architecture\Attribute\ValueObject;

#[ValueObject] // ERROR #[ValueObject] can only be on a class, DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass\ValueObjectEnum is an enum.
enum ValueObjectEnum
{
    case A;
}
