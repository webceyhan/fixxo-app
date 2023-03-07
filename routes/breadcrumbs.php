<?php // routes/breadcrumbs.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::macro('resource', function (string $name, string $title, string $parent = null) {

    // define parent model
    $parentModel = null;

    // define parent key
    $parentKey = "{$parent}_id";

    // define parent route
    $parentRoute = $parent ? Str::plural($parent) . ".show" : null;

    // get the parent model if available
    if (request()->has($parentKey)) {
        $parentId = request()->input($parentKey);
        $parentModelClass = "App\\Models\\" . Str::studly($parent);
        $parentModel = $parentModelClass::find($parentId);
    }

    // Home > Assets
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('home');
        $trail->push($title, route("{$name}.index"));
    });

    // Home > Customers > [Customer] > New Asset
    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name, $title, $parentModel, $parentRoute) {
        $trail->parent($parentRoute ?? "{$name}.index", $parentModel);
        $trail->push('New ' . Str::singular($title), route("{$name}.create"));
    });

    // Home > Customers > [Customer] > [Asset]
    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, Model $model) use ($name, $title, $parent, $parentRoute) {
        // if the model has a parent, use the parent's title
        $parentModel = $parent ? $model->{$parent} : null;

        // try to get the title from the model
        $dynamicTitle = $model->name ?? Str::singular($title) . " #{$model->id}";

        // if the model has a parent, use the parent's title
        $trail->parent($parentRoute ?? "{$name}.index", $parentModel);
        $trail->push($dynamicTitle, route("{$name}.show", $model));
    });

    // Home > Customers > [Customer] > [Asset] > Edit Asset
    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, Model $model) use ($name, $title) {
        $trail->parent("{$name}.show", $model);
        $trail->push('Edit ' . Str::singular($title), route("{$name}.edit", $model));
    });
});

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Profile
Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Profile', route('profile.edit'));
});


Breadcrumbs::resource('users', 'Users');
Breadcrumbs::resource('customers', 'Customers');
Breadcrumbs::resource('assets', 'Assets', 'customer');
Breadcrumbs::resource('tasks', 'Tasks', 'asset');
Breadcrumbs::resource('payments', 'Payments', 'asset');
