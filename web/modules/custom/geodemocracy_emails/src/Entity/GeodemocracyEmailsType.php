<?php

namespace Drupal\geodemocracy_emails\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Geodemocracy emails type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "geodemocracy_emails_type",
 *   label = @Translation("Geodemocracy emails type"),
 *   label_collection = @Translation("Geodemocracy emails types"),
 *   label_singular = @Translation("geodemocracy emails type"),
 *   label_plural = @Translation("geodemocracy emailss types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count geodemocracy emailss type",
 *     plural = "@count geodemocracy emailss types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\geodemocracy_emails\Form\GeodemocracyEmailsTypeForm",
 *       "edit" = "Drupal\geodemocracy_emails\Form\GeodemocracyEmailsTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\geodemocracy_emails\GeodemocracyEmailsTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer geodemocracy emails types",
 *   bundle_of = "geodemocracy_emails",
 *   config_prefix = "geodemocracy_emails_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/geodemocracy_emails_types/add",
 *     "edit-form" = "/admin/structure/geodemocracy_emails_types/manage/{geodemocracy_emails_type}",
 *     "delete-form" = "/admin/structure/geodemocracy_emails_types/manage/{geodemocracy_emails_type}/delete",
 *     "collection" = "/admin/structure/geodemocracy_emails_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class GeodemocracyEmailsType extends ConfigEntityBundleBase {

  /**
   * The machine name of this geodemocracy emails type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the geodemocracy emails type.
   *
   * @var string
   */
  protected $label;

}
