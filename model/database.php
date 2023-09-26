<?php
/*
 * Program File: database.php
 * Author......: Brian Timberlake
 * Date Created: October 18, 2021
 * Description.: This program is a database model.
 */
class DB {
  private $pdo = null;
  private $stmt = null;

  function __construct() {
    try {
      $this->pdo = new PDO(
        "mysql:host=localhost;dbname=" . DB_NAME . ";charset=utf8",
          DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => true,
        ]
      );
    } catch (Exception $ex) {
      die($ex->getMessage());
    }
  }

  function __destruct() {
    if ($this->stmt!==null) $this->stmt = null;
    if ($this->pdo!==null) $this->pdo = null;
  }

  function select($sql, $cond=null) {
    $result = false;
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
      $result = $this->stmt->fetchAll();
    } catch (Exception $ex) {
      die($ex->getMessage());
    }
    $this->stmt = null;
    return $result;
  }

  function execute($sql) {
    $stmt = $this->pdo->prepare($sql);

    $returnStatus = 0;
    try {
      $this->pdo->beginTransaction();
      $stmt->execute();
      $this->pdo->commit();
      $returnStatus = 1;
    } catch (Exception $e) {
      $this->pdo->rollback();
      $returnStatus = 2;
    }
    return $returnStatus;
  }

  function calculatePage($total) {
    /* calculate items per page for pagenation */
    if ($total <= 25) {
      $pages = 1;
    } else {
      $pages = (($total % 25) == 0) ? ($total / 25) : floor($total / 25) + 1;
    }
    return $pages;
  }
}
?>
