<?php


namespace HalloVerden\ResponseEntityBundle\Entity;


use HalloVerden\ResponseEntityBundle\Interfaces\ResponseEntityLinksInterface;
use JMS\Serializer\Annotation as Serializer;

abstract class AbstractResponseEntityLinks extends AbstractResponseEntity implements ResponseEntityLinksInterface {

  /**
   * @var array<string, string>
   *
   * @Serializer\SerializedName("links")
   * @Serializer\Type(name="array<string, string>")
   * @Serializer\Expose(if="object.getLinks() !== []")
   * @Serializer\Groups({ResponseEntityLinksInterface::LINKS_SERIALIZER_GROUP})
   */
  protected $links = [];

  /**
   * @inheritDoc
   */
  public function getLinks(): array {
    return $this->links;
  }

  /**
   * @inheritDoc
   */
  public function setLinks(array $links): ResponseEntityLinksInterface {
    $this->links = $links;
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function hasLink(string $key): bool {
    return isset($this->links[$key]);
  }

  /**
   * @inheritDoc
   */
  public function setLink(string $key, string $path): ResponseEntityLinksInterface {
    $this->links[$key] = $path;
    return $this;
  }

}
