<?php

namespace App\Listeners;

use App\Models\Meta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserDefaultSettings
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Create new instance of IV settings
        $IvData = Meta::getFieldsForValidation('Iv', null);

        $jsonData = json_encode(array_merge($IvData, [
            'full_name' => $event->user->name,
            'email' => $event->user->email,
        ]));

        $event->user->meta()->create([
            'name' => 'userActivitySettings',
            'value' =>  $jsonData
        ]);

        // Create new instance of SFnumber settings

        $SfCodeData = Meta::getFieldsForValidation('SfCode', null);

        $event->user->meta()->create([
            'name' => 'sfNumberSettings',
            'value' =>  json_encode(array_merge($SfCodeData, ['sf_code' => 'SF']))
        ]);

        // TODO: Notify the user himself to go and change these default settings
        // TODO: Add default priveleges settings

    }
}
