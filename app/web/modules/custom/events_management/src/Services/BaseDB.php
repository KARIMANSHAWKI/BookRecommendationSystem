<?php

namespace Drupal\events_management\Services;

use DateTime;
use Drupal;
use Drupal\Core\Database\Connection;
use Exception;
use stdClass;

class BaseDB
{
  private ?Connection $connection;

  public function __construct()
  {
    $this->connection = Drupal::database();
  }

  public function listAllRecords($tableName, $orderByColumn = 'id'): array
  {
    $page = Drupal::request()->query->get('page', 0);
    $offset = $page * $limit;

    $query = $this->connection->select($tableName, 'e')
      ->fields('e');

    if ($limit) {
      $query->range($offset, $limit);
    }

    return $query->orderBy($orderByColumn, 'DESC')->execute()->fetchAll();
  }

  public function listEvents($limit, $tableName, $pastEvents): array
  {
    $page = Drupal::request()->query->get('page', 0);
    $offset = $page * $limit;

    $query = $this->connection->select($tableName, 'e')->fields('e');

    if (!$pastEvents) {
      $query = $query->condition('end_time', (new DateTime())->format('Y-m-d H:i:s'), '>=');
    }

    if ($limit) {
      $query = $query->range($offset, $limit);
    }

    return $query->execute()->fetchAll();


}

  /**
   * @throws Exception
   */
  public function create(string $tableName, array $data): void
  {
    $this->connection->insert($tableName)->fields($data)->execute();
  }

  public function findById($tableName, $entityId): stdClass|bool
  {
    $row = $this->connection->select($tableName, 't')
      ->fields('t')
      ->condition('id', $entityId)
      ->execute()->fetchAll();
    return reset($row);
  }

  public function update($tableName, $entityId, $data): ?int
  {
    return $this->connection->update($tableName)
      ->fields($data)
      ->condition('id', $entityId)
      ->execute();
  }

  public function delete($tableName, $entityId): void
  {
    $this->connection->delete($tableName)
      ->condition('id', $entityId)
      ->execute();
  }
}
