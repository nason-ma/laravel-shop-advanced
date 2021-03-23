<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Tools;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header('商品列表');
            $content->body($this->grid());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        // 使用 with 来预加载商品类目数据，减少 SQL 查询
        $grid->model()->where('type', Product::TYPE_NORMAL)->with(['category']);
        $grid->column('id', __('Id'))->sortable();
        $grid->column('image', __('封面图'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('title', __('商品名称'));
        // Laravel-Admin 支持用符号 . 来展示关联关系的字段
        $grid->column('category.name', __('类目'));
        // $grid->column('description', __('详情'));
        $grid->column('on_sale', __('已上架'))->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->column('price', __('价格'));
        $grid->column('rating', __('评分'));
        $grid->column('sold_count', __('销量'));
        $grid->column('review_count', __('评论数'));
        $grid->column('created_at', __('添加时间'));
        // $grid->column('updated_at', __('修改时间'));
        $grid->actions(function (Actions $actions) {
            // 不在每一行展示查看按钮
            $actions->disableView();
            // 不在每一行展示删除按钮
            $actions->disableDelete();
        });
        $grid->tools(function (Tools $tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    public function create(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header('创建商品');
            $content->body($this->form());
        });
    }

    public function edit($id, Content $content)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑商品');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        // 创建一个菜单
        $form = new Form(new Product());

        // 在表单中添加一个名为 type，值为 Product::TYPE_NORMAL 的隐藏字段
        $form->hidden('type')->value(Product::TYPE_NORMAL);
        // 创建一个输入框，第一个参数 title 是模型的字段名，第二个参数是该字段描述
        $form->text('title', __('商品名称'))->rules('required');
        // 添加一个类目字段，与之前类目管理类似，使用 Ajax 的方式来搜索添加
        $form->select('category_id', '类目')->options(function ($id) {
            $category = Category::find($id);
            if ($category) {
                return [$category->id => $category->full_name];
            }
        })->ajax('/admin/api/categories?is_directory=0');
        // 创建一个选择图片的框
        $form->image('image', __('封面图片'))->rules('required|image');
        // 创建一个富文本编辑器， 富文本编辑组件在v1.7.0版本之后移除
        $form->ueditor('description', __('商品描述'))->rules('required');
        // 创建一组单选框
        $form->radio('on_sale', __('上架'))->options(['1' => '是', '0' => '否'])->default('0');

        // 直接添加一对多的关联模型
        $form->hasMany('skus', 'SKU 列表', function (NestedForm $form) {
            $form->text('title', 'SKU 名称')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '单价')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩余库存')->rules('required|integer|min:0');
        });

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });

        return $form;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
        $show->field('on_sale', __('On sale'));
        $show->field('rating', __('Rating'));
        $show->field('sold_count', __('Sold count'));
        $show->field('review_count', __('Review count'));
        $show->field('price', __('Price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

}
