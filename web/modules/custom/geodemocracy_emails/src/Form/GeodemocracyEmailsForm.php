<?php

namespace Drupal\geodemocracy_emails\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the geodemocracy emails entity edit forms.
 */
class GeodemocracyEmailsForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New geodemocracy emails %label has been created.', $message_arguments));
        $this->logger('geodemocracy_emails')->notice('Created new geodemocracy emails %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The geodemocracy emails %label has been updated.', $message_arguments));
        $this->logger('geodemocracy_emails')->notice('Updated geodemocracy emails %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.geodemocracy_emails.canonical', ['geodemocracy_emails' => $entity->id()]);

    return $result;
  }

}
