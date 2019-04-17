<?php

declare(strict_types=1);

namespace Infakt\Repository;

use Infakt\Collections\Criteria;
use Infakt\Model\EntityInterface;

interface ObjectRepositoryInterface
{
    public function matching(Criteria $criteria);

    public function get(int $entityId);

    public function getAll(int $page, int $limit);

    public function create(EntityInterface $entity): EntityInterface;

    public function update(EntityInterface $entity): EntityInterface;

    public function delete(int $entityId);
}
