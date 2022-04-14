<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PersonNotificationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PersonNotificationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PersonNotificationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PersonNotification::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/person-notification');
        CRUD::setEntityNameStrings('Person Notification', 'Person Notifications');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        CRUD::addColumn(['name' => 'person.name', 'type' => 'text', 'title' => 'Name']);
        CRUD::addColumn(['name' => 'person.phone', 'type' => 'text', 'title' => 'Phone']);
        CRUD::addColumn(['name' => 'rss_item.rss.name', 'type' => 'text', 'title' => 'Rss']);
        CRUD::addColumn(['name' => 'rss_item.title', 'type' => 'text', 'title' => 'Title']);
        CRUD::addColumn(['name' => 'status', 'type' => 'number', 'title' => 'Status']);
        CRUD::addColumn(['name' => 'active', 'type' => 'check', 'title' => 'Active']);
        CRUD::addColumn(['name' => 'created_at', 'type' => 'date_time', 'title' => 'Created at']);
        CRUD::addColumn(['name' => 'updated_at', 'type' => 'date_time', 'title' => 'Updated at']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PersonNotificationRequest::class);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
