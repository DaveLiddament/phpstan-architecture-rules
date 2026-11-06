<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass;

use DaveLiddament\Architecture\Attribute\ViewModel;

#[ViewModel] // ERROR #[ViewModel] can only be on a class, DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\RoleOnClass\ViewModelInterface is an interface.
interface ViewModelInterface
{
}
