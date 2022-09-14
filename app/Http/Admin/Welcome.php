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
    protected $title = "Контент із форми";

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
            AdminColumn::text('title-type')->setLabel('Тип')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('title')->setLabel('Назва')->setHtmlAttribute('class', 'text-center'),
//            AdminColumn::text('holiday.title', 'Свято')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom("Користувач", function (\Illuminate\Database\Eloquent\Model $model) {
//                if($model->user){
                return $model->user->email;
//                }else{
//                    return $model->name.' '.$model->email;
//                }
            })->setHtmlAttribute('class', 'text-center'),
//            AdminColumn::custom('Вітання', function(\Illuminate\Database\Eloquent\Model $model){
//               return  \Str::words($model->welcome, 10);
//            })->setWidth('300px')->setHtmlAttribute('class', 'text-center'),
//            AdminColumnEditable::checkbox('status')->setLabel('Опублікувати')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom("Стан", function (\Illuminate\Database\Eloquent\Model $model) {
                if ($model->status == 1) {
                    return '<div class="text-info">Опубліковано</div>';
                } else {
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
        $welcome = \App\Models\Welcome::find($id);
        if ($welcome->post_id) {
            $text = '';

            $text .='<p class="text-bold">
                                Матеріал '.$welcome->title.' опубліковано:
                             </p>
                        ';

            switch ($welcome->type) {
                case 'posts' :
                    $text .='<a class="btn btn-outline-primary" href="/admin/posts/' . $welcome->post_id . '/edit">Редагувати в ' . $welcome->title_type . ' </a>';
                    break;

                case 'anecdotes' :
                    $text .='<a class="btn btn-outline-primary" href="/admin/anecdotes/' . $welcome->post_id . '/edit">Редагувати в ' . $welcome->title_type . ' </a>';
                    break;
                case 'words' :
                    $text .='<a class="btn btn-outline-primary" href="/admin/words/' . $welcome->post_id . '/edit">Редагувати в ' . $welcome->title_type . ' </a>';
                    break;
            }
            return $text;

        } else {

            $form = AdminForm::card()->addBody([
                AdminFormElement::columns()->addColumn([

                    AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model) {
                        echo '<p class="text-info">Тип: ' . $model->title_type . '</p>';
                    }),
                    AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model) {
//                    if($model->user){
                        echo '<p class="text-info">Надіслав: ' . $model->user->email . '</p>';
//                    }else{
//                        echo '<p class="text-info">Надіслав '. $model->name.' '.$model->email.'</p>';
//                    }
                    }),
//                    AdminFormElement::checkbox('status', 'Опублікувати '),
//                    AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model) {
//                        if ($model->post_id) {
//                        }
//                    }),
                    AdminFormElement::text('title', 'Заголовок')->required(),
                    AdminFormElement::textarea('welcome', 'Текст'),
                    AdminFormElement::image('photo', 'Фото'),
                    AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model) {
                        echo '<hr/> 
                         <p>Для типу привітання свято:</p>
                       ';
                    }),
                    AdminFormElement::select('holiday_id', 'Свято', \App\Models\Holiday::class)->setDisplay('title'),
                    AdminFormElement::html(function (\Illuminate\Database\Eloquent\Model $model) {
                        echo '<button type="submit" name="next_action" value="save_and_continue" class="btn btn-primary"><i class="fas fa-save"></i> Опублікувати в ' . $model->title_type . '</button>';
                    }, function (\Illuminate\Database\Eloquent\Model $item) {

                        $post_id = null;
                        switch ($item->type) {
                            case 'posts' :

                                $post = new \App\Models\Post;
                                $post->title = $item->title;
                                $post->meta_title = $item->title;
                                $post->meta_description = $item->title;
                                $post->text = $item->welcome;
                                $post->photo = $item->photo;
                                $post->holiday_id = $item->holiday_id;
                                $post->save();
                                $post_id = $post->id;
                                break;

                            case 'anecdotes' :

                                $anecdote = new \App\Models\Anecdote;
                                $anecdote->title = $item->title;
                                $anecdote->description = $item->welcome;
                                $anecdote->meta_title = $item->title;
                                $anecdote->meta_description = $item->title;
                                $anecdote->save();
                                $post_id = $anecdote->id;
                                break;

                            case 'words' :

                                $word = new \App\Models\Word;
                                $word->title = $item->title;
                                $word->photo = $item->photo;
                                $word->meta_title = $item->title;
                                $word->meta_description = $item->title;
                                $word->save();
                                $post_id = $word->id;

                                break;
                        }
                        \DB::table('welcomes')
                            ->where('id', $item->id)
                            ->update([
                                'post_id' => $post_id,
                                'status' => 1
                            ]);

                        return redirect()->back();

                    })
                ])
            ]);
            $form->getButtons()->setButtons([
//                'save' => new Save(),
            ]);
            return $form;

        }

    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
//        return $this->onEdit(null, $payload);
        return abort('403');
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
