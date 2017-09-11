<?php

namespace RunetId\ApiClient\Builder;

/**
 * @property array $context
 */
trait SetMaxResultsTrait
{
    /**
     * @param int $maxResults
     *
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        $this->context['max_results'] = $maxResults;

        return $this;
    }
}
