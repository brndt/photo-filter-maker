<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Infrastructure\Persistence\Elasticsearch;

use LaSalle\Performance\Shared\Domain\Criteria\Filter;
use LaSalle\Performance\Shared\Domain\Criteria\FilterOperator;

use function Lambdish\Phunctional\get;

final class ElasticQueryGenerator
{
    private const MUST_TYPE     = 'must';
    private const MUST_NOT_TYPE = 'must_not';
    private const TERM_TERM     = 'term';
    private const TERM_RANGE    = 'range';
    private const TERM_WILDCARD = 'wildcard';

    public function __invoke(array $query, Filter $filter): array
    {
        $type          = $this->typeFor($filter->operator());
        $termLevel     = $this->termLevelFor($filter->operator());
        $valueTemplate = $filter->operator()->isContaining() ? '*%s*' : '%s';

        return array_merge_recursive(
            $query,
            [
                $type => [
                    $termLevel => [
                        $filter->field()->value() => sprintf(
                            $valueTemplate,
                            strtolower($filter->value()->value())
                        ),
                    ],
                ],
            ]
        );
    }

    private function typeFor(FilterOperator $operator): string
    {
        return in_array($operator->getValue(), self::mustNotFields(), true) ? self::MUST_NOT_TYPE : self::MUST_TYPE;
    }

    private function termLevelFor(FilterOperator $operator): string
    {
        return get($operator->getValue(), self::termMapping());
    }

    private static function termMapping(): array {
        return [
            FilterOperator::equal()->getValue()        => self::TERM_TERM,
            FilterOperator::not_equal()->getValue()    => '!=',
            FilterOperator::gt()->getValue()           => self::TERM_RANGE,
            FilterOperator::lt()->getValue()           => self::TERM_RANGE,
            FilterOperator::contains()->getValue()     => self::TERM_WILDCARD,
            FilterOperator::not_contains()->getValue() => self::TERM_WILDCARD,
        ];
    }

    private static function mustNotFields(): array {
        return [FilterOperator::not_equal()->getValue(), FilterOperator::not_contains()->getValue()];
    }

}
