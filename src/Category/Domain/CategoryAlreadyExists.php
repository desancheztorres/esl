<?php

declare(strict_types=1);

namespace App\Category\Domain;

use RuntimeException;

final class CategoryAlreadyExists extends RuntimeException
{

}