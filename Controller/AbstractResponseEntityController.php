<?php


namespace HalloVerden\ResponseEntityBundle\Controller;


use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityInterface;
use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityServiceInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponseEntityController {
  const SERIALIZER_GROUPS = null;

  /**
   * @var ResponseEntityServiceInterface
   */
  protected $responseEntityService;

  /**
   * @required
   *
   * @param ResponseEntityServiceInterface $responseEntityService
   *
   * @return AbstractResponseEntityController
   */
  public function setResponseEntityService(ResponseEntityServiceInterface $responseEntityService): self {
    $this->responseEntityService = $responseEntityService;
    return $this;
  }

  /**
   * @param ResponseEntityInterface $responseEntity
   *
   * @return JsonResponse
   */
  protected function createJsonResponse(ResponseEntityInterface $responseEntity): JsonResponse {
    return $this->responseEntityService->createJsonResponse($responseEntity, $this->createContext());
  }

  /**
   * @return array
   */
  protected function getSerializerGroups(): ?array {
    return static::SERIALIZER_GROUPS;
  }

  /**
   * @return SerializationContext|null
   */
  protected function createContext(): ?SerializationContext {
    $context = SerializationContext::create();

    if (null !== ($groups = $this->getSerializerGroups())) {
      return $context->setGroups($groups);
    }

    return $context;
  }

}
