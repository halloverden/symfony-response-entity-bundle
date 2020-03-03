<?php


namespace HalloVerden\ResponseEntityBundle\Interfaces;


interface ResponseEntityInterface {

  /**
   * @return int
   */
  public function getStatusCode(): int;

  /**
   * @return array
   */
  public function getHeaders(): array;

}
