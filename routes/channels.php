<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


use App\Models\StockProduct;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

\Illuminate\Support\Facades\Broadcast::channel('sporoducts', function ($user) {
    return true;
});

Broadcast::channel('stock-product.{stockProduct}', function ($user, StockProduct $stockProduct) {
    return true;
});