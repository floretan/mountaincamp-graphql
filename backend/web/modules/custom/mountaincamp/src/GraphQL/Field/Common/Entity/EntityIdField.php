<?php

namespace Drupal\mountaincamp\GraphQL\Field\Common\Entity;

use Drupal\Component\Utility\Random;
use Drupal\Core\Entity\EntityInterface;
use Drupal\graphql\GraphQL\CacheableLeafValue;
use Drupal\mountaincamp\GraphQL\Field\SelfAwareField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;

class EntityIdField extends SelfAwareField {

  /**
   * {@inheritdoc}
   */
  public function resolve($value, array $args, ResolveInfo $info) {
    if ($value instanceof EntityInterface) {
      $cacheableValue = new CacheableLeafValue('', [$value]);
      if (($id = $value->id()) !== NULL) {
        $cacheableValue->setValue($id);
      }
      else {
        $cacheableValue->setValue('new-' . (new Random())->string());
      }

      return $cacheableValue;
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return new NonNullType(new StringType());
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'entityId';
  }
}
