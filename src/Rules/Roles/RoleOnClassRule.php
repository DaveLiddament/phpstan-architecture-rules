<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanArchitectureRules\Rules\Roles;

use DaveLiddament\PhpstanArchitectureRules\Roles\Role;
use DaveLiddament\PhpstanArchitectureRules\Roles\RoleResolver;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Roles are for classes: a role attribute, or an alias attribute, on an
 * interface, trait or enum is reported. The role rules only look at classes,
 * so there it does nothing, and on a trait it doesn't carry over to the
 * classes that use it. Attributes of roles that are turned off are ignored.
 *
 * It runs on ClassLike nodes rather than InClassNode, because PHPStan
 * analyses a trait only where a class uses it.
 *
 * @implements Rule<ClassLike>
 */
final class RoleOnClassRule implements Rule
{
    /**
     * @param array<string, bool> $roles role => enabled
     */
    public function __construct(
        private ReflectionProvider $reflectionProvider,
        private RoleResolver $roleResolver,
        private array $roles,
    ) {
    }

    #[\Override]
    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @return list<IdentifierRuleError>
     */
    #[\Override]
    public function processNode(Node $node, Scope $scope): array
    {
        $className = $node->namespacedName?->toString();
        if (null === $className || !$this->reflectionProvider->hasClass($className)) {
            return [];
        }

        $classReflection = $this->reflectionProvider->getClass($className);
        $kind = match (true) {
            $classReflection->isInterface() => 'an interface',
            $classReflection->isTrait() => 'a trait',
            $classReflection->isEnum() => 'an enum',
            default => null,
        };
        if (null === $kind) {
            return [];
        }

        $errors = [];
        foreach ($classReflection->getNativeReflection()->getAttributes() as $attribute) {
            $attributeName = $attribute->getName();
            $roles = array_filter(
                $this->roleResolver->rolesGivenBy($attributeName),
                fn (Role $role): bool => $this->roles[$role->value] ?? true,
            );
            if ([] === $roles) {
                continue;
            }

            $errors[] = RuleErrorBuilder::message(sprintf(
                '#[%s] can only be on a class, %s is %s.',
                substr($attributeName, (int) strrpos($attributeName, '\\') + 1),
                $classReflection->getName(),
                $kind,
            ))
                ->identifier('architecture.roleOnClass')
                ->build();
        }

        return $errors;
    }
}
