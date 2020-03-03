<?php


namespace HalloVerden\ResponseEntityBundle\Services;

use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityInterface;
use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityLinksInterface;
use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityServiceInterface;
use JMS\Serializer\Exclusion\GroupsExclusionStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class ResponseEntityService implements ResponseEntityServiceInterface {

  /**
   * @var SerializerInterface
   */
  private $serializer;

  /**
   * @var RequestStack
   */
  private $requestStack;

  /**
   * ResponseEntityService constructor.
   *
   * @param SerializerInterface $serializer
   * @param RequestStack        $requestStack
   */
  public function __construct(SerializerInterface $serializer, RequestStack $requestStack) {
    $this->serializer = $serializer;
    $this->requestStack = $requestStack;
  }

  /**
   * @param ResponseEntityInterface   $responseEntity
   * @param SerializationContext|null $context
   *
   * @return JsonResponse
   */
  public function createJsonResponse(ResponseEntityInterface $responseEntity, ?SerializationContext $context = null): JsonResponse {
    if ($context === null) {
      $context = SerializationContext::create();
    }

    if ($responseEntity instanceof ResponseEntityLinksInterface) {
      $this->addGroup($context, ResponseEntityLinksInterface::LINKS_SERIALIZER_GROUP);
      $this->addLinks($responseEntity);
    }

    $json = $this->serializer->serialize($responseEntity, 'json', $context);

    return JsonResponse::fromJsonString($json, $responseEntity->getStatusCode());
  }

  /**
   * @param ResponseEntityLinksInterface $responseEntityLinks
   */
  protected function addLinks(ResponseEntityLinksInterface $responseEntityLinks): void {
    if (!$responseEntityLinks->hasLink('self')) {
      $responseEntityLinks->setLink('self', $this->requestStack->getCurrentRequest()->getPathInfo());
    }
  }

  /**
   * @param SerializationContext $context
   * @param string               $group
   */
  private function addGroup(SerializationContext $context, string $group): void {
    $groups = $context->hasAttribute('groups') ? $context->getAttribute('groups') : [GroupsExclusionStrategy::DEFAULT_GROUP];
    $groups[] = $group;
    $context->setGroups($groups);
  }
}
