<?php


namespace HalloVerden\ResponseEntityBundle\Entity;


use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractResponseEntity
 *
 * @package HalloVerden\ResponseEntityBundle\Entity
 */
abstract class AbstractResponseEntity implements ResponseEntityInterface {

  /**
   * @inheritDoc
   */
  public function getStatusCode(): int {
    return Response::HTTP_OK;
  }

  /**
   * @inheritDoc
   */
  public function getHeaders(): array {
    return [];
  }

}
