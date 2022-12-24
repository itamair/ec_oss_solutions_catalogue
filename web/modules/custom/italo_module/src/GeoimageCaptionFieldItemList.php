<?php

namespace Drupal\italo_module;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;
use Drupal\node\NodeInterface;

/**
 * Generates a GeoimageCaptionFieldItemList.
 */
class GeoimageCaptionFieldItemList extends FieldItemList {

  use ComputedItemListTrait;

  /**
   * Whether the value has been calculated.
   *
   * @var bool
   */
  protected $isCalculated = FALSE;

  /**
   * {@inheritdoc}
   *
   * Generate the Value for the Geoimage Caption Field,
   * only for the Geoimage Node Bundle.
   */
  protected function computeValue() {
    if (!$this->isCalculated) {
      $entity = $this->getEntity();
      $entity_bundles = ['geoimage', 'territorial_report'];
      if ($entity instanceof NodeInterface && in_array($entity->bundle(), $entity_bundles)) {
        /** @var \Drupal\node\NodeInterface $entity */
        /** @var \Drupal\user\UserInterface $entity_author */
        $entity_author = $entity->getOwner();
        $forename = $entity_author->field_forename->value;
        $surname = $entity_author->field_surname->value;
        switch ($entity->bundle()) {
          case 'geoimage':
            $value = $this->t('<div class="geoimage-caption"><span class="geoimage-title">@title</span> - <span class="geoimage-credits">Credits: @forename @surname</span></div>', [
              '@title' => $entity->label(),
              '@forename' => $forename,
              '@surname' => $surname,
            ]);
            break;

          case 'territorial_report':
            $value = $this->t('<div class="geoimage-caption"><span class="geoimage-credits">Credits: @forename @surname</span></div>', [
              '@forename' => $forename,
              '@surname' => $surname,
            ]);
            break;
        }
        $this->list[0] = $this->createItem(0, $value);
        $this->isCalculated = TRUE;
      }
    }
  }

}
