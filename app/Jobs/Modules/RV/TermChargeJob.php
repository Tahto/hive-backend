<?php

namespace App\Jobs\Modules\RV;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Modules\RV\Terms;
use App\Models\Modules\RV\TermsCharge;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class TermChargeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tries = 3;
    private $term;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Terms $term)
    {
        $this->term = $term;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $charge_id = $this->term->charge_id;

        $TermsCharge = TermsCharge::where('id', $charge_id )->first();

        
       
    }

   
}
