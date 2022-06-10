<?php

namespace App\Http\Admin;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class Welcome
 *
 * @property \App\Models\Welcome $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Welcome extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title="Привітання із форми";

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(700)->setIcon('fa fa-address-book');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumnEditable::text('title')->setLabel('Назва')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('holiday.title', 'Свято')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom("Користувач", function(\Illuminate\Database\Eloquent\Model $model) {
                if($model->user){
                    return $model->user->name.' '.$model->user->email;
                }else{
                    return $model->name.' '.$model->email;
                }
            })->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Вітання', function(\Illuminate\Database\Eloquent\Model $model){
               return  \Str::words($model->welcome, 10);
            })->setWidth('300px')->setHtmlAttribute('class', 'text-center'),
            AdminColumnEditable::checkbox('status')->setLabel('Опублікувати в записах для календаря')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom("Стан", function(\Illuminate\Database\Eloquent\Model $model) {
                if($model->status==1){
                    return '<div class="text-info">Опубліковано</div>';
                }else{
                    return '<div class="text-danger">Не опубліковано</div>';
                }
            })->setHtmlAttribute('class', 'text-center'),
        ];
        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');
        return $display;

    }

    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([

                AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model){
                    if($model->user){
                        echo '<p class="text-info">Надіслав '. $model->user->name.' '.$model->user->email.'</p>';
                    }else{
                        echo '<p class="text-info">Надіслав '. $model->name.' '.$model->email.'</p>';
                    }
                }),
                AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model){
                    if($model->post_id){
                        echo '<a class="btn btn-outline-primary" href="/admin/posts/'.$model->post_id.'/edit">Редагувати в записах </a>';
                    }
                }),

                AdminFormElement::text('title', 'Заголовок')->required(),
                AdminFormElement::textarea('welcome', 'Вітання')->required(),
//                AdminFormElement::date('date', 'Дата')->required(),
                AdminFormElement::select('holiday_id', 'Свято', \App\Models\Holiday::class)->setDisplay('title')->required(),

                AdminFormElement::image('photo', 'Фото'),
                AdminFormElement::checkbox('status', 'Опублікувати в записах для календаря'),
            ])
        ]);
        $form->getButtons()->setButtons([
            'save' => new Save(),
            'save_and_close' => new SaveAndClose(),
            'save_and_create' => new SaveAndCreate(),
            'cancel' => (new Cancel()),
        ]);
        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
