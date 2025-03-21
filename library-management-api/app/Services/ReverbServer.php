<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Protocols\Pusher\Server as BaseServer;

class ReverbServer extends BaseServer
{
  public function open(Connection $connection): void
  {
    try {
      $this->verifyOrigin($connection);

      $connection->touch();

      $this->handler->handle($connection, 'pusher:connection_established');

      Log::info('Connection Established', $connection->id());
    } catch (Exception $e) {
      $this->error($connection, $e);
    }
  }

  public function close(Connection $connection): void
  {
    $this->channels
      ->for($connection->app())
      ->unsubscribeFromAll($connection);

    $connection->disconnect();

    Log::info('Connection Closed', $connection->id());
  }
}
