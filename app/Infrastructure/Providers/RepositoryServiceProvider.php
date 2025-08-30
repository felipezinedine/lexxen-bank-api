<?php


namespace App\Infrastructure\Providers;

use App\Domain\Account\Repositories\AccountInterface;
use App\Domain\Transfers\Repositories\TransfersInterface;
use App\Domain\User\Repositories\UserInterface;
use App\Infrastructure\Persistence\Eloquent\AccountRepository;
use App\Infrastructure\Persistence\Eloquent\TransfersRepository;
use App\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(AccountInterface::class, AccountRepository::class);
        $this->app->bind(TransfersInterface::class, TransfersRepository::class);
    }
}
