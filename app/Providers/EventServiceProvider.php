<?php

namespace App\Providers;

use App\Models\AdministrationType;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\DarkModeWasToggled;
use JeroenNoten\LaravelAdminLte\Events\ReadingDarkModePreference;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Register listener for ReadingDarkModePreference event. We use this
        // event to setup dark mode initial status for AdminLTE package.
        Event::listen(
            ReadingDarkModePreference::class,
            [$this, 'handleReadingDarkModeEvt']
        );

        // Register listener for DarkModeWasToggled AdminLTE event.
        Event::listen(
            DarkModeWasToggled::class,
            [$this, 'handleDarkModeWasToggledEvt']
        );

        // Register listener for BuildingMenu AdminLTE event.
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu and remove some others...
            if (auth()->user()->administration_type_id == AdministrationType::$TYPE_ACCOUNTANT) {
                $event->menu->remove('documents');
                $event->menu->remove('in_outs');
                $event->menu->remove('employees');
                $event->menu->remove('services');
                $event->menu->remove('users');
                $event->menu->add([
                    'text' => 'documents_management',
                    'url' => 'admin/documents/management',
                    'icon' => 'fas fa-fw fa-file-alt',
                ]);
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

     /**
     * Handle the ReadingDarkModePreference AdminLTE event.
     *
     * @param ReadingDarkModePreference $event
     * @return void
     */
    public function handleReadingDarkModeEvt(ReadingDarkModePreference $event)
    {
        // TODO: Implement the next method to get the dark mode preference for the
        // current authenticated user. Usually this preference will be stored on a database,
        // it is your task to get it.
        if (!auth()->check()) {
            return;
        }

        $user = User::find(auth()->user()->id);
        $darkModeCfg = $user->getDarkMode();

        // Setup initial dark mode preference.
        if ($darkModeCfg) {
            $event->darkMode->enable();
        } else {
            $event->darkMode->disable();
        }
    }

    /**
     * Handle the DarkModeWasToggled AdminLTE event.
     *
     * @param DarkModeWasToggled $event
     * @return void
     */
    public function handleDarkModeWasToggledEvt(DarkModeWasToggled $event)
    {
        if (!auth()->check()) {
            return;
        }

        // Get the new dark mode preference (enabled or not).
        $darkModeCfg = $event->darkMode->isEnabled();

        // Store the new dark mode preference on the database.
        $user = User::find(auth()->user()->id);
        $user->setDarkMode($darkModeCfg);
    }
}