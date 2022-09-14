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
 * Class Word
 *
 * @property \App\Models\Word $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Word extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Світлини';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(100, function () {
            return \App\Models\Word::count();
        })->setIcon('fas fa-info-circle');
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
            AdminColumn::link('title', 'Назва')->setSearchCallback(function ($column, $query, $search) {
                return $query ->orWhere('title', 'like', '%' . $search . '%');
            })->setOrderable(function ($query, $direction) {
                $query->orderBy('created_at', $direction);
            })->setHtmlAttribute('class', 'text-center'),
            AdminColumn::image('photo', 'Фото')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Video', function(\Illuminate\Database\Eloquent\Model $model) {
                if($model->video){
                     return '
                     <video  controls="controls" width="150" >
                         <source id=\'mp4\' src="/'.$model->video.'" type=\'video/mp4\' />
                     </video>
                     ';
                }else{
                   return 'Не загружено';
                }
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            AdminColumnEditable::checkbox('status')->setLabel('Опублікувати'),
            AdminColumn::text('created_at', 'Створено/оновлено', 'updated_at')
                ->setOrderable(function ($query, $direction) {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(true)
            ->paginate(50)
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
                AdminFormElement::text('title', 'Заголовок'),
                AdminFormElement::wysiwyg('description', 'Опис'),
                AdminFormElement::checkbox('show_title', 'Виводити опис та заголовок на сайті'),
                AdminFormElement::image('photo', 'Фото'),
                AdminFormElement::file('video', 'Video'),
                AdminFormElement::text('meta_title', 'meta_title(SEO)')->required(),
                AdminFormElement::textarea('meta_description', 'meta_description(SEO)')->required(),
                AdminFormElement::text('slug', 'slug(SEO)')->setReadOnly(true),
                AdminFormElement::checkbox('status', 'Опублікувати'),
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
