<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PointUser;

class ExpirePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire points based on expired_at date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = now();

        $expiredPoints = PointUser::where('expired_at', '<', $currentDate)->get();
        foreach ($expiredPoints as $point) {
            if ($point->point_earned > 0) {
                $point->update([

                    "point_earned" => 0,
                    "point_expired" => $point->point_earned + $point->point_expired
                ]);
            }
        }

        $this->info('Expired points updated successfully.');
        return 0;
    }

}
