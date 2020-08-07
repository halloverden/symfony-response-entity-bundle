<?php


namespace HalloVerden\ResponseEntityBundle\Event;


use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class PreResponseEntitySerializationEvent
 *
 * @package HalloVerden\ResponseEntityBundle\Event
 */
class PreResponseEntitySerializationEvent extends Event {

  /**
   * @var SerializationContext
   */
  private $context;

  /**
   * @var ResponseEntityInterface
   */
  private $responseEntity;

  /**
   * PreResponseEntitySerializationEvent constructor.
   *
   * @param SerializationContext    $context
   * @param ResponseEntityInterface $responseEntity
   */
  public function __construct(SerializationContext $context, ResponseEntityInterface $responseEntity) {
    $this->context = $context;
    $this->responseEntity = $responseEntity;
  }

  /**
   * @return SerializationContext
   */
  public function getContext(): SerializationContext {
    return $this->context;
  }

  /**
   * @return ResponseEntityInterface
   */
  public function getResponseEntity(): ResponseEntityInterface {
    return $this->responseEntity;
  }

}
