<?php

namespace Drupal\geodemocracy_emails;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the geodemocracy emails entity type.
 */
class GeodemocracyEmailsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view geodemocracy emails');

      case 'update':
        return AccessResult::allowedIfHasPermissions(
          $account,
          ['edit geodemocracy emails', 'administer geodemocracy emails'],
          'OR',
        );

      case 'delete':
        return AccessResult::allowedIfHasPermissions(
          $account,
          ['delete geodemocracy emails', 'administer geodemocracy emails'],
          'OR',
        );

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions(
      $account,
      ['create geodemocracy emails', 'administer geodemocracy emails'],
      'OR',
    );
  }

}
