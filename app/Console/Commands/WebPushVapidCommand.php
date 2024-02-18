<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\Vapid;

class WebPushVapidCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'webpush:vapid';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate VAPID keys for WebPush';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    try {


      $vapidKeys = Vapid::createVapidKeys();
      
      $this->info('VAPID Public Key: ' . $vapidKeys['publicKey']);
      $this->info('VAPID Private Key: ' . $vapidKeys['privateKey']);
    } catch (\Exception $e) {
      $this->error('Unable to create VAPID keys. ' . $e->getMessage());
      return 1; // Return a non-zero exit code to indicate failure
    }

    return 0; // Return zero to indicate success
  }

}
