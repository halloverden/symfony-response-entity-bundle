<?php


namespace HalloVerden\ResponseEntityBundle\Services;

use HalloVerden\ResponseEntityBundle\Event\PreResponseEntitySerializationEvent;
use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityInterface;
use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityLinksInterface;
use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityServiceInterface;
use JMS\Serializer\Exclusion\GroupsExclusionStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

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
   * @var EventDispatcherInterface
   */
  private $dispatcher;

  /**
   * ResponseEntityService constructor.
   *
   * @param SerializerInterface      $serializer
   * @param RequestStack             $requestStack
   * @param EventDispatcherInterface $dispatcher
   */
  public function __construct(SerializerInterface $serializer, RequestStack $requestStack, EventDispatcherInterface $dispatcher) {
    $this->serializer = $serializer;
    $this->requestStack = $requestStack;
    $this->dispatcher = $dispatcher;
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

    $event = new PreResponseEntitySerializationEvent($context, $responseEntity);
    $this->dispatcher->dispatch($event);

    $json = $this->serializer->serialize($event->getResponseEntity(), 'json', $event->getContext());

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
