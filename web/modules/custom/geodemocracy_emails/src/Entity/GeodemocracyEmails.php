<?php

namespace Drupal\geodemocracy_emails\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\geodemocracy_emails\GeodemocracyEmailsInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the geodemocracy emails entity class.
 *
 * @ContentEntityType(
 *   id = "geodemocracy_emails",
 *   label = @Translation("Geodemocracy emails"),
 *   label_collection = @Translation("Geodemocracy emailss"),
 *   label_singular = @Translation("geodemocracy emails"),
 *   label_plural = @Translation("geodemocracy emailss"),
 *   label_count = @PluralTranslation(
 *     singular = "@count geodemocracy emailss",
 *     plural = "@count geodemocracy emailss",
 *   ),
 *   bundle_label = @Translation("Geodemocracy emails type"),
 *   handlers = {
 *     "list_builder" = "Drupal\geodemocracy_emails\GeodemocracyEmailsListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\geodemocracy_emails\GeodemocracyEmailsAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\geodemocracy_emails\Form\GeodemocracyEmailsForm",
 *       "edit" = "Drupal\geodemocracy_emails\Form\GeodemocracyEmailsForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "geodemocracy_emails",
 *   admin_permission = "administer geodemocracy emails types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/geodemocracy-emails",
 *     "add-form" = "/geodemocracy-emails/add/{geodemocracy_emails_type}",
 *     "add-page" = "/geodemocracy-emails/add",
 *     "canonical" = "/geodemocracy-emails/{geodemocracy_emails}",
 *     "edit-form" = "/geodemocracy-emails/{geodemocracy_emails}/edit",
 *     "delete-form" = "/geodemocracy-emails/{geodemocracy_emails}/delete",
 *   },
 *   bundle_entity_type = "geodemocracy_emails_type",
 *   field_ui_base_route = "entity.geodemocracy_emails_type.edit_form",
 * )
 */
class GeodemocracyEmails extends ContentEntityBase implements GeodemocracyEmailsInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the geodemocracy emails was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the geodemocracy emails was last edited.'));

    return $fields;
  }

}
