<?php

/**
 * @file
 * Contains \Drupal\migrate_drupal\Plugin\migrate\source\d6\UserPicture.
 */

namespace Drupal\migrate_drupal\Plugin\migrate\source\d6;

use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 6 user picture source from database.
 *
 * @todo Support default picture?
 *
 * @MigrateSource(
 *   id = "d6_user_picture"
 * )
 */
class UserPicture extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->getDatabase()
      ->select('users', 'u')
      ->condition('picture', '', '<>')
      ->fields('u', array('uid', 'access', 'picture'))
      ->orderBy('access');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'uid' => 'Primary Key: Unique user ID.',
      'access' => 'Timestamp for previous time user accessed the site.',
      'picture' => "Path to the user's uploaded picture.",
    );
  }
  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['uid']['type'] = 'integer';
    return $ids;
  }

}
