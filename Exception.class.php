<?php
namespace Lambda\Database;

class BetterException extends Exception {
  public function __construct($message = null, $code = 0, Exception $previous = null) {
    parent::__construct($message, $code, $previous);
    error_log($message);
  }
}
