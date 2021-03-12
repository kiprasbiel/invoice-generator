<?php

namespace App\Listeners;

use App\Models\Meta;

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
        $this->setIvSettings($event);

        // Create new instance of SFnumber settings
        $this->setSfCodeSettings($event);

        $this->setPrivilegesSettings($event);

        // TODO: Notify the user himself to go and change these default settings
    }

    /**
     * @param object $event
     */
    private function setIvSettings(object $event): void {
        $IvData = Meta::getFieldsForValidation('Iv', null);

        $jsonData = json_encode(array_merge($IvData, [
            'full_name' => $event->user->name,
            'email' => $event->user->email,
        ]));

        $event->user->meta()->create([
            'name' => 'userActivitySettings',
            'value' => $jsonData
        ]);
    }

    /**
     * @param object $event
     */
    private function setSfCodeSettings(object $event): void {
        $SfCodeData = Meta::getFieldsForValidation('SfCode', null);

        $event->user->meta()->create([
            'name' => 'sfNumberSettings',
            'value' => json_encode(array_merge($SfCodeData, [
                'sf_code' => 'SF',
                'sf_number' => 1,
            ]))
        ]);
    }

    /**
     * @param object $event
     */
    private function setPrivilegesSettings(object $event): void {
        $PrivilegesData = Meta::getFieldsForValidation('Privileges', null);
        $event->user->meta()->create([
            'name' => 'privilegesSettings',
            'value' => json_encode(array_merge($PrivilegesData, ['additionalPension' => 'pens0']))
        ]);
    }
}
