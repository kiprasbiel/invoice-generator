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
     * @param object $event
     * @return void
     */
    public function handle(object $event)
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

        // TODO: Needs refactoring

        // Create new instance of SFnumber settings

        $SfCodeData = Meta::getFieldsForValidation('SfCode', null);

        $event->user->meta()->create([
            'name' => 'sfNumberSettings',
            'value' =>  json_encode(array_merge($SfCodeData, [
                'sf_code' => 'SF',
                'sf_number' => 1,
            ]))
        ]);

        $PrivilegesData = Meta::getFieldsForValidation('Privileges', null);
        $event->user->meta()->create([
            'name' => 'privilegesSettings',
            'value' =>  json_encode(array_merge($PrivilegesData, ['additionalPension' => 'pens0']))
        ]);

        // TODO: Temporary
        $ExpensesData = Meta::getFieldsForValidation('Expenses', null);
        $event->user->meta()->create([
            'name' => 'totalExpenses',
            'value' =>  json_encode(array_merge($ExpensesData, ['expenses' => '0']))
        ]);

        // TODO: Notify the user himself to go and change these default settings
        // TODO: Add default priveleges settings

    }
}
