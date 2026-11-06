<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Tests\Rules\Roles\Fixtures\ViewModel;

use DaveLiddament\Architecture\Attribute\ViewModel;

#[ViewModel]
enum EnumViewModel
{
    case A;
}
