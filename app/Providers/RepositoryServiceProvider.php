<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $webInterfacesAndRepositories = [
            'CategoryInterface' => 'CategoryRepository',
            'ColorInterface' => 'ColorRepository',
            'ProductInterface' => 'ProductRepository',
            'AdInterface' => 'AdsRepository',
            'SizeInterface' => 'SizeRepository',
            'BrandInterface' => 'BrandRepository',
            'UserAddressesInterface' => 'UserAddressesRepository',
            'OrderInterface' => 'OrderRepository',
        ];

        foreach ($webInterfacesAndRepositories as $key => $value) {
            $this->app->bind(
                "App\Http\Interfaces\\$key",
                "App\Http\Repositories\\$value"
            );
        }
    }
}
