<?php

declare(strict_types=1);

/**
 * This file is part of Laravel Code Analyse.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\LaravelCodeAnalyse\Support\Facades;

use function get_class;
use InvalidArgumentException;
use Illuminate\Support\Manager;
use Illuminate\Support\Facades\Facade;
use PHPStan\Reflection\ClassReflection;
use NunoMaduro\LaravelCodeAnalyse\AbstractExtension;
use NunoMaduro\LaravelCodeAnalyse\FacadeConcreteClassResolver;

final class FacadeMethodExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected $staticAccess = true;

    /**
     * {@inheritdoc}
     */
    protected function subject(): string
    {
        return Facade::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function searchIn(ClassReflection $classReflection): array
    {
        $facadeClass = $classReflection->getName();

        if ($concrete = $facadeClass::getFacadeRoot()) {

            $classes = [get_class($concrete)];

            if ($concrete instanceof Manager) {

                $driver = null;

                try {
                    $driver = $concrete->driver();
                } catch (InvalidArgumentException $exception) {
                    // ..
                }

                if ($driver !== null) {
                    $classes[] = get_class($driver);
                }
            }

            return $classes;
        }

        return [NullConcreteClass::class];
    }
}
