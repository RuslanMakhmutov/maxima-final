<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('posts', function ($user) {
    return \Illuminate\Support\Facades\Auth::check() && $user->hasRole('admin');
});
Broadcast::channel('categories', function ($user) {
    return \Illuminate\Support\Facades\Auth::check() && $user->hasRole('admin');
});
