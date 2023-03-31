<?php

namespace Arcmedia;

use App\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->registerForAutoconfiguration(CommandHandler::class)->addTag('arcmedia.category.command');
    }
}
