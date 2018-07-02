<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;

class CardController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('header');
            $content->description('description');
            
            $series = DB::select('select series from pm_subcategory GROUP BY series ORDER BY releaseDate desc');
            $symbol = DB::table('pm_subcategory')->orderBy('releaseDate', 'desc')->get();

            $list = DB::table('pm_card')
                    ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                    ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                    ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                    ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                    ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                    ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card_title.title', 'pm_card.img', 'pm_subcategory.name as cate', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp')
                    ->orderBy('pm_subcategory.releaseDate', 'desc')
                    ->orderBy('pm_card.subId', 'asc')
                    ->paginate(24); 

            $content->body(view('admin.card', [ 'list' => $list, 'series' => $series, 'symbol' => $symbol ]));
        });
    }

    public function show($id)
    {
        dump($id);
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');
            $series = DB::select('select series from pm_subcategory GROUP BY series ORDER BY releaseDate desc');
            $symbol = DB::table('pm_subcategory')->orderBy('releaseDate', 'desc')->get();

            $list = DB::table('pm_card')
                    ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                    ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                    ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                    ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                    ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                    ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card_title.title', 'pm_card.img', 'pm_subcategory.name as cate', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp')
                    ->orderBy('pm_subcategory.releaseDate', 'desc')
                    ->orderBy('pm_card.subId', 'asc')->when($id, function ($query) use ($id) {
                                return $query->where('symbol', $id);
                            })
                    ->paginate(24);
            $content->body(view('admin.card', [ 'list' => $list, 'series' => $series, 'symbol' => $symbol ]));
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('卡片编辑');

            $card = (int) $id;
            $info = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type', 'pm_card.type', '=', 'pm_card_type.id')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                ->leftJoin('pm_illustrator', 'pm_card.illustrator', '=', 'pm_illustrator.id')
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card.pmId','pm_card.titleId', 'pm_card_title.title', 'pm_card.img', 'pm_card.type', 'pm_card_type.name as typeName', 'pm_subcategory.name as cate', 'pm_card.rarity', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp', 'pm_description.lv', 'pm_description.evolve', 'pm_description.weakness', 'pm_description.resistance', 'pm_description.retreat', 'pm_subcategory.name as illustratorName', 'pm_card.link')
                ->where('pm_card.cardId', $card)->first();

            $abilitys = DB::table('pm_ability as a')
                    ->leftJoin('pm_power_title as t', 'a.abilitytitle', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'a.abilitycontent', '=', 'c.id')
                    ->leftJoin('pm_power_title as t2', 'a.bodytitle', '=', 't2.id')
                    ->leftJoin('pm_power_content as c2', 'a.bodycontent', '=', 'c2.id')
                    ->leftJoin('pm_rule as r', 'a.exId', '=', 'r.id')
                    ->select('t.id as abilityId', 't.title as abilityName', 'c.id as abilityContentId', 'c.content as abilityContent', 'c.status as contentStatus', 't.title_en as abilityNameEn', 'c.content_en as abilityContentEn', 'a.restored', 'a.exId', 'a.exObject', 'r.title as ruleName', 'r.content as ruleContent','t2.id as bodyId', 't2.title as bodyName', 't2.title_en as bodyNameEn', 'c2.id as bodyContentId', 'c2.content as bodyContent', 'c2.content_en as bodyContentEn', 'c2.status as contentStatus2', 'a.LV', 'a.BODY2')
                    ->where('a.cardId', $card)->first();
            $power = DB::table('pm_ability_power as p')
                    ->leftJoin('pm_power_title as t', 'p.title', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'p.content', '=', 'c.id')
                    ->select('p.id', 'p.cardId', 'p.cost', 'p.damage','t.id as tId', 't.title','c.id as cId', 'c.content', 't.title_en', 'c.content_en', 'c.status as contentStatus')
                    ->where('p.cardId', $card)->orderBy('p.id')->get();
            $content->body(view('admin.cardEdit',[ 'info' => $info, 'abilitys' => $abilitys, 'power' => $power ]));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->email('邮箱');
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '用户名');
            $form->password('password', trans('admin::lang.password'));
            $form->password('password_confirmation', trans('admin::lang.password_confirmation'))
                ->default(function ($form) {
                    return $form->model()->password;
                });
            $form->ignore(['password_confirmation']);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }
}
