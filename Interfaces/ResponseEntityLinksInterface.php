<?php


namespace HalloVerden\ResponseEntityBundle\Interfaces;

interface ResponseEntityLinksInterface extends ResponseEntityInterface {
  const LINKS_SERIALIZER_GROUP = 'ResponseEntityLink';

  /**
   * @return array
   */
  public function getLinks(): array;

  /**
   * @param array $links
   *
   * @return $this
   */
  public function setLinks(array $links): self;

  /**
   * @param string $key
   *
   * @return bool
   */
  public function hasLink(string $key): bool;

  /**
   * @param string $key
   * @param string $path
   *
   * @return $this
   */
  public function setLink(string $key, string $path): self;

}
