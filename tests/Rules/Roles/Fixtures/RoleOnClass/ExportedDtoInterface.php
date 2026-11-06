<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass;

use DaveLiddament\Architecture\Attribute\Dto;
use DaveLiddament\Architecture\Attribute\Exported;

#[Dto] // ERROR #[Dto] can only be on a class, DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass\ExportedDtoInterface is an interface.
#[Exported]
interface ExportedDtoInterface
{
}
