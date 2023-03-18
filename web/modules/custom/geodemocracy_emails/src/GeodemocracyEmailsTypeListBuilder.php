<?php

namespace Drupal\geodemocracy_emails;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of geodemocracy emails type entities.
 *
 * @see \Drupal\geodemocracy_emails\Entity\GeodemocracyEmailsType
 */
class GeodemocracyEmailsTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No geodemocracy emails types available. <a href=":link">Add geodemocracy emails type</a>.',
      [':link' => Url::fromRoute('entity.geodemocracy_emails_type.add_form')->toString()]
    );

    return $build;
  }

}
