<?php

namespace App\Jobs;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class CleanupCartsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        $guestCartExpiration = Carbon::now()->subWeeks(1);
        $userCartExpiration = Carbon::now()->subWeeks(1);

        $deletedGuestCarts = Cart::whereNull('user_id')
                                 ->where('last_updated_at', '<', $guestCartExpiration)
                                 ->delete();

        $deletedUserCarts = Cart::whereNotNull('user_id')
                                ->where('last_updated_at', '<', $userCartExpiration)
                                ->delete();
        if(App::isLocal()) {
            logger("Deleted guest carts: $deletedGuestCarts");
            logger("Deleted users carts: $deletedUserCarts");
        }
    }
}
