<?php


namespace HalloVerden\ResponseEntityBundle\Interfaces;


use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseEntityServiceInterface {

  /**
   * @param ResponseEntityInterface   $responseEntity
   * @param SerializationContext|null $context
   *
   * @return JsonResponse
   */
  public function createJsonResponse(ResponseEntityInterface $responseEntity, ?SerializationContext $context = null): JsonResponse;
}
