<?php

namespace eLife\Patterns\Mustache;

use Mustache_Exception_UnknownTemplateException;
use Mustache_Loader;
use Puli\Repository\Api\Resource\BodyResource;
use Puli\Repository\Api\ResourceNotFoundException;
use Puli\Repository\Api\ResourceRepository;

final class PuliLoader implements Mustache_Loader
{
    private $repository;

    public function __construct(ResourceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load($name)
    {
        try {
            $resource = $this->repository->get($name);
        } catch (ResourceNotFoundException $e) {
            throw new Mustache_Exception_UnknownTemplateException($name, $e);
        }

        if ($resource instanceof BodyResource) {
            return $resource->getBody();
        }

        throw new Mustache_Exception_UnknownTemplateException($name);
    }
}
