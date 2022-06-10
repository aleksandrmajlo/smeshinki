<?php

namespace App\Http\Admin;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
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
 * Class Calendar
 *
 * @property \App\Models\Calendar $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Calendar extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title='Дати';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
//        $this->addToNavigation()->setPriority(300)->setIcon('fa fa-calendar');
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

//            AdminColumn::link('title', 'Назва')->setSearchCallback(function ($column, $query, $search) {
//                return $query ->orWhere('title', 'like', '%' . $search . '%');
//            })->setOrderable(function ($query, $direction) {
//                $query->orderBy('created_at', $direction);
//            })->setHtmlAttribute('class', 'text-center'),
            AdminColumn::datetime('date', 'Дата')->setFormat('d.m.Y')->setHtmlAttribute('class', 'text-center text-nowrap'),
            AdminColumn::lists('holidays.title', 'Cвята')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('typecalendar.title', 'Тип')->setHtmlAttribute('class', 'text-center text-nowrap'),
        ];
        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[1, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(250)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');
        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([

                AdminFormElement::date('date', 'Дата')->required(),
                AdminFormElement::select('typecalendar_id', 'Тип', \App\Models\Typecalendar::class)->setDisplay('title')->required(),

                AdminFormElement::multiselect('holidays', 'Свята для цього дня', \App\Models\Holiday::class)->setDisplay('title'),
                AdminFormElement::checkbox('repeat','повторювати щороку'),
                AdminFormElement::text('title', 'Заголовок (SEO)'),
                AdminFormElement::text('meta_title', 'meta_title(SEO)'),
                AdminFormElement::textarea('meta_description', 'meta_description(SEO)'),
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
