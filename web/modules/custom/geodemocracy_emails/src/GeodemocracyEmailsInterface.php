<?php

namespace Drupal\geodemocracy_emails;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a geodemocracy emails entity type.
 */
interface GeodemocracyEmailsInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
